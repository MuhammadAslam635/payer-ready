<?php

namespace App\Traits\Registration;

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
        // Update user with e-signature and terms acceptance
        $user->update([
            'e_signature' => $this->eSignature,
            'terms_condition' => $this->agreeToTerms ? 'accepted' : null,
        ]);
        return $user;
    }

    /**
     * Validate Step 7: Review & E-Sign
     */
    public function validateStep7ReviewESign()
    {
        $this->validate([
            'agreeToTerms' => 'required|accepted',
            'eSignature' => 'required|string|min:2',
        ]);
    }


}



