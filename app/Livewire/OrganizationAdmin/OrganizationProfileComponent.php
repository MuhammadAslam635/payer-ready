<?php

namespace App\Livewire\OrganizationAdmin;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\State;
use App\Models\Address;
use App\Models\OrganizationLicense;
use App\Models\OrganizationCertificate;
use App\Models\DoctorDocument;
use App\Models\DocumentType;
use App\Notifications\DocumentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasToast;
use Livewire\WithFileUploads;
use App\Enums\UserType;

#[Title('Organization Profile')]
#[Layout('layouts.dashboard')]
class OrganizationProfileComponent extends Component
{
    use HasToast, WithFileUploads;

    public $activeTab = 'information';
    public $states = [];
    
    // Organization Information fields
    public $organization_type = '';
    public $business_name = '';
    public $dba_name = '';
    public $tax_id = '';
    public $npi_number = '';
    public $address = '';
    public $address_state_id = '';
    public $address_country = 'US';
    public $phone = '';
    public $fax_number = '';
    public $taxonomy_code = '';
    public $website = '';
    
    // Organization License fields
    public $org_license_number = '';
    public $org_license_issue_date = '';
    public $org_license_expiry_date = '';
    public $org_license_issuing_authority = '';
    public $org_licenses = [];
    public $editingLicenseId = null;
    
    // Organization Certificate fields
    public $org_certificate_number = '';
    public $org_certificate_issue_date = '';
    public $org_certificate_expiry_date = '';
    public $org_certificate_issuing_organization = '';
    public $org_certificates = [];
    public $editingCertificateId = null;
    
    // Portal fields
    public $nppes_login = '';
    public $nppes_password = '';
    public $availity_login = '';
    public $availity_password = '';
    public $caqh_id = '';
    public $caqh_login = '';
    public $caqh_password = '';
    
    // Password visibility toggles
    public $showNppesPassword = false;
    public $showCaqhPassword = false;
    public $showAvailityPassword = false;
    
    // Providers list
    public $providers = [];
    
    // Document Upload
    public $showUploadModal = false;
    public $showEditModal = false;
    public $selectedDocumentType = '';
    public $documentFile;
    public $notes = '';
    public $editingDocument = null;
    public $editNotes = '';
    public $documents = [];

    public function mount()
    {
        $this->loadProfile();
        $this->states = State::orderBy('name')->get();
        $this->loadLicenses();
        $this->loadCertificates();
        $this->loadProviders();
        $this->loadDocuments();
    }

    public function loadProfile()
    {
        $user = Auth::user();
        
        // Load organization information
        $this->organization_type = $user->organization_type ?? '';
        $this->business_name = $user->business_name ?? '';
        $this->dba_name = $user->dba_name ?? '';
        $this->tax_id = $user->tax_id ?? '';
        $this->npi_number = $user->npi_number ?? '';
        $this->phone = $user->phone ?? '';
        $this->fax_number = $user->fax_number ?? '';
        $this->taxonomy_code = $user->taxonomy_code ?? '';
        $this->website = $user->website ?? '';
        $this->nppes_login = $user->nppes_login ?? '';
        $this->nppes_password = $user->nppes_password ?? '';
        $this->availity_login = $user->availity_login ?? '';
        $this->availity_password = $user->availity_password ?? '';
        $this->caqh_id = $user->caqh_id ?? '';
        $this->caqh_login = $user->caqh_login ?? '';
        $this->caqh_password = $user->caqh_password ?? '';
        
        // Load address
        $primaryAddress = $user->addresses()->where('is_primary', true)->first();
        if ($primaryAddress) {
            $this->address = $primaryAddress->address ?? '';
            $this->address_state_id = $primaryAddress->state_id ? (string)$primaryAddress->state_id : '';
            $this->address_country = $primaryAddress->country ?? 'US';
        }
    }

    public function loadLicenses()
    {
        $this->org_licenses = OrganizationLicense::where('user_id', Auth::id())
            ->orderBy('expiration_date', 'desc')
            ->get();
    }

    public function loadCertificates()
    {
        $this->org_certificates = OrganizationCertificate::where('user_id', Auth::id())
            ->orderBy('expiration_date', 'desc')
            ->get();
    }

    public function loadProviders()
    {
        $this->providers = User::where('org_id', Auth::id())
            ->where('user_type', UserType::DOCTOR)
            ->select('id', 'name', 'npi_number', 'phone', 'email', 'caqh_id')
            ->orderBy('name')
            ->get();
    }

    public function loadDocuments()
    {
        $this->documents = DoctorDocument::with('documentType')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function saveOrganizationInformation()
    {
        $this->validate([
            'organization_type' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'tax_id' => 'nullable|string|max:50',
            'npi_number' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'address_state_id' => 'nullable|exists:states,id',
        ]);

        try {
            $user = Auth::user();
            $user->update([
                'organization_type' => $this->organization_type,
                'business_name' => $this->business_name,
                'dba_name' => $this->dba_name,
                'tax_id' => $this->tax_id,
                'npi_number' => $this->npi_number,
                'phone' => $this->phone,
                'fax_number' => $this->fax_number,
                'taxonomy_code' => $this->taxonomy_code,
                'website' => $this->website,
            ]);

            // Update or create address
            if ($this->address) {
                $primaryAddress = $user->addresses()->where('is_primary', true)->first();
                if ($primaryAddress) {
                    $primaryAddress->update([
                        'address' => $this->address,
                        'state_id' => $this->address_state_id ? (int)$this->address_state_id : null,
                        'country' => $this->address_country,
                    ]);
                } else {
                    $user->addresses()->update(['is_primary' => false]);
                    Address::create([
                        'user_id' => $user->id,
                        'address' => $this->address,
                        'state_id' => $this->address_state_id ? (int)$this->address_state_id : null,
                        'country' => $this->address_country,
                        'is_primary' => true,
                    ]);
                }
            }

            $this->toastSuccess('Organization information saved successfully');
            $this->loadProfile();
        } catch (\Exception $e) {
            $this->toastError('Failed to save information: ' . $e->getMessage());
        }
    }

    public function saveLicense()
    {
        $this->validate([
            'org_license_number' => 'required|string|max:255',
            'org_license_issue_date' => 'required|date',
            'org_license_expiry_date' => 'required|date|after:org_license_issue_date',
        ]);

        try {
            if ($this->editingLicenseId) {
                $license = OrganizationLicense::findOrFail($this->editingLicenseId);
                if ($license->user_id !== Auth::id()) {
                    $this->toastError('Unauthorized access');
                    return;
                }
                $license->update([
                    'license_number' => $this->org_license_number,
                    'issue_date' => $this->org_license_issue_date,
                    'expiration_date' => $this->org_license_expiry_date,
                    'issuing_authority' => $this->org_license_issuing_authority,
                ]);
                $this->toastSuccess('License updated successfully');
            } else {
                OrganizationLicense::create([
                    'user_id' => Auth::id(),
                    'license_number' => $this->org_license_number,
                    'issue_date' => $this->org_license_issue_date,
                    'expiration_date' => $this->org_license_expiry_date,
                    'issuing_authority' => $this->org_license_issuing_authority,
                ]);
                $this->toastSuccess('License added successfully');
            }

            $this->resetLicenseForm();
            $this->loadLicenses();
        } catch (\Exception $e) {
            $this->toastError('Failed to save license: ' . $e->getMessage());
        }
    }

    public function editLicense($id)
    {
        $license = OrganizationLicense::findOrFail($id);
        if ($license->user_id !== Auth::id()) {
            $this->toastError('Unauthorized access');
            return;
        }

        $this->editingLicenseId = $license->id;
        $this->org_license_number = $license->license_number;
        $this->org_license_issue_date = $license->issue_date ? $license->issue_date->format('Y-m-d') : '';
        $this->org_license_expiry_date = $license->expiration_date ? $license->expiration_date->format('Y-m-d') : '';
        $this->org_license_issuing_authority = $license->issuing_authority ?? '';
    }

    public function deleteLicense($id)
    {
        try {
            $license = OrganizationLicense::findOrFail($id);
            if ($license->user_id !== Auth::id()) {
                $this->toastError('Unauthorized access');
                return;
            }
            $license->delete();
            $this->toastSuccess('License deleted successfully');
            $this->loadLicenses();
        } catch (\Exception $e) {
            $this->toastError('Failed to delete license: ' . $e->getMessage());
        }
    }

    public function resetLicenseForm()
    {
        $this->editingLicenseId = null;
        $this->org_license_number = '';
        $this->org_license_issue_date = '';
        $this->org_license_expiry_date = '';
        $this->org_license_issuing_authority = '';
        $this->resetValidation();
    }

    public function saveCertificate()
    {
        $this->validate([
            'org_certificate_number' => 'required|string|max:255',
            'org_certificate_issue_date' => 'required|date',
            'org_certificate_expiry_date' => 'required|date|after:org_certificate_issue_date',
        ]);

        try {
            if ($this->editingCertificateId) {
                $certificate = OrganizationCertificate::findOrFail($this->editingCertificateId);
                if ($certificate->user_id !== Auth::id()) {
                    $this->toastError('Unauthorized access');
                    return;
                }
                $certificate->update([
                    'certificate_number' => $this->org_certificate_number,
                    'issue_date' => $this->org_certificate_issue_date,
                    'expiration_date' => $this->org_certificate_expiry_date,
                    'issuing_organization' => $this->org_certificate_issuing_organization,
                ]);
                $this->toastSuccess('Certificate updated successfully');
            } else {
                OrganizationCertificate::create([
                    'user_id' => Auth::id(),
                    'certificate_number' => $this->org_certificate_number,
                    'issue_date' => $this->org_certificate_issue_date,
                    'expiration_date' => $this->org_certificate_expiry_date,
                    'issuing_organization' => $this->org_certificate_issuing_organization,
                ]);
                $this->toastSuccess('Certificate added successfully');
            }

            $this->resetCertificateForm();
            $this->loadCertificates();
        } catch (\Exception $e) {
            $this->toastError('Failed to save certificate: ' . $e->getMessage());
        }
    }

    public function editCertificate($id)
    {
        $certificate = OrganizationCertificate::findOrFail($id);
        if ($certificate->user_id !== Auth::id()) {
            $this->toastError('Unauthorized access');
            return;
        }

        $this->editingCertificateId = $certificate->id;
        $this->org_certificate_number = $certificate->certificate_number;
        $this->org_certificate_issue_date = $certificate->issue_date ? $certificate->issue_date->format('Y-m-d') : '';
        $this->org_certificate_expiry_date = $certificate->expiration_date ? $certificate->expiration_date->format('Y-m-d') : '';
        $this->org_certificate_issuing_organization = $certificate->issuing_organization ?? '';
    }

    public function deleteCertificate($id)
    {
        try {
            $certificate = OrganizationCertificate::findOrFail($id);
            if ($certificate->user_id !== Auth::id()) {
                $this->toastError('Unauthorized access');
                return;
            }
            $certificate->delete();
            $this->toastSuccess('Certificate deleted successfully');
            $this->loadCertificates();
        } catch (\Exception $e) {
            $this->toastError('Failed to delete certificate: ' . $e->getMessage());
        }
    }

    public function resetCertificateForm()
    {
        $this->editingCertificateId = null;
        $this->org_certificate_number = '';
        $this->org_certificate_issue_date = '';
        $this->org_certificate_expiry_date = '';
        $this->org_certificate_issuing_organization = '';
        $this->resetValidation();
    }

    public function savePortalLogins()
    {
        try {
            $user = Auth::user();
            $user->update([
                'nppes_login' => $this->nppes_login,
                'nppes_password' => $this->nppes_password,
                'availity_login' => $this->availity_login,
                'availity_password' => $this->availity_password,
                'caqh_id' => $this->caqh_id,
                'caqh_login' => $this->caqh_login,
                'caqh_password' => $this->caqh_password,
            ]);

            $this->toastSuccess('Portal logins saved successfully');
        } catch (\Exception $e) {
            $this->toastError('Failed to save portal logins: ' . $e->getMessage());
        }
    }

    public function openUploadModal()
    {
        $this->showUploadModal = true;
        $this->reset(['selectedDocumentType', 'documentFile', 'notes']);
        $this->resetErrorBag();
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
        if ($this->editingDocument && $this->editingDocument->user_id === Auth::id()) {
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
        $this->validate([
            'selectedDocumentType' => 'required|exists:document_types,id',
            'documentFile' => 'required|file|max:10240', // 10MB max
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $documentType = DocumentType::find($this->selectedDocumentType);
            
            $originalFilename = $this->documentFile->getClientOriginalName();
            $extension = $this->documentFile->getClientOriginalExtension();
            $storedFilename = time() . '_' . uniqid() . '.' . $extension;
            
            $filePath = $this->documentFile->storeAs('doctor-documents', $storedFilename, 'public');
            
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

            Auth::user()->notify(new DocumentNotification($document, 'uploaded'));

            $this->toastSuccess('Document uploaded successfully!');
            $this->closeUploadModal();
            $this->loadDocuments();
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
            if ($this->editingDocument && $this->editingDocument->user_id === Auth::id()) {
                $this->editingDocument->update([
                    'notes' => $this->editNotes,
                ]);

                $this->toastSuccess('Document updated successfully!');
                $this->closeEditModal();
                $this->loadDocuments();
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
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }
                
                $document->delete();
                $this->toastSuccess('Document deleted successfully!');
                $this->loadDocuments();
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

    public function formatFileSize($bytes)
    {
        if ($bytes === 0) return '0 Bytes';
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }

    public function getOrganizationTypesProperty()
    {
        return [
            'Corporation' => 'Corporation',
            'LLC' => 'Limited Liability Company (LLC)',
            'Partnership' => 'Partnership',
            'Sole Proprietorship' => 'Sole Proprietorship',
            'Non-Profit' => 'Non-Profit',
            'HHA' => 'Home Health Agency (HHA)',
            'DME' => 'Durable Medical Equipment (DME)',
            'SNF' => 'Skilled Nursing Facility (SNF)',
            'CMHC' => 'Community Mental Health Center (CMHC)',
            'Pharmacy' => 'Pharmacy',
        ];
    }

    public function getDocumentTypesProperty()
    {
        return DocumentType::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.organization-admin.organization-profile-component', [
            'organizationTypes' => $this->organizationTypes,
            'documentTypes' => $this->documentTypes,
        ]);
    }
}
