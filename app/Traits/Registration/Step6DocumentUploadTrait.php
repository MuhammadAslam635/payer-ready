<?php

namespace App\Traits\Registration;

use App\Models\DoctorDocument;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

trait Step6DocumentUploadTrait
{
    use WithFileUploads;
    // Step 6: Document Upload Variables
    public $cv = null;
    public $professionalLicense = null;
    public $pictureId = null;
    public $socialSecurityCard = null;
    public $certificateOfLiabilityInsurance = null;
    public $copiesOfDiplomasCertifications = null;
    public $stateCredentialingApplication = null;
    public $passportStylePhoto = null;
    public $ecfmgCertificate = null;
    public $boardCertificate = null;
    public $procedureLog = null;
    public $cmeCs = null;
    public $immunizationShotRecords = null;
    public $aclsBlsCertificate = null;

    /**
     * Validate Step 6: Document Upload
     */
    private function validateStep6DocumentUpload()
    {
        // Only validate if documents are uploaded
        $rules = [];
        $documentFields = ['cv', 'professionalLicense', 'pictureId', 'socialSecurityCard'];

        foreach ($documentFields as $field) {
            if ($this->$field !== null) {
                $rules[$field] = 'file|max:10240'; // 10MB max
            }
        }

        if (!empty($rules)) {
            $this->validate($rules);
        }
    }
    /**
     * Process Step 6: Document Upload data
     */
    public function processStep6DocumentUpload(User $user)
    {
        // Validate step 6 data internally
        $this->validateStep6DocumentUpload();

        Log::info('Processing Step 6: Document Upload', [
            'user_id' => $user->id,
            'has_document_data' => $this->hasDocumentData(),
            'cv' => $this->cv ? 'PROVIDED' : 'NOT_PROVIDED',
            'professional_license' => $this->professionalLicense ? 'PROVIDED' : 'NOT_PROVIDED',
            'picture_id' => $this->pictureId ? 'PROVIDED' : 'NOT_PROVIDED',
            'social_security_card' => $this->socialSecurityCard ? 'PROVIDED' : 'NOT_PROVIDED',
            'certificate_of_liability_insurance' => $this->certificateOfLiabilityInsurance ? 'PROVIDED' : 'NOT_PROVIDED'
        ]);

        if (!$this->hasDocumentData()) {
            Log::info('No document data provided');
            return null;
        }

        $documents = [];

        // Process uploaded documents
        $documents = $this->createDocumentRecords($user);

        Log::info('Step 6 Document Upload processing completed', [
            'user_id' => $user->id,
            'documents_created' => count($documents)
        ]);

        return [
            'documents' => $documents,
        ];
    }

    /**
     * Check if document data is provided
     */
    private function hasDocumentData()
    {
        return $this->cv !== null ||
               $this->professionalLicense !== null ||
               $this->pictureId !== null ||
               $this->socialSecurityCard !== null ||
               $this->certificateOfLiabilityInsurance !== null ||
               $this->copiesOfDiplomasCertifications !== null ||
               $this->stateCredentialingApplication !== null ||
               $this->passportStylePhoto !== null ||
               $this->ecfmgCertificate !== null ||
               $this->boardCertificate !== null ||
               $this->procedureLog !== null ||
               $this->cmeCs !== null ||
               $this->immunizationShotRecords !== null ||
               $this->aclsBlsCertificate !== null;
    }

    /**
     * Create document records
     */
    private function createDocumentRecords($user)
    {
        $documentRecords = [];

        // Map of document properties to document types
        $documentMap = [
            'cv' => 1, // Assuming document type IDs
            'professionalLicense' => 2,
            'pictureId' => 3,
            'socialSecurityCard' => 4,
            'certificateOfLiabilityInsurance' => 5,
            'copiesOfDiplomasCertifications' => 6,
            'stateCredentialingApplication' => 7,
            'passportStylePhoto' => 8,
            'ecfmgCertificate' => 9,
            'boardCertificate' => 10,
            'procedureLog' => 11,
            'cmeCs' => 12,
            'immunizationShotRecords' => 13,
            'aclsBlsCertificate' => 14,
        ];

        foreach ($documentMap as $property => $documentTypeId) {
            $file = $this->$property;
            
            if ($file !== null) {
                try {
                    Log::info('Processing document upload', [
                        'user_id' => $user->id,
                        'document_type' => $documentTypeId,
                        'property' => $property,
                        'file_name' => $file->getClientOriginalName()
                    ]);

                    // Store the file
                    $filePath = $this->storeDocument($file, $user->id);

                    if ($filePath) {
                        $document = DoctorDocument::create([
                            'user_id' => $user->id,
                            'document_type_id' => $documentTypeId,
                            'original_filename' => $file->getClientOriginalName(),
                            'stored_filename' => basename($filePath),
                            'file_path' => $filePath,
                            'file_size_bytes' => $file->getSize(),
                            'mime_type' => $file->getMimeType(),
                            'upload_date' => now(),
                            'is_verified' => false,
                            'is_current' => true,
                        ]);

                        $documentRecords[] = $document;

                        Log::info('Document record created', [
                            'document_id' => $document->id,
                            'user_id' => $document->user_id,
                            'document_type' => $document->document_type_id,
                            'property' => $property,
                            'file_path' => $document->file_path
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to create document record', [
                        'user_id' => $user->id,
                        'property' => $property,
                        'document_type' => $documentTypeId,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        return $documentRecords;
    }

    /**
     * Store document file
     */
    private function storeDocument($file, $userId)
    {
        try {
            $fileName = Carbon::now()->timestamp . '_' . Str::random(4) . '.' . $file->getClientOriginalExtension();
            $file->storeAs("assets/doctor-documents/{$userId}", $fileName);
            $filePath = "assets/doctor-documents/{$userId}/{$fileName}";

            Log::info('Document stored successfully', [
                'original_name' => $file->getClientOriginalName(),
                'stored_path' => $filePath,
                'file_size' => $file->getSize()
            ]);

            return $filePath;
        } catch (\Exception $e) {
            Log::error('Failed to store document', [
                'error' => $e->getMessage(),
                'file_name' => $file->getClientOriginalName()
            ]);

            return null;
        }
    }
}



