<?php

namespace App\Livewire\Doctor;

use App\Models\DoctorDocument;
use App\Models\DocumentType;
use App\Notifications\DocumentNotification;
use App\Traits\HasToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]
class DocumentsComponent extends Component
{
    use HasToast, WithFileUploads;

    public $showUploadModal = false;
    public $showEditModal = false;
    public $selectedDocumentType = '';
    public $documentFile;
    public $notes = '';
    public $editingDocument = null;
    public $editNotes = '';

    protected $rules = [
        'selectedDocumentType' => 'required|exists:document_types,id',
        'documentFile' => 'required|file|max:10240', // 10MB max
        'notes' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'selectedDocumentType.required' => 'Please select a document type.',
        'selectedDocumentType.exists' => 'Selected document type does not exist.',
        'documentFile.required' => 'Please select a file to upload.',
        'documentFile.file' => 'Please select a valid file.',
        'documentFile.max' => 'File size must not exceed 10MB.',
    ];

    public function openUploadModal()
    {
        $this->showUploadModal = true;
        $this->reset(['selectedDocumentType', 'documentFile', 'notes']);
    }

    public function closeUploadModal()
    {
        $this->showUploadModal = false;
        $this->reset(['selectedDocumentType', 'documentFile', 'notes']);
        $this->resetErrorBag();
    }

    public function openEditModal($documentId)
    {
        $this->editingDocument = DoctorDocument::find($documentId);
        if ($this->editingDocument) {
            $this->editNotes = $this->editingDocument->notes ?? '';
            $this->showEditModal = true;
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingDocument = null;
        $this->editNotes = '';
        $this->resetErrorBag();
    }

    public function uploadDocument()
    {
        $this->validate();

        try {
            $documentType = DocumentType::find($this->selectedDocumentType);
            
            // Generate unique filename
            $originalFilename = $this->documentFile->getClientOriginalName();
            $extension = $this->documentFile->getClientOriginalExtension();
            $storedFilename = time() . '_' . uniqid() . '.' . $extension;
            
            // Store file
            $filePath = $this->documentFile->storeAs('doctor-documents', $storedFilename, 'public');
            
            // Create document record
            $document = DoctorDocument::create([
                'user_id' => Auth::id(),
                'document_type_id' => $this->selectedDocumentType,
                'original_filename' => $originalFilename,
                'stored_filename' => $storedFilename,
                'file_path' => $filePath,
                'file_size_bytes' => $this->documentFile->getSize(),
                'mime_type' => $this->documentFile->getMimeType(),
                'file_hash' => hash_file('sha256', $this->documentFile->path()),
                'upload_date' => now(),
                'is_verified' => false,
                'is_current' => true,
                'notes' => $this->notes,
            ]);

            // Send notification
            Auth::user()->notify(new DocumentNotification($document, 'uploaded'));

            $this->toastSuccess('Document uploaded successfully!');
            $this->closeUploadModal();
            
            // Emit event to refresh notifications
            $this->dispatch('refresh-notifications');
            
        } catch (\Exception $e) {
            $this->toastError('Failed to upload document: ' . $e->getMessage());
        }
    }

    public function updateDocument()
    {
        $this->validate([
            'editNotes' => 'nullable|string|max:1000',
        ]);

        try {
            if ($this->editingDocument) {
                $this->editingDocument->update([
                    'notes' => $this->editNotes,
                ]);

                $this->toastSuccess('Document updated successfully!');
                $this->closeEditModal();
            }
        } catch (\Exception $e) {
            $this->toastError('Failed to update document: ' . $e->getMessage());
        }
    }

    public function deleteDocument($documentId)
    {
        try {
            $document = DoctorDocument::find($documentId);
            if ($document && $document->user_id === Auth::id()) {
                // Delete file from storage
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }
                
                $document->delete();
                $this->toastSuccess('Document deleted successfully!');
            }
        } catch (\Exception $e) {
            $this->toastError('Failed to delete document: ' . $e->getMessage());
        }
    }

    public function downloadDocument($documentId)
    {
        try {
            $document = DoctorDocument::find($documentId);
            if ($document && $document->user_id === Auth::id()) {
                if (Storage::disk('public')->exists($document->file_path)) {
                    return Storage::disk('public')->download($document->file_path, $document->original_filename);
                }
            }
            
            $this->toastError('File not found!');
        } catch (\Exception $e) {
            $this->toastError('Failed to download document: ' . $e->getMessage());
        }
    }

    public function getDocumentTypesProperty()
    {
        return DocumentType::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function getDocumentsProperty()
    {
        return DoctorDocument::with('documentType')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function formatFileSize($bytes)
    {
        if ($bytes === 0) return '0 Bytes';
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }

    public function render()
    {
        return view('livewire.doctor.documents-component', [
            'documentTypes' => $this->documentTypes,
            'documents' => $this->documents,
        ]);
    }
}
