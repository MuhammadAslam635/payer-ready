<?php

namespace App\Traits\Registration;

use App\Models\Insurance;
use App\Models\Attestation;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;

trait Step5InsuranceAttestationTrait
{
    // Step 5: Insurance & Attestation Variables
    #[Validate('nullable|string')]
    public $insuranceCarrier = '';
    #[Validate('nullable|string')]
    public $policyNumber = '';
    #[Validate('nullable|numeric')]
    public $coverageAmount = '';
    #[Validate('nullable|date')]
    public $policyEffectiveDate = '';
    #[Validate('nullable|date')]
    public $policyExpirationDate = '';

    // Attestation questions (changed from radio to checkbox)
    #[Validate('nullable|boolean')]
    public $licenseSuspended = false;
    #[Validate('nullable|boolean')]
    public $felonyConviction = false;
    #[Validate('nullable|boolean')]
    public $malpracticeClaims = false;

    /**
     * Validate Step 5: Insurance & Attestation
     */
    // private function validateStep5InsuranceAttestation()
    // {
    //     $this->validate();
    // }
    /**
     * Process Step 5: Insurance & Attestation data
     */
    public function processStep5InsuranceAttestation(User $user)
    {
        // Validate step 5 data internally
        // $this->validateStep5InsuranceAttestation();

        // Only process if there's data to process
        if (!$this->hasInsuranceData() && !$this->hasAttestationData()) {
            return null;
        }

        $insurance = null;
        $attestation = null;

        // Process insurance data
        if ($this->hasInsuranceData()) {
            $insurance = $this->createInsuranceRecord($user);
        }

        // Process attestation data
        if ($this->hasAttestationData()) {
            $attestation = $this->createAttestationRecord($user);
        }

        return [
            'insurance' => $insurance,
            'attestation' => $attestation,
        ];
    }

    // hasInsuranceData method is now centralized in RegistrationTrait

    /**
     * Check if attestation data is provided
     */
    private function hasAttestationData()
    {
        return isset($this->licenseSuspended) ||
               isset($this->felonyConviction) ||
               isset($this->malpracticeClaims);
    }

    /**
     * Create insurance record
     */
    private function createInsuranceRecord(User $user)
    {
        // Handle empty coverage_amount - convert empty string to null or default 0.00
        $coverageAmount = null;
        if (!empty($this->coverageAmount) && is_numeric($this->coverageAmount)) {
            $coverageAmount = (float) $this->coverageAmount;
        } elseif (empty($this->coverageAmount)) {
            // Set default value of 0.00 when coverage amount is empty
            $coverageAmount = 0.00;
        }

        try {
            $insurance = Insurance::create([
                'user_id' => $user->id,
                'carrier' => $this->insuranceCarrier ?: null,
                'policy_number' => $this->policyNumber ?: null,
                'coverage_amount' => $coverageAmount,
                'policy_effective_date' => $this->policyEffectiveDate ?: null,
                'policy_expiration_date' => $this->policyExpirationDate ?: null,
                'status' => 'pending',
            ]);

            return $insurance;
        } catch (\Exception $e) {
            Log::error('Failed to create insurance record', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'insurance_data' => [
                    'carrier' => $this->insuranceCarrier,
                    'policy_number' => $this->policyNumber,
                    'coverage_amount' => $this->coverageAmount
                ]
            ]);
            throw $e;
        }
    }

    /**
     * Create attestation record
     */
    private function createAttestationRecord(User $user)
    {

        try {
            $attestation = Attestation::create([
                'user_id' => $user->id,
                'license_suspended' => $this->licenseSuspended ?? false,
                'felony_conviction' => $this->felonyConviction ?? false,
                'malpractice_claims' => $this->malpracticeClaims ?? false,
            ]);
            return $attestation;
        } catch (\Exception $e) {
            Log::error('Failed to create attestation record', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'attestation_data' => [
                    'license_suspended' => $this->licenseSuspended ?? false,
                    'felony_conviction' => $this->felonyConviction ?? false,
                    'malpractice_claims' => $this->malpracticeClaims ?? false
                ]
            ]);
            throw $e;
        }
    }
}



