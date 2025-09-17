<?php

namespace App\Traits;

use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Enums\UserType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\State;
use App\Models\Specialty;
use Livewire\Attributes\Rules;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

trait RegistrationTrait
{
    use WithFileUploads;

    // Step management
    public $currentStep = 1; // Start at step 1 since we're coming from card selection
    public $totalSteps = 7;

    // User type - will be set when component is mounted
    public $userType = '';

    // Step 1: Core Profile
    public $name = '';
    public $email = '';
    public $organizationName = '';
    public $businessName = ''; // Alias for organizationName to maintain compatibility
    public $organizationType = 'business'; // business, legal, both
    public $primarySpecialty = '';
    public $taxonomyCode = '';
    public $primaryState = '';
    public $password = '';
    public $password_confirmation = '';

    // Step 2: Personal & Contact
    public $middleName = '';
    public $dateOfBirth = '';
    public $ssn = '';
    public $homeAddress = '';
    public $practiceAddress = '';
    public $phoneNumber = '';
    public $npiNumber = '';
    public $caqhId = '';
    public $caqhLogin = '';
    public $caqhPassword = '';
    public $pecosLogin = '';
    public $pecosPassword = '';

    // Step 3: Credentials & Licenses
    public $stateLicenses = [
        ['state' => '', 'license_number' => '', 'issue_date' => '', 'expiration_date' => '']
    ];
    public $educations = [
        ['institution' => '', 'degree' => '', 'year_completed' => '']
    ];
    public $deaNumber = '';
    public $deaExpiration = '';

    // Step 4: Professional History
    public $workHistory = [
        ['practice_name' => '', 'position' => '', 'address' => '', 'start_date' => '', 'end_date' => '']
    ];
    public $references = [
        ['full_name' => '', 'title' => '', 'facility_address' => '', 'phone' => '', 'email' => ''],
        ['full_name' => '', 'title' => '', 'facility_address' => '', 'phone' => '', 'email' => '']
    ];

    // Step 5: Insurance & Attestation
    public $insuranceCarrier = '';
    public $policyNumber = '';
    public $coverageAmount = '';
    public $policyEffectiveDate = '';
    public $policyExpirationDate = '';
    public $licenseSuspended = null;
    public $felonyConviction = null;
    public $malpracticeClaims = null;

    // Step 6: Document Upload
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

    // Step 7: Review & E-Sign
    public $agreeToTerms = false;
    public $eSignature = '';



    public function goToStep($step)
    {
        // Allow navigation to completed steps or the next step
        if ($step >= 1 && $step <= $this->totalSteps) {
            $this->currentStep = $step;
        }
    }

    public function updatedOrganizationName($value)
    {
        $this->businessName = $value;
    }

    public function updatedBusinessName($value)
    {
        $this->organizationName = $value;
    }

    public function nextStep()
    {
        Log::info('Moving to next step', [
            'current_step' => $this->currentStep,
            'user_type' => $this->userType,
            'email' => $this->email
        ]);

        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            Log::info('Step advanced', [
                'new_step' => $this->currentStep,
                'total_steps' => $this->totalSteps
            ]);
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            Log::info('Step moved back', [
                'new_step' => $this->currentStep,
                'user_type' => $this->userType
            ]);
        }
    }

    public function validateCurrentStep()
    {
        switch ($this->currentStep) {
            case 1: // Core Profile - REQUIRED
                $rules = [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'organizationName' => 'nullable|string|max:255',
                    'primaryState' => 'required',
                    'password' => ['required', 'confirmed', Password::min(8)],
                ];

                // Only require primary specialty for doctors
                if ($this->userType === 'doctor') {
                    $rules['primarySpecialty'] = 'required';
                    $rules['taxonomyCode'] = 'nullable|string|max:20';
                }

                Log::info('Validating step 1', [
                    'rules' => $rules,
                    'data' => [
                        'name' => $this->name,
                        'email' => $this->email,
                        'organizationName' => $this->organizationName,
                        'primaryState' => $this->primaryState,
                        'primarySpecialty' => $this->primarySpecialty,
                        'password' => $this->password ? 'SET' : 'EMPTY',
                        'password_confirmation' => $this->password_confirmation ? 'SET' : 'EMPTY',
                    ]
                ]);

                try {
                    $this->validate($rules);
                    Log::info('Step 1 validation passed');
                } catch (\Illuminate\Validation\ValidationException $e) {
                    Log::info('Step 1 validation failed', [
                        'errors' => $e->errors()
                    ]);
                    throw $e;
                }
                break;
            case 2: // Personal & Contact - OPTIONAL with type validation
                $rules = [
                    'middleName' => 'nullable|string|max:255',
                    'dateOfBirth' => 'nullable|date|before:today',
                    'ssn' => 'nullable|string|regex:/^\d{3}-\d{2}-\d{4}$/',
                    'homeAddress' => 'nullable|string|max:500',
                    'practiceAddress' => 'nullable|string|max:500',
                    'phoneNumber' => 'nullable|string|regex:/^\+?[\d\s\-\(\)]+$/',
                    'npiNumber' => 'nullable|string|regex:/^\d{10}$/',
                    'caqhId' => 'nullable|string|max:50',
                    'caqhLogin' => 'nullable|string|max:100',
                    'caqhPassword' => 'nullable|string|max:100',
                    'pecosLogin' => 'nullable|string|max:100',
                    'pecosPassword' => 'nullable|string|max:100',
                ];

                $messages = [
                    'dateOfBirth.date' => 'Please enter a valid date.',
                    'dateOfBirth.before' => 'Date of birth must be before today.',
                    'ssn.regex' => 'SSN must be in format XXX-XX-XXXX (e.g., 123-45-6789).',
                    'phoneNumber.regex' => 'Please enter a valid phone number.',
                    'npiNumber.regex' => 'NPI Number must be exactly 10 digits.',
                    'middleName.max' => 'Middle name cannot exceed 255 characters.',
                    'homeAddress.max' => 'Home address cannot exceed 500 characters.',
                    'practiceAddress.max' => 'Practice address cannot exceed 500 characters.',
                    'caqhId.max' => 'CAQH ID cannot exceed 50 characters.',
                    'caqhLogin.max' => 'CAQH login cannot exceed 100 characters.',
                    'caqhPassword.max' => 'CAQH password cannot exceed 100 characters.',
                    'pecosLogin.max' => 'PECOS login cannot exceed 100 characters.',
                    'pecosPassword.max' => 'PECOS password cannot exceed 100 characters.',
                ];

                try {
                    $this->validate($rules, $messages);
                    Log::info("Step {$this->currentStep} validation passed");
                } catch (\Illuminate\Validation\ValidationException $e) {
                    Log::info("Step {$this->currentStep} validation failed", [
                        'errors' => $e->errors()
                    ]);
                    throw $e;
                }
                break;
            case 3: // Credentials - OPTIONAL with type validation
                $rules = [
                    'deaNumber' => 'nullable|string|regex:/^[A-Z]{2}\d{7}$/',
                    'deaExpiration' => 'nullable|date|after:today',
                ];

                // Validate state licenses if provided
                foreach ($this->stateLicenses as $index => $license) {
                    if (!empty($license['state']) || !empty($license['license_number'])) {
                        $rules["stateLicenses.{$index}.state"] = 'required|string|max:2';
                        $rules["stateLicenses.{$index}.license_number"] = 'required|string|max:50';
                        $rules["stateLicenses.{$index}.issue_date"] = 'nullable|date|before:today';
                        $rules["stateLicenses.{$index}.expiration_date"] = 'nullable|date|after:today';
                    }
                }

                // Validate educations if provided
                foreach ($this->educations as $index => $education) {
                    if (!empty($education['institution']) || !empty($education['degree'])) {
                        $rules["educations.{$index}.institution"] = 'required|string|max:255';
                        $rules["educations.{$index}.degree"] = 'required|string|max:100';
                        $rules["educations.{$index}.year_completed"] = 'nullable|integer|min:1900|max:' . date('Y');
                    }
                }

                $messages = [
                    'deaNumber.regex' => 'DEA Number must be in format XX####### (2 letters followed by 7 digits).',
                    'deaExpiration.date' => 'Please enter a valid expiration date.',
                    'deaExpiration.after' => 'DEA expiration date must be in the future.',
                ];

                // Add dynamic messages for licenses and education
                foreach ($this->stateLicenses as $index => $license) {
                    if (!empty($license['state']) || !empty($license['license_number'])) {
                        $messages["stateLicenses.{$index}.state.required"] = 'State is required when license number is provided.';
                        $messages["stateLicenses.{$index}.state.max"] = 'State must be 2 characters (state code).';
                        $messages["stateLicenses.{$index}.license_number.required"] = 'License number is required when state is provided.';
                        $messages["stateLicenses.{$index}.license_number.max"] = 'License number cannot exceed 50 characters.';
                        $messages["stateLicenses.{$index}.issue_date.date"] = 'Please enter a valid issue date.';
                        $messages["stateLicenses.{$index}.issue_date.before"] = 'Issue date must be before today.';
                        $messages["stateLicenses.{$index}.expiration_date.date"] = 'Please enter a valid expiration date.';
                        $messages["stateLicenses.{$index}.expiration_date.after"] = 'Expiration date must be in the future.';
                    }
                }

                foreach ($this->educations as $index => $education) {
                    if (!empty($education['institution']) || !empty($education['degree'])) {
                        $messages["educations.{$index}.institution.required"] = 'Institution name is required when degree is provided.';
                        $messages["educations.{$index}.institution.max"] = 'Institution name cannot exceed 255 characters.';
                        $messages["educations.{$index}.degree.required"] = 'Degree is required when institution is provided.';
                        $messages["educations.{$index}.degree.max"] = 'Degree cannot exceed 100 characters.';
                        $messages["educations.{$index}.year_completed.integer"] = 'Year completed must be a valid year.';
                        $messages["educations.{$index}.year_completed.min"] = 'Year completed must be 1900 or later.';
                        $messages["educations.{$index}.year_completed.max"] = 'Year completed cannot be in the future.';
                    }
                }

                try {
                    $this->validate($rules, $messages);
                    Log::info("Step {$this->currentStep} validation passed");
                } catch (\Illuminate\Validation\ValidationException $e) {
                    Log::info("Step {$this->currentStep} validation failed", [
                        'errors' => $e->errors()
                    ]);
                    throw $e;
                }
                break;
            case 4: // Professional History - OPTIONAL with type validation
                $rules = [];

                // Validate work history if provided
                foreach ($this->workHistory as $index => $work) {
                    if (!empty($work['practice_name']) || !empty($work['position'])) {
                        $rules["workHistory.{$index}.practice_name"] = 'required|string|max:255';
                        $rules["workHistory.{$index}.position"] = 'required|string|max:255';
                        $rules["workHistory.{$index}.address"] = 'nullable|string|max:500';
                        $rules["workHistory.{$index}.start_date"] = 'required|date|before:today';
                        $rules["workHistory.{$index}.end_date"] = 'nullable|date|after:workHistory.{$index}.start_date';
                    }
                }

                // Validate references if provided
                foreach ($this->references as $index => $reference) {
                    if (!empty($reference['full_name']) || !empty($reference['title'])) {
                        $rules["references.{$index}.full_name"] = 'required|string|max:255';
                        $rules["references.{$index}.title"] = 'required|string|max:255';
                        $rules["references.{$index}.facility_address"] = 'nullable|string|max:500';
                        $rules["references.{$index}.phone"] = 'nullable|string|regex:/^\+?[\d\s\-\(\)]+$/';
                        $rules["references.{$index}.email"] = 'nullable|email|max:255';
                    }
                }

                $messages = [];

                // Add dynamic messages for work history
                foreach ($this->workHistory as $index => $work) {
                    if (!empty($work['practice_name']) || !empty($work['position'])) {
                        $messages["workHistory.{$index}.practice_name.required"] = 'Practice name is required when position is provided.';
                        $messages["workHistory.{$index}.practice_name.max"] = 'Practice name cannot exceed 255 characters.';
                        $messages["workHistory.{$index}.position.required"] = 'Position is required when practice name is provided.';
                        $messages["workHistory.{$index}.position.max"] = 'Position cannot exceed 255 characters.';
                        $messages["workHistory.{$index}.address.max"] = 'Address cannot exceed 500 characters.';
                        $messages["workHistory.{$index}.start_date.required"] = 'Start date is required when work history is provided.';
                        $messages["workHistory.{$index}.start_date.date"] = 'Please enter a valid start date.';
                        $messages["workHistory.{$index}.start_date.before"] = 'Start date must be before today.';
                        $messages["workHistory.{$index}.end_date.date"] = 'Please enter a valid end date.';
                        $messages["workHistory.{$index}.end_date.after"] = 'End date must be after start date.';
                    }
                }

                // Add dynamic messages for references
                foreach ($this->references as $index => $reference) {
                    if (!empty($reference['full_name']) || !empty($reference['title'])) {
                        $messages["references.{$index}.full_name.required"] = 'Full name is required when title is provided.';
                        $messages["references.{$index}.full_name.max"] = 'Full name cannot exceed 255 characters.';
                        $messages["references.{$index}.title.required"] = 'Title is required when full name is provided.';
                        $messages["references.{$index}.title.max"] = 'Title cannot exceed 255 characters.';
                        $messages["references.{$index}.facility_address.max"] = 'Facility address cannot exceed 500 characters.';
                        $messages["references.{$index}.phone.regex"] = 'Please enter a valid phone number.';
                        $messages["references.{$index}.email.email"] = 'Please enter a valid email address.';
                        $messages["references.{$index}.email.max"] = 'Email cannot exceed 255 characters.';
                    }
                }

                if (!empty($rules)) {
                    try {
                        $this->validate($rules, $messages);
                        Log::info("Step {$this->currentStep} validation passed");
                    } catch (\Illuminate\Validation\ValidationException $e) {
                        Log::info("Step {$this->currentStep} validation failed", [
                            'errors' => $e->errors()
                        ]);
                        throw $e;
                    }
                }
                break;
            case 5: // Insurance & Attestation - OPTIONAL with type validation
                $rules = [
                    'insuranceCarrier' => 'nullable|string|max:255',
                    'policyNumber' => 'nullable|string|max:100',
                    'coverageAmount' => 'nullable|numeric|min:0',
                    'policyEffectiveDate' => 'nullable|date|before:today',
                    'policyExpirationDate' => 'nullable|date|after:policyEffectiveDate',
                    'licenseSuspended' => 'nullable|boolean',
                    'felonyConviction' => 'nullable|boolean',
                    'malpracticeClaims' => 'nullable|boolean',
                ];

                $messages = [
                    'insuranceCarrier.max' => 'Insurance carrier name cannot exceed 255 characters.',
                    'policyNumber.max' => 'Policy number cannot exceed 100 characters.',
                    'coverageAmount.numeric' => 'Coverage amount must be a valid number.',
                    'coverageAmount.min' => 'Coverage amount must be 0 or greater.',
                    'policyEffectiveDate.date' => 'Please enter a valid effective date.',
                    'policyEffectiveDate.before' => 'Policy effective date must be before today.',
                    'policyExpirationDate.date' => 'Please enter a valid expiration date.',
                    'policyExpirationDate.after' => 'Policy expiration date must be after effective date.',
                    'licenseSuspended.boolean' => 'License suspended must be yes or no.',
                    'felonyConviction.boolean' => 'Felony conviction must be yes or no.',
                    'malpracticeClaims.boolean' => 'Malpractice claims must be yes or no.',
                ];

                try {
                    $this->validate($rules, $messages);
                    Log::info("Step {$this->currentStep} validation passed");
                } catch (\Illuminate\Validation\ValidationException $e) {
                    Log::info("Step {$this->currentStep} validation failed", [
                        'errors' => $e->errors()
                    ]);
                    throw $e;
                }
                break;
            case 6: // Document Upload - OPTIONAL with file validation
                $rules = [
                    'cv' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB max
                    'professionalLicense' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                    'pictureId' => 'nullable|file|mimes:jpg,jpeg,png|max:5120', // 5MB max
                    'socialSecurityCard' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                    'certificateOfLiabilityInsurance' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                    'copiesOfDiplomasCertifications' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                    'stateCredentialingApplication' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                    'passportStylePhoto' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
                    'ecfmgCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                    'boardCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                    'procedureLog' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
                    'cmeCs' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
                    'immunizationShotRecords' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                    'aclsBlsCertificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                ];

                $messages = [
                    'cv.file' => 'CV must be a valid file.',
                    'cv.mimes' => 'CV must be a PDF, DOC, or DOCX file.',
                    'cv.max' => 'CV file size cannot exceed 10MB.',
                    'professionalLicense.file' => 'Professional license must be a valid file.',
                    'professionalLicense.mimes' => 'Professional license must be a PDF, JPG, JPEG, or PNG file.',
                    'professionalLicense.max' => 'Professional license file size cannot exceed 10MB.',
                    'pictureId.file' => 'Picture ID must be a valid file.',
                    'pictureId.mimes' => 'Picture ID must be a JPG, JPEG, or PNG file.',
                    'pictureId.max' => 'Picture ID file size cannot exceed 5MB.',
                    'socialSecurityCard.file' => 'Social Security card must be a valid file.',
                    'socialSecurityCard.mimes' => 'Social Security card must be a PDF, JPG, JPEG, or PNG file.',
                    'socialSecurityCard.max' => 'Social Security card file size cannot exceed 5MB.',
                    'certificateOfLiabilityInsurance.file' => 'Certificate of liability insurance must be a valid file.',
                    'certificateOfLiabilityInsurance.mimes' => 'Certificate of liability insurance must be a PDF, JPG, JPEG, or PNG file.',
                    'certificateOfLiabilityInsurance.max' => 'Certificate of liability insurance file size cannot exceed 10MB.',
                    'copiesOfDiplomasCertifications.file' => 'Diplomas and certifications must be a valid file.',
                    'copiesOfDiplomasCertifications.mimes' => 'Diplomas and certifications must be a PDF, JPG, JPEG, or PNG file.',
                    'copiesOfDiplomasCertifications.max' => 'Diplomas and certifications file size cannot exceed 10MB.',
                    'stateCredentialingApplication.file' => 'State credentialing application must be a valid file.',
                    'stateCredentialingApplication.mimes' => 'State credentialing application must be a PDF, JPG, JPEG, or PNG file.',
                    'stateCredentialingApplication.max' => 'State credentialing application file size cannot exceed 10MB.',
                    'passportStylePhoto.file' => 'Passport style photo must be a valid file.',
                    'passportStylePhoto.mimes' => 'Passport style photo must be a JPG, JPEG, or PNG file.',
                    'passportStylePhoto.max' => 'Passport style photo file size cannot exceed 5MB.',
                    'ecfmgCertificate.file' => 'ECFMG certificate must be a valid file.',
                    'ecfmgCertificate.mimes' => 'ECFMG certificate must be a PDF, JPG, JPEG, or PNG file.',
                    'ecfmgCertificate.max' => 'ECFMG certificate file size cannot exceed 10MB.',
                    'boardCertificate.file' => 'Board certificate must be a valid file.',
                    'boardCertificate.mimes' => 'Board certificate must be a PDF, JPG, JPEG, or PNG file.',
                    'boardCertificate.max' => 'Board certificate file size cannot exceed 10MB.',
                    'procedureLog.file' => 'Procedure log must be a valid file.',
                    'procedureLog.mimes' => 'Procedure log must be a PDF, DOC, DOCX, XLS, or XLSX file.',
                    'procedureLog.max' => 'Procedure log file size cannot exceed 10MB.',
                    'cmeCs.file' => 'CME/CS must be a valid file.',
                    'cmeCs.mimes' => 'CME/CS must be a PDF, DOC, or DOCX file.',
                    'cmeCs.max' => 'CME/CS file size cannot exceed 10MB.',
                    'immunizationShotRecords.file' => 'Immunization shot records must be a valid file.',
                    'immunizationShotRecords.mimes' => 'Immunization shot records must be a PDF, JPG, JPEG, or PNG file.',
                    'immunizationShotRecords.max' => 'Immunization shot records file size cannot exceed 10MB.',
                    'aclsBlsCertificate.file' => 'ACLS/BLS certificate must be a valid file.',
                    'aclsBlsCertificate.mimes' => 'ACLS/BLS certificate must be a PDF, JPG, JPEG, or PNG file.',
                    'aclsBlsCertificate.max' => 'ACLS/BLS certificate file size cannot exceed 10MB.',
                ];

                try {
                    $this->validate($rules, $messages);
                    Log::info("Step {$this->currentStep} validation passed");
                } catch (\Illuminate\Validation\ValidationException $e) {
                    Log::info("Step {$this->currentStep} validation failed", [
                        'errors' => $e->errors()
                    ]);
                    throw $e;
                }
                break;
            case 7: // Review & E-Sign - REQUIRED for final submission
                $this->validate([
                    'agreeToTerms' => 'required|accepted',
                    'eSignature' => 'required|string',
                ]);
                break;
        }
    }

    public function addStateLicense()
    {
        $this->stateLicenses[] = ['state' => '', 'license_number' => '', 'issue_date' => '', 'expiration_date' => ''];
    }

    public function removeStateLicense($index)
    {
        if (count($this->stateLicenses) > 1) {
            unset($this->stateLicenses[$index]);
            $this->stateLicenses = array_values($this->stateLicenses);
        }
    }

    public function addEducation()
    {
        $this->educations[] = ['institution' => '', 'degree' => '', 'year_completed' => ''];
    }

    public function removeEducation($index)
    {
        if (count($this->educations) > 1) {
            unset($this->educations[$index]);
            $this->educations = array_values($this->educations);
        }
    }

    public function addWorkHistory()
    {
        $this->workHistory[] = ['practice_name' => '', 'position' => '', 'address' => '', 'start_date' => '', 'end_date' => ''];
    }

    public function removeWorkHistory($index)
    {
        if (count($this->workHistory) > 1) {
            unset($this->workHistory[$index]);
            $this->workHistory = array_values($this->workHistory);
        }
    }

    public function addReference()
    {
        $this->references[] = ['full_name' => '', 'title' => '', 'facility_address' => '', 'phone' => '', 'email' => ''];
    }

    public function removeReference($index)
    {
        if (count($this->references) > 2) {
            unset($this->references[$index]);
            $this->references = array_values($this->references);
        }
    }

    public function skipStep()
    {
        // Step 1 cannot be skipped - it contains required information
        if ($this->currentStep == 1) {
            session()->flash('error', 'Step 1 contains required information and cannot be skipped.');
            return;
        }

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    /**
     * Check if current step has valid data
     */
    public function isCurrentStepValid()
    {
        try {
            $this->validateCurrentStep();
            return true;
        } catch (\Illuminate\Validation\ValidationException $e) {
            return false;
        }
    }

    /**
     * Check if current step has any data
     */
    public function hasCurrentStepData()
    {
        switch ($this->currentStep) {
            case 1: // Core Profile
                return !empty($this->name) &&
                       !empty($this->email) &&
                       !empty($this->organizationName) &&
                       !empty($this->primaryState) &&
                       !empty($this->password) &&
                       !empty($this->password_confirmation);
            case 2: // Personal & Contact
                return !empty($this->middleName) ||
                       !empty($this->dateOfBirth) ||
                       !empty($this->ssn) ||
                       !empty($this->homeAddress) ||
                       !empty($this->practiceAddress) ||
                       !empty($this->phoneNumber) ||
                       !empty($this->npiNumber) ||
                       !empty($this->caqhId);
            case 3: // Credentials
                return !empty($this->stateLicenses[0]['state']) ||
                       !empty($this->educations[0]['institution']) ||
                       !empty($this->deaNumber);
            case 4: // Professional History
                return !empty($this->workHistory[0]['practice_name']) ||
                       !empty($this->references[0]['full_name']);
            case 5: // Insurance
                return !empty($this->insuranceCarrier) ||
                       !empty($this->policyNumber) ||
                       $this->licenseSuspended !== null ||
                       $this->felonyConviction !== null ||
                       $this->malpracticeClaims !== null;
            case 6: // Documents
                return $this->hasDocumentData();
            case 7: // Review & Sign
                return $this->agreeToTerms && !empty($this->eSignature);
            default:
                return false;
        }
    }

    public function submitForm()
    {
        Log::info('=== REGISTRATION SUBMIT STARTED ===', [
            'user_type' => $this->userType,
            'email' => $this->email,
            'name' => $this->name,
            'organization_name' => $this->organizationName ?? 'N/A',
            'business_name' => $this->organizationName ?? 'N/A',
            'password' => $this->password ?? 'N/A',
            'primary_state' => $this->primaryState ?? 'N/A',
            'primary_specialty' => $this->primarySpecialty ?? 'N/A',
            'agree_to_terms' => $this->agreeToTerms ?? false,
            'e_signature' => !empty($this->eSignature) ? 'PROVIDED' : 'MISSING',
            'all_properties' => [
                'name' => $this->name,
                'email' => $this->email,
                'organizationName' => $this->organizationName,
                'businessName' => $this->organizationName,
                'password' => $this->password,
                'primaryState' => $this->primaryState,
                'primarySpecialty' => $this->primarySpecialty,
            ]
        ]);

        $this->validate([
            'agreeToTerms' => 'required|accepted',
            'eSignature' => 'required|string',
        ]);

        Log::info('Step 7: Final validation passed (Terms & E-signature)');

        try {
            DB::beginTransaction();
            Log::info('Database transaction started');

            // Set correct user type
            $userType = $this->userType === 'organization' ? UserType::ORGANIZATION_ADMIN : UserType::DOCTOR;
            Log::info('User type determined', ['user_type' => $userType->value]);

            // Create user account with required fields
            Log::info('Creating user account', [
                'name' => $this->name,
                'email' => $this->email,
                'user_type' => $userType->value
            ]);

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'user_type' => $userType,
                'is_active' => true,
                'email_verified_at' => now(), // Mark email as verified since they completed registration
            ]);

            Log::info('User created successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'user_type' => $user->user_type->value,
                'email_verified_at' => $user->email_verified_at
            ]);

            $organization = null; // Initialize organization variable

            // Create organization for organization types only
            if($userType === UserType::ORGANIZATION_ADMIN){
                Log::info('Creating organization', [
                    'business_name' => $this->organizationName,
                    'admin_user_id' => $user->id
                ]);

                $organization = \App\Models\Organization::create([
                    'business_name' => $this->organizationName,
                    'admin_user_id' => $user->id,
                ]);

                Log::info('Organization created successfully', [
                    'organization_id' => $organization->id,
                    'business_name' => $organization->business_name,
                    'admin_user_id' => $organization->admin_user_id
                ]);

                // Create organization staff relationship for organization admins
                Log::info('Creating organization staff relationship', [
                    'user_id' => $user->id,
                    'organization_id' => $organization->id,
                    'role_id' => 2
                ]);

                $orgStaff = \App\Models\OrganizationStaff::create([
                    'user_id' => $user->id,
                    'organization_id' => $organization->id,
                    'role_id' => 2, // organization_admin role
                    'start_date' => now()->toDateString(),
                    'is_active' => true,
                    'is_primary' => true,
                ]);

                Log::info('Organization staff created successfully', [
                    'org_staff_id' => $orgStaff->id,
                    'user_id' => $orgStaff->user_id,
                    'organization_id' => $orgStaff->organization_id,
                    'role_id' => $orgStaff->role_id
                ]);
            }

            // Create clinic for doctors/providers
            if($userType === UserType::DOCTOR){
                // Convert state code to state ID
                $state = \App\Models\State::where('code', $this->primaryState)->first();
                $stateId = $state ? $state->id : null;

                Log::info('Creating clinic for doctor', [
                    'user_id' => $user->id,
                    'business_name' => $this->organizationName,
                    'state_code' => $this->primaryState,
                    'state_id' => $stateId
                ]);

                $clinic = \App\Models\Clinic::create([
                    'user_id' => $user->id,
                    'business_name' => $this->organizationName,
                    'state_id' => $stateId,
                    'is_active' => true,
                ]);

                Log::info('Clinic created successfully', [
                    'clinic_id' => $clinic->id,
                    'user_id' => $clinic->user_id,
                    'business_name' => $clinic->business_name
                ]);
            }

            // Add primary specialty if provided
            if ($this->primarySpecialty) {
                Log::info('Adding primary specialty', [
                    'user_id' => $user->id,
                    'specialty_id' => $this->primarySpecialty
                ]);

                $userSpecialty = \App\Models\UserSpecialty::create([
                    'user_id' => $user->id,
                    'specialty_id' => $this->primarySpecialty,
                    'is_primary' => true,
                ]);

                Log::info('Primary specialty added successfully', [
                    'user_specialty_id' => $userSpecialty->id,
                    'user_id' => $userSpecialty->user_id,
                    'specialty_id' => $userSpecialty->specialty_id
                ]);
            }

            // Create empty records for optional steps if data is provided
            $this->createOptionalRecords($user);

            \DB::commit();
            Log::info('Database transaction committed successfully');

            // Authenticate the user with session persistence
            Auth::login($user, true); // true = remember the user
            Log::info('User authenticated after registration', [
                'user_id' => $user->id,
                'email' => $user->email,
                'is_authenticated' => Auth::check(),
                'authenticated_user_id' => Auth::id()
            ]);

            // Refresh the user session to ensure it's properly loaded
            $user->refresh();
            Log::info('User session refreshed', [
                'user_id' => $user->id,
                'user_type' => $user->user_type->value
            ]);

            session()->flash('success', 'Account created successfully! Welcome to your dashboard.');

            // Verify authentication and email verification before redirect
            Log::info('Pre-redirect authentication check', [
                'is_authenticated' => Auth::check(),
                'authenticated_user_id' => Auth::id(),
                'user_type' => $userType->value,
                'user_id' => $user->id,
                'email_verified' => $user->email_verified_at !== null,
                'email_verified_at' => $user->email_verified_at
            ]);

            // Redirect to dashboard
            if($userType === UserType::DOCTOR){
                Log::info('Redirecting doctor to dashboard', [
                    'user_id' => $user->id,
                    'route' => 'doctor.dashboard',
                    'is_authenticated' => Auth::check()
                ]);
                return redirect()->route('doctor.dashboard');
            }
            if($userType === UserType::ORGANIZATION_ADMIN){
                Log::info('Redirecting organization admin to dashboard', [
                    'user_id' => $user->id,
                    'route' => 'organization_admin.dashboard',
                    'is_authenticated' => Auth::check()
                ]);
                return redirect()->route('organization_admin.dashboard');
            }

            // Fallback redirect
            Log::info('Fallback redirect to home', ['user_id' => $user->id]);
            return redirect()->route('home');

        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('error', 'Registration failed. Please try again.');
            \Log::error('Registration failed: ' . $e->getMessage());
        }
    }

    /**
     * Create optional records for steps 2-6 if data is provided
     */
    private function createOptionalRecords($user)
    {
        Log::info('Creating optional records for user', [
            'user_id' => $user->id,
            'user_type' => $user->user_type->value
        ]);

        $doctorProfile = null; // Initialize doctor profile variable

        // Create DoctorProfile for doctors (required for other records)
        if ($user->user_type === UserType::DOCTOR) {
            Log::info('Creating doctor profile', [
                'user_id' => $user->id,
                'npi_number' => $this->npiNumber,
                'primary_specialty_id' => $this->primarySpecialty
            ]);

            $doctorProfile = \App\Models\DoctorProfile::create([
                'user_id' => $user->id,
                'npi_number' => $this->npiNumber,
                'dea_number' => $this->deaNumber,
                'caqh_id' => $this->caqhId,
                'primary_specialty_id' => $this->primarySpecialty,
                'status' => 'active',
            ]);

            Log::info('Doctor profile created successfully', [
                'doctor_profile_id' => $doctorProfile->id,
                'user_id' => $doctorProfile->user_id
            ]);
        }

        // Step 2: Personal & Contact Information
        if ($this->hasPersonalData()) {
            Log::info('Creating personal information record', [
                'user_id' => $user->id,
                'has_middle_name' => !empty($this->middleName),
                'has_date_of_birth' => !empty($this->dateOfBirth),
                'has_ssn' => !empty($this->ssn)
            ]);

            $personalInfo = \App\Models\UserPersonalInfo::create([
                'user_id' => $user->id,
                'middle_name' => $this->middleName,
                'date_of_birth' => $this->dateOfBirth,
                'ssn' => $this->ssn,
                'home_address' => $this->homeAddress,
                'practice_address' => $this->practiceAddress,
                'phone_number' => $this->phoneNumber,
                'npi_number' => $this->npiNumber,
                'caqh_id' => $this->caqhId,
                'caqh_login' => $this->caqhLogin,
                'caqh_password' => $this->caqhPassword,
                'pecos_login' => $this->pecosLogin,
                'pecos_password' => $this->pecosPassword,
            ]);

            Log::info('Personal information created successfully', [
                'personal_info_id' => $personalInfo->id,
                'user_id' => $personalInfo->user_id
            ]);
        } else {
            Log::info('No personal data provided, skipping personal info creation');
        }

        // Step 3: Credentials & Licenses
        if ($this->hasCredentialsData() && isset($doctorProfile)) {
            Log::info('Creating credentials and licenses', [
                'user_id' => $user->id,
                'doctor_profile_id' => $doctorProfile->id,
                'licenses_count' => count($this->stateLicenses ?? []),
                'educations_count' => count($this->educations ?? [])
            ]);

            foreach ($this->stateLicenses as $license) {
                if (!empty($license['state']) && !empty($license['license_number'])) {
                    // Convert state code to state ID
                    $state = \App\Models\State::where('code', $license['state'])->first();
                    $stateId = $state ? $state->id : null;

                    $doctorLicense = \App\Models\DoctorLicense::create([
                        'doctor_profile_id' => $doctorProfile->id,
                        'license_type_id' => 1, // Default to "Medical Doctor"
                        'state_id' => $stateId,
                        'license_number' => $license['license_number'],
                        'issue_date' => $license['issue_date'],
                        'expiration_date' => $license['expiration_date'],
                        'issuing_authority' => 'State Medical Board', // Default value
                    ]);

                    Log::info('Doctor license created', [
                        'license_id' => $doctorLicense->id,
                        'state_id' => $doctorLicense->state_id,
                        'license_number' => $doctorLicense->license_number
                    ]);
                }
            }

            foreach ($this->educations as $education) {
                if (!empty($education['institution']) && !empty($education['degree'])) {
                    $educationRecord = \App\Models\Education::create([
                        'user_id' => $user->id,
                        'institution_name' => $education['institution'],
                        'degree' => $education['degree'],
                        'graduation_date' => $education['year_completed'],
                    ]);

                    Log::info('Education record created', [
                        'education_id' => $educationRecord->id,
                        'user_id' => $educationRecord->user_id,
                        'institution' => $educationRecord->institution_name
                    ]);
                }
            }
        } else {
            Log::info('No credentials data provided or doctor profile not available', [
                'has_credentials_data' => $this->hasCredentialsData(),
                'doctor_profile_exists' => isset($doctorProfile)
            ]);
        }

        // Step 4: Professional History
        if ($this->hasWorkHistoryData() && isset($doctorProfile)) {
            Log::info('Creating work history and references', [
                'user_id' => $user->id,
                'doctor_profile_id' => $doctorProfile->id,
                'work_history_count' => count($this->workHistory ?? []),
                'references_count' => count($this->references ?? [])
            ]);

            foreach ($this->workHistory as $work) {
                if (!empty($work['practice_name']) && !empty($work['position'])) {
                    $workHistory = \App\Models\DoctorWorkHistory::create([
                        'doctor_profile_id' => $doctorProfile->id,
                        'organization_name' => $work['practice_name'],
                        'position_title' => $work['position'],
                        'start_date' => $work['start_date'],
                        'end_date' => $work['end_date'],
                        'is_current' => empty($work['end_date']),
                    ]);

                    Log::info('Work history created', [
                        'work_history_id' => $workHistory->id,
                        'organization_name' => $workHistory->organization_name,
                        'position_title' => $workHistory->position_title
                    ]);
                }
            }

            foreach ($this->references as $reference) {
                if (!empty($reference['full_name']) && !empty($reference['title'])) {
                    $referenceRecord = \App\Models\DoctorReference::create([
                        'doctor_profile_id' => $doctorProfile->id,
                        'reference_full_name' => $reference['full_name'],
                        'reference_title' => $reference['title'],
                        'reference_specialty' => $reference['specialty'] ?? 'General Medicine',
                        'organization_name' => $reference['organization'] ?? 'N/A',
                        'phone' => $reference['phone'],
                        'email' => $reference['email'],
                        'relationship_type' => $reference['relationship'] ?? 'Professional',
                        'years_known' => $reference['years_known'] ?? 1,
                        'status' => 'active',
                    ]);

                    Log::info('Reference created', [
                        'reference_id' => $referenceRecord->id,
                        'reference_name' => $referenceRecord->reference_full_name,
                        'reference_title' => $referenceRecord->reference_title
                    ]);
                }
            }
        } else {
            Log::info('No work history data provided or doctor profile not available', [
                'has_work_history_data' => $this->hasWorkHistoryData(),
                'doctor_profile_exists' => isset($doctorProfile)
            ]);
        }

        // Step 5: Insurance & Attestation
        if ($this->hasInsuranceData()) {
            Log::info('Creating insurance and attestation records', [
                'user_id' => $user->id,
                'carrier' => $this->insuranceCarrier,
                'policy_number' => $this->policyNumber
            ]);

            $insurance = \App\Models\Insurance::create([
                'user_id' => $user->id,
                'carrier' => $this->insuranceCarrier,
                'policy_number' => $this->policyNumber,
                'coverage_amount' => is_numeric($this->coverageAmount) ? (float)$this->coverageAmount : null,
                'effective_date' => $this->policyEffectiveDate,
                'expiration_date' => $this->policyExpirationDate,
            ]);

            Log::info('Insurance record created', [
                'insurance_id' => $insurance->id,
                'user_id' => $insurance->user_id,
                'carrier' => $insurance->carrier
            ]);

            $attestation = \App\Models\Attestation::create([
                'user_id' => $user->id,
                'license_suspended' => $this->licenseSuspended,
                'felony_conviction' => $this->felonyConviction,
                'malpractice_claims' => $this->malpracticeClaims,
            ]);

            Log::info('Attestation record created', [
                'attestation_id' => $attestation->id,
                'user_id' => $attestation->user_id,
                'license_suspended' => $attestation->license_suspended
            ]);
        } else {
            Log::info('No insurance data provided, skipping insurance and attestation creation');
        }

        // Step 6: Document Upload
        if ($this->hasDocumentData() && isset($doctorProfile)) {
            Log::info('Uploading documents', [
                'user_id' => $user->id,
                'doctor_profile_id' => $doctorProfile->id
            ]);
            $this->uploadDocuments($doctorProfile);
        } else {
            Log::info('No document data provided or doctor profile not available', [
                'has_document_data' => $this->hasDocumentData(),
                'doctor_profile_exists' => isset($doctorProfile)
            ]);
        }

        Log::info('Optional records creation completed', [
            'user_id' => $user->id,
            'user_type' => $user->user_type->value
        ]);
    }

    /**
     * Check if personal data is provided
     */
    private function hasPersonalData()
    {
        return !empty($this->middleName) ||
               !empty($this->dateOfBirth) ||
               !empty($this->ssn) ||
               !empty($this->homeAddress) ||
               !empty($this->practiceAddress) ||
               !empty($this->phoneNumber) ||
               !empty($this->npiNumber) ||
               !empty($this->caqhId);
    }

    /**
     * Check if credentials data is provided
     */
    private function hasCredentialsData()
    {
        $hasLicense = false;
        foreach ($this->stateLicenses as $license) {
            if (!empty($license['state']) && !empty($license['license_number'])) {
                $hasLicense = true;
                break;
            }
        }

        $hasEducation = false;
        foreach ($this->educations as $education) {
            if (!empty($education['institution']) && !empty($education['degree'])) {
                $hasEducation = true;
                break;
            }
        }

        return $hasLicense || $hasEducation || !empty($this->deaNumber);
    }

    /**
     * Check if work history data is provided
     */
    private function hasWorkHistoryData()
    {
        $hasWork = false;
        foreach ($this->workHistory as $work) {
            if (!empty($work['practice_name']) && !empty($work['position'])) {
                $hasWork = true;
                break;
            }
        }

        $hasReference = false;
        foreach ($this->references as $reference) {
            if (!empty($reference['full_name']) && !empty($reference['title'])) {
                $hasReference = true;
                break;
            }
        }

        return $hasWork || $hasReference;
    }

    /**
     * Check if insurance data is provided
     */
    private function hasInsuranceData()
    {
        return !empty($this->insuranceCarrier) ||
               !empty($this->policyNumber) ||
               !empty($this->coverageAmount) ||
               $this->licenseSuspended !== null ||
               $this->felonyConviction !== null ||
               $this->malpracticeClaims !== null;
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
     * Upload documents and create DoctorDocument records
     */
    private function uploadDocuments($doctorProfile)
    {
        Log::info('Starting document upload process', [
            'doctor_profile_id' => $doctorProfile->id,
            'user_id' => $doctorProfile->user_id
        ]);

        $documentTypes = [
            'cv' => 'CV',
            'professionalLicense' => 'Professional License',
            'pictureId' => 'Picture ID',
            'socialSecurityCard' => 'Social Security Card',
            'certificateOfLiabilityInsurance' => 'Certificate of Liability Insurance',
            'copiesOfDiplomasCertifications' => 'Diplomas/Certifications',
            'stateCredentialingApplication' => 'State Credentialing Application',
            'passportStylePhoto' => 'Passport Style Photo',
            'ecfmgCertificate' => 'ECFMG Certificate',
            'boardCertificate' => 'Board Certificate',
            'procedureLog' => 'Procedure Log',
            'cmeCs' => 'CMEs/CEs',
            'immunizationShotRecords' => 'Immunization Records',
            'aclsBlsCertificate' => 'ACLS/BLS Certificate',
        ];

        foreach ($documentTypes as $property => $documentName) {
            if ($this->$property !== null) {
                $this->uploadDocument($doctorProfile, $this->$property, $documentName);
            }
        }
    }

    /**
     * Upload a single document
     */
    private function uploadDocument($doctorProfile, $file, $documentName)
    {
        try {
            // Validate file
            if (!$file || !$file->isValid()) {
                Log::warning('Invalid file uploaded for document: ' . $documentName);
                return;
            }

            // Check file size (10MB limit)
            if ($file->getSize() > 10 * 1024 * 1024) {
                Log::warning('File too large for document: ' . $documentName . ' (Size: ' . $file->getSize() . ')');
                return;
            }

            // Check file extension
            $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
            $extension = strtolower($file->extension());
            if (!in_array($extension, $allowedExtensions)) {
                Log::warning('Invalid file extension for document: ' . $documentName . ' (Extension: ' . $extension . ')');
                return;
            }

            // Generate unique filename with timestamp
            $timestamp = Carbon::now()->timestamp;
            $filename = $timestamp . '.' . $extension;

            // Store file in assets/documents directory
            $file->storeAs('assets/documents', $filename);
            $filePath = 'assets/documents/' . $filename;

            // Get or create document type
            $documentType = \App\Models\DocumentType::firstOrCreate(
                ['name' => $documentName],
                [
                    'code' => strtoupper(str_replace([' ', '/'], ['_', '_'], $documentName)),
                    'description' => $documentName . ' document',
                    'max_file_size_mb' => 10,
                    'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
                    'is_required' => false,
                    'is_active' => true,
                ]
            );

            // Create DoctorDocument record
            $doctorDocument = \App\Models\DoctorDocument::create([
                'doctor_profile_id' => $doctorProfile->id,
                'document_type_id' => $documentType->id,
                'original_filename' => $file->getClientOriginalName(),
                'stored_filename' => $filename,
                'file_path' => $filePath,
                'file_size_bytes' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'file_hash' => hash_file('sha256', $file->getRealPath()),
                'upload_date' => now()->toDateString(),
                'is_verified' => false,
                'is_current' => true,
                'version' => 1,
            ]);

            Log::info('Document uploaded successfully', [
                'document_id' => $doctorDocument->id,
                'doctor_profile_id' => $doctorProfile->id,
                'document_type' => $documentName,
                'original_filename' => $file->getClientOriginalName(),
                'stored_filename' => $filename,
                'file_size' => $file->getSize()
            ]);

        } catch (\Exception $e) {
            Log::error('Document upload failed: ' . $e->getMessage());
            // Continue with other documents even if one fails
        }
    }
}
