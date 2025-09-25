<?php

namespace App\Traits\Registration;

use App\Models\DoctorLicense;
use App\Models\Education;
use App\Models\User;
use Illuminate\Support\Facades\Log;

trait Step3CredentialsLicensesTrait
{
    // Step 3: Credentials & Licenses Variables
    public $stateLicenses = [
        ['state' => '', 'license_number' => '', 'issue_date' => '', 'expiration_date' => '']
    ];
    public $educations = [
        ['institution' => '', 'degree' => '', 'year_completed' => '']
    ];
    public $deaNumber = '';
    public $deaExpiration = '';

    /**
     * Validate Step 3: Credentials & Licenses
     */
    private function validateStep3CredentialsLicenses()
    {
        $rules = [
            'deaNumber' => 'nullable|string|regex:/^[A-Z]{2}\d{7}$/',
            'deaExpiration' => 'nullable|date|after:today',
        ];

        // Validate licenses if any are provided
        foreach ($this->stateLicenses as $index => $license) {
            if (!empty($license['state']) || !empty($license['license_number'])) {
                $rules["stateLicenses.{$index}.state"] = 'required|string|max:2';
                $rules["stateLicenses.{$index}.license_number"] = 'required|string|max:50';
            }
        }

        $this->validate($rules);
    }
    /**
     * Process Step 3: Credentials & Licenses data
     */
    public function processStep3CredentialsLicenses(User $user)
    {
        // Validate step 3 data internally
        $this->validateStep3CredentialsLicenses();

        Log::info('Processing Step 3: Credentials & Licenses', [
            'user_id' => $user->id,
            'has_credentials_data' => $this->hasCredentialsData(),
        ]);

        if (!$this->hasCredentialsData()) {
            Log::info('No credentials data provided or doctor profile not available');
            return null;
        }

        $licenses = [];
        $educations = [];

        // Process state licenses
        if (!empty($this->stateLicenses)) {
            $licenses = $this->createStateLicenses($user);
        }

        // Process education records
        if (!empty($this->educations)) {
            $educations = $this->createEducationRecords($user);
        }
        $this->updateUserCredentials($user);
        return [
            'licenses' => $licenses,
            'educations' => $educations,
        ];
    }

    /**
     * Check if credentials data is provided
     */
    private function hasCredentialsData()
    {
        // Check if any state license fields have data
        if (!empty($this->stateLicenses)) {
            foreach ($this->stateLicenses as $license) {
                if (!empty($license['state']) || !empty($license['license_number']) || 
                    !empty($license['issue_date']) || !empty($license['expiration_date'])) {
                    return true;
                }
            }
        }

        // Check if any education fields have data
        if (!empty($this->educations)) {
            foreach ($this->educations as $education) {
                if (!empty($education['institution']) || !empty($education['degree']) || 
                    !empty($education['year_completed'])) {
                    return true;
                }
            }
        }

        // Check if DEA fields have data
        if (!empty($this->deaNumber) || !empty($this->deaExpiration)) {
            return true;
        }

        return false;
    }

    /**
     * Create state licenses
     */
    private function createStateLicenses($user)
    {
        $licenses = [];

        Log::info('Creating state licenses for user', [
            'user_id' => $user->id,
            'license_count' => count($this->stateLicenses)
        ]);

        foreach ($this->stateLicenses as $index => $licenseData) {
            Log::info("Processing license item {$index}", [
                'user_id' => $user->id,
                'item_index' => $index,
                'has_state' => !empty($licenseData['state']),
                'has_license_number' => !empty($licenseData['license_number']),
                'state' => $licenseData['state'] ?? 'N/A',
                'license_number' => $licenseData['license_number'] ?? 'N/A'
            ]);

            if (!empty($licenseData['state']) && !empty($licenseData['license_number'])) {
                $state = \App\Models\State::where('code', $licenseData['state'])->first();

                Log::info('Creating doctor license', [
                    'user_id' => $user->id,
                    'state_code' => $licenseData['state'],
                    'state_found' => $state ? true : false,
                    'state_id' => $state ? $state->id : null,
                    'license_number' => $licenseData['license_number']
                ]);

                try {
                    $license = DoctorLicense::create([
                        'user_id' => $user->id,
                        'license_type_id' => $licenseData['license_type_id'] ?? 1, // Default license type
                        'state_id' => $state ? $state->id : null,
                        'license_number' => $licenseData['license_number'],
                        'issue_date' => $licenseData['issue_date'] ?? null,
                        'expiration_date' => $licenseData['expiration_date'] ?? null,
                        'status' => \App\Enums\LicenseStatus::ACTIVE->value,
                        'issuing_authority' => $licenseData['issuing_authority'] ?? 'State Medical Board',
                        'is_verified' => false,
                    ]);

                    $licenses[] = $license;

                    Log::info('Doctor license created successfully', [
                        'license_id' => $license->id,
                        'user_id' => $license->user_id,
                        'state_id' => $license->state_id,
                        'license_number' => $license->license_number,
                        'license_type_id' => $license->license_type_id,
                        'status' => $license->status->value
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to create doctor license', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage(),
                        'license_data' => $licenseData
                    ]);
                }
            } else {
                Log::warning('Skipping license item due to missing required fields', [
                    'user_id' => $user->id,
                    'item_index' => $index,
                    'missing_state' => empty($licenseData['state']),
                    'missing_license_number' => empty($licenseData['license_number'])
                ]);
            }
        }

        Log::info('License creation summary', [
            'user_id' => $user->id,
            'total_items_processed' => count($this->stateLicenses),
            'successful_records' => count($licenses)
        ]);

        return $licenses;
    }

    /**
     * Create education records
     */
    private function createEducationRecords(User $user)
    {
        $educations = [];

        Log::info('Creating education records for user', [
            'user_id' => $user->id,
            'education_count' => count($this->educations)
        ]);

        foreach ($this->educations as $index => $educationData) {
            Log::info("Processing education item {$index}", [
                'user_id' => $user->id,
                'item_index' => $index,
                'has_institution' => !empty($educationData['institution']),
                'has_degree' => !empty($educationData['degree']),
                'institution' => $educationData['institution'] ?? 'N/A',
                'degree' => $educationData['degree'] ?? 'N/A'
            ]);

            if (!empty($educationData['institution']) && !empty($educationData['degree'])) {
                Log::info('Creating education record', [
                    'user_id' => $user->id,
                    'institution' => $educationData['institution'],
                    'degree' => $educationData['degree'],
                    'year_completed' => $educationData['year_completed'] ?? null
                ]);

                try {
                    $education = Education::create([
                        'user_id' => $user->id,
                        'institution_name' => $educationData['institution'],
                        'degree' => $educationData['degree'],
                        'completed_year' => $educationData['year_completed'] ?? null,
                    ]);

                    $educations[] = $education;

                    Log::info('Education record created successfully', [
                        'education_id' => $education->id,
                        'user_id' => $education->user_id,
                        'institution_name' => $education->institution_name,
                        'degree' => $education->degree,
                        'completed_year' => $education->completed_year
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to create education record', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage(),
                        'education_data' => $educationData
                    ]);
                }
            } else {
                Log::warning('Skipping education item due to missing required fields', [
                    'user_id' => $user->id,
                    'item_index' => $index,
                    'missing_institution' => empty($educationData['institution']),
                    'missing_degree' => empty($educationData['degree'])
                ]);
            }
        }

        Log::info('Education creation summary', [
            'user_id' => $user->id,
            'total_items_processed' => count($this->educations),
            'successful_records' => count($educations)
        ]);

        return $educations;
    }
    public function updateUserCredentials(User $user)
    {
        $user->update([
            'dea_number' => $this->deaNumber,
            'dea_expiration_date' => $this->deaExpiration,
        ]);
    }
}



