<?php

namespace App\Traits\Registration;

use App\Models\ESignatureRecord;
use App\Models\User;
use Illuminate\Support\Facades\Log;

trait Step7ReviewESignTrait
{
    // Step 7: Review & E-Sign Variables
    public $agreeToTerms = false;
    public $eSignature = '';

    /**
     * Validate Step 7: Review & E-Sign (Strict validation)
     */
    private function validateStep7Strictly()
    {
        $this->validate([
            'agreeToTerms' => 'required|accepted',
            'eSignature' => 'required|string|min:2',
        ]);
    }
    public function processStep7ReviewESign(User $user)
    {
        Log::info('Processing Step 7: Review & E-Sign', [
            'user_id' => $user->id,
            'has_e_signature' => !empty($this->eSignature),
            'terms_accepted' => $this->agreeToTerms ?? false,
            'e_signature_length' => strlen($this->eSignature ?? ''),
            'user_email' => $user->email,
            'user_name' => $user->name
        ]);

        $eSignatureRecord = null;

        // Create e-signature record
        if (!empty($this->eSignature)) {
            $eSignatureRecord = $this->createESignatureRecord($user);
        } else {
            Log::warning('E-signature is empty, no record will be created', [
                'user_id' => $user->id
            ]);
        }

        Log::info('Step 7 Review & E-Sign processing completed', [
            'user_id' => $user->id,
            'e_signature_record_created' => $eSignatureRecord ? true : false,
            'e_signature_record_id' => $eSignatureRecord ? $eSignatureRecord->id : null
        ]);

        return [
            'eSignatureRecord' => $eSignatureRecord,
        ];
    }

    /**
     * Create e-signature record
     */
    private function createESignatureRecord($user)
    {
        Log::info('Creating e-signature record', [
            'user_id' => $user->id,
            'signature_provided' => !empty($this->eSignature),
            'terms_accepted' => $this->agreeToTerms ?? false
        ]);

        try {
            $eSignatureRecord = ESignatureRecord::create([
                'user_id' => $user->id,
                'signature_text' => $this->eSignature,
                'signature_date' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'document_type' => 'provider_profile_submission',
                'is_valid' => true,
            ]);

            Log::info('E-signature record created successfully', [
                'e_signature_id' => $eSignatureRecord->id,
                'user_id' => $eSignatureRecord->user_id,
                'signature_text' => $eSignatureRecord->signature_text,
                'signature_date' => $eSignatureRecord->signature_date,
                'ip_address' => $eSignatureRecord->ip_address,
                'document_type' => $eSignatureRecord->document_type
            ]);

            return $eSignatureRecord;
        } catch (\Exception $e) {
            Log::error('Failed to create e-signature record', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'signature_data' => [
                    'signature_length' => strlen($this->eSignature ?? ''),
                    'terms_accepted' => $this->agreeToTerms ?? false
                ]
            ]);
            throw $e;
        }
    }
}



