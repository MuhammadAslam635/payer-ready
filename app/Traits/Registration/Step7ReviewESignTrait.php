<?php

namespace App\Traits\Registration;

use App\Models\ESignatureRecord;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;

trait Step7ReviewESignTrait
{
    // Step 7: Review & E-Sign Variables
    #[Validate('required|accepted')]
    public $agreeToTerms = false;
    #[Validate('required|string|min:2')]
    public $eSignature = '';

    public function processStep7ReviewESign(User $user)
    {
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



