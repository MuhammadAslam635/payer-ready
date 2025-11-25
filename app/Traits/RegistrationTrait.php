<?php

namespace App\Traits;

use Illuminate\Validation\Rules\Password;
use App\Enums\UserType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
use App\Traits\HasToast;
// Import step traits
use App\Traits\Registration\Step1CoreProfileTrait;
use App\Traits\Registration\Step2PersonalContactTrait;
use App\Traits\Registration\Step3CredentialsLicensesTrait;
use App\Traits\Registration\Step4ProfessionalHistoryTrait;
use App\Traits\Registration\Step5InsuranceAttestationTrait;
use App\Traits\Registration\Step6DocumentUploadTrait;
use App\Traits\Registration\Step7ReviewESignTrait;

trait RegistrationTrait
{
    use HasToast;
    use WithFileUploads;

    // Use all step traits
    use Step1CoreProfileTrait;
    use Step2PersonalContactTrait;
    use Step3CredentialsLicensesTrait;
    use Step4ProfessionalHistoryTrait;
    use Step5InsuranceAttestationTrait;
    use Step6DocumentUploadTrait;
    use Step7ReviewESignTrait;

    // Step management properties
    public $currentStep = 1;
    public $totalSteps = 7;
    public $userType = 'doctor';

    // Cache for step data validation to avoid repeated checks
    private $stepDataCache = [];

    // Store original values to prevent unwanted changes
    private $originalEmail = null;
    private $stepValidationMode = 'strict'; // 'strict' or 'warning'

    // Prevent double submission
    private $isSubmitting = false;

    public function mount($userType = null)
    {
        if ($userType) {
            $this->userType = $userType;
        }

        // Store email in session to prevent data corruption
        if (!empty($this->email)) {
            session(['registration_email' => $this->email]);
            $this->originalEmail = $this->email;
        }

        // Initialize email from session if available
        if (session()->has('registration_email') && empty($this->email)) {
            $this->email = session('registration_email');
            $this->originalEmail = $this->email;
        }
    }

    public function nextStep()
    {
        // Store current email in session before validation
        if (!empty($this->email)) {
            session(['registration_email' => $this->email]);
        }

        // Validate current step before advancing
        $this->validateCurrentStep();

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            Log::info('Step advanced', [
                'new_step' => $this->currentStep,
                'total_steps' => $this->totalSteps
            ]);
        }
    }

    /**
     * Skip current step (only allowed for steps 2-6)
     */
    public function skipStep()
    {
        // Step 1 is required (core profile)
        if ($this->currentStep == 1) {
            $this->toastError('Step 1 is required and cannot be skipped.');
            return;
        }

        // Step 7 is required (signature)
        if ($this->currentStep == 7) {
            $this->toastError('Step 7 is required and cannot be skipped.');
            return;
        }

        // Steps 2-6 can be skipped
        if ($this->currentStep >= 2 && $this->currentStep <= 6) {
            $this->currentStep++;
            Log::info('Step skipped', [
                'skipped_step' => $this->currentStep - 1,
                'new_step' => $this->currentStep,
                'total_steps' => $this->totalSteps
            ]);
            $this->toastInfo("Step " . ($this->currentStep - 1) . " skipped. You can complete it later from your dashboard.");
        }
    }

    /**
     * Clear step data cache when form data changes
     */
    public function clearStepDataCache($step = null)
    {
        if ($step !== null) {
            unset($this->stepDataCache[$step]);
        } else {
            $this->stepDataCache = [];
        }
    }

    /**
     * Validate the current step based on step number
     */
    private function validateCurrentStep()
    {
        switch ($this->currentStep) {
            case 1:
                // Step 1 is always required - validate core profile fields
                $this->validateStep1CoreProfile();
                break;
            case 2:
                // Step 2 uses #[Validate] attributes - no manual validation needed
                // Livewire automatically validates properties with #[Validate] attributes
                break;
            case 3:
                // Step 3 is optional - only validate if data is provided
                if ($this->hasStepData(3) && method_exists($this, 'validateStep3CredentialsLicenses')) {
                    $this->validateStep3CredentialsLicenses();
                }
                break;
            case 4:
                // Step 4 is optional - only validate if data is provided
                if ($this->hasStepData(4) && method_exists($this, 'validateStep4ProfessionalHistory')) {
                    $this->validateStep4ProfessionalHistory();
                }
                break;
            case 5:
                // Step 5 is optional - only validate if data is provided
                if ($this->hasStepData(5) && method_exists($this, 'validateStep5InsuranceAttestation')) {
                    $this->validateStep5InsuranceAttestation();
                }
                break;
            case 6:
                // Step 6 is optional - only validate if data is provided
                if ($this->hasStepData(6) && method_exists($this, 'validateStep6DocumentUpload')) {
                    $this->validateStep6DocumentUpload();
                }
                break;
            case 7:
                // Step 7 is always required - validate signature and terms
                if (method_exists($this, 'validateStep7ReviewESign')) {
                    $this->validateStep7ReviewESign();
                }
                break;
        }
    }

    /**
     * Validate Step 1 - Core Profile (always required)
     */
    private function validateStep1CoreProfile()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ];

        if ($this->userType === 'doctor') {
            $rules['organizationName'] = 'required|string|max:255';
            $rules['primarySpecialty'] = 'required|exists:specialties,id';
            $rules['primaryState'] = 'required|exists:states,id';
        } elseif ($this->userType === 'organization') {
            $rules['organizationName'] = 'required|string|max:255';
            $rules['primarySpecialty'] = 'required|exists:specialties,id';
            $rules['primaryState'] = 'required|exists:states,id';
        }

        $this->validate($rules);
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }



    public function goToStep($step)
    {
        if ($step >= 1 && $step <= $this->totalSteps) {
            $this->currentStep = $step;
            Log::info('Navigated to step', [
                'step' => $step,
                'total_steps' => $this->totalSteps
            ]);
        }
    }

    private function hasStepData($step)
    {
        // Check cache first to avoid repeated calculations
        if (isset($this->stepDataCache[$step])) {
            return $this->stepDataCache[$step];
        }

        $hasData = false;

        switch ($step) {
            case 2:
                $hasData = $this->hasPersonalData();
                break;
            case 3:
                $hasData = $this->hasCredentialsData();
                break;
            case 4:
                $hasData = $this->hasWorkHistoryData();
                break;
            case 5:
                $hasData = $this->hasInsuranceData();
                break;
            case 6:
                $hasData = $this->hasDocumentData();
                break;
            default:
                $hasData = false;
        }

        // Cache the result
        $this->stepDataCache[$step] = $hasData;

        return $hasData;
    }

    /**
     * Delegate validation to step traits
     */

    public function submitForm()
    {
        // Prevent double submission
        if ($this->isSubmitting) {
            Log::warning('Double submission attempt prevented', [
                'user_type' => $this->userType,
                'email' => $this->email,
            ]);
            return;
        }

        $this->isSubmitting = true;

        Log::info('=== REGISTRATION SUBMIT STARTED ===', [
            'user_type' => $this->userType,
            'email' => session('registration_email', $this->email), // Use session email if available
            'name' => $this->name,
            'organization_name' => $this->organizationName ?? 'N/A',
        ]);

        // Use session email for submission to prevent data corruption
        if (session()->has('registration_email')) {
            $this->email = session('registration_email');
        }

        try {
            // Validate step 1 before submission
            $this->validateStep1CoreProfile();

            DB::beginTransaction();

            // Process only step 1 - create user account
            $step1Result = $this->processStep1CoreProfile();
            $user = $step1Result['user'];
            $organization = $step1Result['organization'];

            // Commented out - other steps are not processed
            // if ($this->hasPersonalData()) {
            //     $this->processStep2PersonalContact($user);
            // }

            // if ($this->hasCredentialsData()) {
            //     $this->processStep3CredentialsLicenses($user);
            // }

            // if ($this->hasWorkHistoryData()) {
            //     $this->processStep4ProfessionalHistory($user);
            // }

            // if ($this->hasInsuranceData() || $this->hasAttestationData()) {
            //     $this->processStep5InsuranceAttestation($user);
            // }

            // if ($this->hasDocumentData()) {
            //     $this->processStep6DocumentUpload($user);
            // }

            // $this->processStep7ReviewESign($user);

            DB::commit();

            // Clean up session variables after successful registration
            session()->forget('registration_email');
            Log::info('=== REGISTRATION COMPLETED - SESSION CLEANED ===', [
                'user_id' => $user->id,
                'email' => $user->email,
                'session_email_removed' => true
            ]);

            // Authenticate user
            Auth::login($user, true);
            $this->toastSuccess("Registration successful! Redirecting to dashboard.");
            
            // Redirect based on user type
            if ($user->user_type === UserType::DOCTOR) {
                return redirect()->route('doctor.dashboard');
            }

            if ($user->user_type === UserType::ORGANIZATION_ADMIN) {
                return redirect()->route('organization_admin.dashboard');
            }

            return redirect()->route('home');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration failed: ' . $e->getMessage());
            $this->toastError('Registration failed: ' . $e->getMessage());
            throw $e;
        } finally {
            $this->isSubmitting = false;
        }
    }

    // Helper methods remain the same...
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

    private function hasWorkHistoryData()
    {
        // Check if any work history fields have data
        if (!empty($this->workHistory)) {
            foreach ($this->workHistory as $work) {
                if (!empty($work['employer']) || !empty($work['position']) || !empty($work['start_date']) || !empty($work['end_date'])) {
                    return true;
                }
            }
        }

        // Check if any reference fields have data
        if (!empty($this->references)) {
            foreach ($this->references as $reference) {
                if (!empty($reference['name']) || !empty($reference['email']) || !empty($reference['phone']) ||
                    !empty($reference['relationship']) || !empty($reference['title']) || !empty($reference['facility_address'])) {
                    return true;
                }
            }
        }

        return false;
    }

    private function hasInsuranceData()
    {
        return !empty($this->insuranceCarrier) ||
               !empty($this->policyNumber) ||
               !empty($this->coverageAmount) ||
               !empty($this->policyEffectiveDate) ||
               !empty($this->policyExpirationDate) ||
               $this->licenseSuspended !== null ||
               $this->felonyConviction !== null ||
               $this->malpracticeClaims !== null;
    }

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
}
