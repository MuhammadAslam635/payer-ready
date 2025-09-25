<?php

namespace App\Traits\Registration;

use App\Models\Insurance;
use App\Models\Attestation;
use App\Models\User;
use Illuminate\Support\Facades\Log;

trait Step5InsuranceAttestationTrait
{
    // Step 5: Insurance & Attestation Variables
    public $insuranceCarrier = '';
    public $policyNumber = '';
    public $coverageAmount = '';
    public $policyEffectiveDate = '';
    public $policyExpirationDate = '';
    
    // Attestation questions (changed from radio to checkbox)
    public $licenseSuspended = false;
    public $felonyConviction = false;
    public $malpracticeClaims = false;

    /**
     * Validate Step 5: Insurance & Attestation
     */
    private function validateStep5InsuranceAttestation()
    {
        $rules = [
            'insuranceCarrier' => 'nullable|string|max:255',
            'policyNumber' => 'nullable|string|max:100',
            'coverageAmount' => 'nullable|numeric|min:0',
            'policyEffectiveDate' => 'nullable|date',
            'policyExpirationDate' => 'nullable|date|after:policyEffectiveDate',
            'licenseSuspended' => 'boolean',
            'felonyConviction' => 'boolean',
            'malpracticeClaims' => 'boolean',
        ];

        $this->validate($rules);
    }
    /**
     * Process Step 5: Insurance & Attestation data
     */
    public function processStep5InsuranceAttestation(User $user)
    {
        // Validate step 5 data internally
        $this->validateStep5InsuranceAttestation();

        Log::info('Processing Step 5: Insurance & Attestation', [
            'user_id' => $user->id,
            'has_insurance_data' => $this->hasInsuranceData(),
        ]);

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

    /**
     * Check if insurance data is provided
     */
    private function hasInsuranceData()
    {
        return !empty($this->insuranceCarrier) ||
               !empty($this->policyNumber) ||
               !empty($this->coverageAmount) ||
               !empty($this->policyEffectiveDate) ||
               !empty($this->policyExpirationDate);
    }

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

        Log::info('Creating insurance record', [
            'user_id' => $user->id,
            'carrier' => $this->insuranceCarrier,
            'policy_number' => $this->policyNumber,
            'coverage_amount_original' => $this->coverageAmount,
            'coverage_amount_processed' => $coverageAmount,
            'policy_effective_date' => $this->policyEffectiveDate,
            'policy_expiration_date' => $this->policyExpirationDate
        ]);

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

            Log::info('Insurance record created successfully', [
                'insurance_id' => $insurance->id,
                'user_id' => $insurance->user_id,
                'carrier' => $insurance->carrier,
                'policy_number' => $insurance->policy_number,
                'coverage_amount' => $insurance->coverage_amount
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
        Log::info('Creating attestation record', [
            'user_id' => $user->id,
            'license_suspended' => $this->licenseSuspended ?? false,
            'felony_conviction' => $this->felonyConviction ?? false,
            'malpractice_claims' => $this->malpracticeClaims ?? false
        ]);

        try {
            $attestation = Attestation::create([
                'user_id' => $user->id,
                'license_suspended' => $this->licenseSuspended ?? false,
                'felony_conviction' => $this->felonyConviction ?? false,
                'malpractice_claims' => $this->malpracticeClaims ?? false,
            ]);

            Log::info('Attestation record created successfully', [
                'attestation_id' => $attestation->id,
                'user_id' => $attestation->user_id,
                'license_suspended' => $attestation->license_suspended,
                'felony_conviction' => $attestation->felony_conviction,
                'malpractice_claims' => $attestation->malpractice_claims
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



