<?php

namespace App\Traits;

use Illuminate\Validation\Rules\Password;
use App\Enums\UserType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;

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


    // Store original values to prevent unwanted changes
    private $originalEmail = null;
    private $stepValidationMode = 'strict'; // 'strict' or 'warning'

    public function mount($userType = null)
    {
        if ($userType) {
            $this->userType = $userType;
        }

        // Initialize originalEmail when component mounts
        $this->originalEmail = $this->email;

        // Initialize email from session if available
        if (session()->has('registration_email') && empty($this->email)) {
            $this->email = session('registration_email');
            $this->originalEmail = $this->email;
            Log::info('=== EMAIL RESTORED FROM SESSION ON MOUNT ===', [
                'email' => $this->email
            ]);
        }

        Log::info('REGISTRATION MOUNT', [
            'userType' => $this->userType,
            'email' => $this->email,
            'originalEmail' => $this->originalEmail,
            'dateOfBirth' => $this->dateOfBirth,
            'session_email' => session('registration_email')
        ]);
    }

    /**
     * Prevent critical field changes after they're set
     */
    public function updated($propertyName)
    {
        Log::info('=== PROPERTY UPDATED ===', [
            'property' => $propertyName,
            'current_step' => $this->currentStep,
            'email_before' => $this->email,
            'dateOfBirth_before' => $this->dateOfBirth,
            'originalEmail' => $this->originalEmail,
            'all_properties' => [
                'name' => $this->name,
                'email' => $this->email,
                'dateOfBirth' => $this->dateOfBirth,
                'middleName' => $this->middleName,
                'organizationName' => $this->organizationName
            ]
        ]);

        // **CRITICAL FIX**: Validate email format and prevent date corruption
        if ($propertyName === 'email') {
            // Check if email looks like a date (YYYY-MM-DD format)
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->email)) {
                Log::error('=== EMAIL DATE CORRUPTION DETECTED ===', [
                    'corrupted_email' => $this->email,
                    'original_email' => $this->originalEmail,
                    'current_step' => $this->currentStep,
                    'property_updated' => $propertyName,
                    'session_email' => session('registration_email')
                ]);

                // Try to restore from session first, then original email, otherwise clear it
                if (session()->has('registration_email') && !preg_match('/^\d{4}-\d{2}-\d{2}$/', session('registration_email'))) {
                    $this->email = session('registration_email');
                    Log::info('=== EMAIL RESTORED FROM SESSION ===', [
                        'restored_email' => $this->email
                    ]);
                } elseif (!empty($this->originalEmail) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->originalEmail)) {
                    $this->email = $this->originalEmail;
                    Log::info('=== EMAIL RESTORED FROM ORIGINAL ===', [
                        'restored_email' => $this->email
                    ]);
                } else {
                    $this->email = '';
                    Log::info('=== EMAIL CLEARED DUE TO CORRUPTION ===');
                }
                return;
            }

            Log::warning('=== EMAIL PROPERTY CHANGE DETECTED ===', [
                'new_email_value' => $this->email,
                'original_email' => $this->originalEmail,
                'current_step' => $this->currentStep,
                'session_email' => session('registration_email'),
                'stack_trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5)
            ]);
        }

        // **CRITICAL DEBUG**: Log when dateOfBirth property is being changed
        if ($propertyName === 'dateOfBirth') {
            Log::warning('=== DATE_OF_BIRTH PROPERTY CHANGE DETECTED ===', [
                'new_dateOfBirth_value' => $this->dateOfBirth,
                'email_value' => $this->email,
                'current_step' => $this->currentStep,
                'stack_trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5)
            ]);
        }

        // Store email in session when it's first set (Step 1)
        if ($propertyName === 'email' && $this->currentStep <= 1 && !empty($this->email) && filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            session(['registration_email' => $this->email]);
            Log::info('=== EMAIL STORED IN SESSION ===', [
                'email' => $this->email,
                'current_step' => $this->currentStep
            ]);
        }
        if ($this->currentStep > 0 && $propertyName === 'email' && !empty($this->originalEmail)) {
            // Additional check: if email doesn't look like a valid email, restore from session or original
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                Log::warning('=== EMAIL CORRUPTION DETECTED (INVALID FORMAT) ===', [
                    'corrupted_email' => $this->email,
                    'original_email' => $this->originalEmail,
                    'property_updated' => $propertyName,
                    'current_step' => $this->currentStep,
                    'session_email' => session('registration_email')
                ]);

                // Try to restore from session first, then original email
                if (session()->has('registration_email') && filter_var(session('registration_email'), FILTER_VALIDATE_EMAIL)) {
                    $this->email = session('registration_email');
                    Log::info('=== EMAIL RESTORED FROM SESSION (INVALID FORMAT) ===', [
                        'restored_email' => $this->email
                    ]);
                } else {
                    // Restore the original email
                    $this->email = $this->originalEmail;
                    Log::info('=== EMAIL RESTORED FROM ORIGINAL (INVALID FORMAT) ===', [
                        'restored_email' => $this->email,
                        'original_email' => $this->originalEmail
                    ]);
                }
            }
        }

        // Store original email when it's first set in step 1 AND store in session
        if ($this->currentStep === 1 && $propertyName === 'email' && empty($this->originalEmail) && filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->originalEmail = $this->email;
            // Store email in session for persistence across requests
            session(['registration_email' => $this->email]);
            Log::info('=== ORIGINAL EMAIL STORED ===', [
                'email' => $this->email,
                'originalEmail' => $this->originalEmail,
                'session_stored' => true
            ]);
        }

        Log::info('=== PROPERTY UPDATE COMPLETE ===', [
            'property' => $propertyName,
            'email_after' => $this->email,
            'dateOfBirth_after' => $this->dateOfBirth,
            'originalEmail_after' => $this->originalEmail
        ]);
    }

    public function nextStep()
    {
        Log::info('=== BEFORE VALIDATION ===', [
            'current_step' => $this->currentStep,
            'user_type' => $this->userType,
            'email' => $this->email,
            'dateOfBirth' => $this->dateOfBirth,
            'validation_mode' => $this->stepValidationMode
        ]);

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
     * Validate the current step based on step number
     */
    private function validateCurrentStep()
    {
        switch ($this->currentStep) {
            case 1:
                $this->validateStep1Strictly();
                break;
            case 2:
                if ($this->hasPersonalData()) {
                    $this->validateStep2PersonalContact();
                }
                break;
            case 3:
                if ($this->hasCredentialsData()) {
                    $this->validateStep3CredentialsLicenses();
                }
                break;
            case 4:
                if ($this->hasWorkHistoryData()) {
                    $this->validateStep4ProfessionalHistory();
                }
                break;
            case 5:
                if ($this->hasInsuranceData()) {
                    $this->validateStep5InsuranceAttestation();
                }
                break;
            case 6:
                if ($this->hasDocumentData()) {
                    $this->validateStep6DocumentUpload();
                }
                break;
            case 7:
                $this->validateStep7Strictly();
                break;
        }
    }

    public function prevStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function skipStep()
    {
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            Log::info('Step skipped', [
                'new_step' => $this->currentStep,
                'total_steps' => $this->totalSteps
            ]);
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
        switch ($step) {
            case 2:
                return $this->hasPersonalData();
            case 3:
                return $this->hasCredentialsData();
            case 4:
                return $this->hasWorkHistoryData();
            case 5:
                return $this->hasInsuranceData();
            case 6:
                return $this->hasDocumentData();
            default:
                return false;
        }
    }

    /**
     * Delegate validation to step traits
     */

    public function submitForm()
    {
        Log::info('=== REGISTRATION SUBMIT STARTED ===', [
            'user_type' => $this->userType,
            'email' => $this->email,
            'name' => $this->name,
            'organization_name' => $this->organizationName ?? 'N/A',
        ]);

        // Final validation of required steps
        $this->validateStep1Strictly();
        $this->validateStep7Strictly();

        try {
            DB::beginTransaction();

            // Process each step using trait methods
            $step1Result = $this->processStep1CoreProfile();
            $user = $step1Result['user'];
            $organization = $step1Result['organization'];

            // Process optional steps only if they have data
            if ($this->hasPersonalData()) {
                $this->processStep2PersonalContact($user);
            }

            if ($this->hasCredentialsData()) {
                $this->processStep3CredentialsLicenses($user);
            }

            if ($this->hasWorkHistoryData()) {
                $this->processStep4ProfessionalHistory($user);
            }

            if ($this->hasInsuranceData()) {
                $this->processStep5InsuranceAttestation($user);
            }

            if ($this->hasDocumentData()) {
                $this->processStep6DocumentUpload($user);
            }

            $this->processStep7ReviewESign($user);

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
            session()->flash('error', 'Registration failed. Please try again.');
            throw $e;
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
               $this->certificateOfLiabilityInsurance !== null;
    }
}
