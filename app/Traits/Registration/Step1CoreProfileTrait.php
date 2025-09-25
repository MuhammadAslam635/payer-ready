<?php

namespace App\Traits\Registration;

use App\Enums\UserType;
use App\Models\Clinic;
use App\Models\Organization;
use App\Models\OrganizationStaff;
use App\Models\User;
use App\Models\DoctorSpecialty;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

trait Step1CoreProfileTrait
{
    // Step 1: Core Profile
    public $name = '';
    public $email = '';
    public $organizationName = '';
    public $primarySpecialty = '';
    public $primaryState = '';
    public $password = '';
    public $password_confirmation = '';
    public $taxnomy_code = '';
    /**
     * Process Step 1: Core Profile data
     */
    private function validateStep1Strictly()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'taxnomy_code' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'organizationName' => 'required|string|max:255',
            'primaryState' => 'nullable|exists:states,id',
            'password' => ['required', 'confirmed', Password::min(8)],
            'password_confirmation' => 'required',
            'primarySpecialty' => 'nullable|exists:specialties,id',
        ]);
    }
    public function processStep1CoreProfile()
    {
        // Set correct user type
        $userType = $this->userType === 'organization' ? UserType::ORGANIZATION_ADMIN : UserType::DOCTOR;
        // Create user account
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'taxnomy_code' => $this->taxnomy_code,
            'password' => Hash::make($this->password),
            'user_type' => $userType,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $organization = null;

        // Create organization for organization types
        if ($userType === UserType::ORGANIZATION_ADMIN && $this->organizationName) {
            $organization = $this->createOrganization($user);
        }

        // Create clinic for doctors
        if ($userType === UserType::DOCTOR && $this->organizationName) {
            $this->createClinic($user);
        }

        // Add primary specialty if provided
        if ($this->primarySpecialty) {
            $this->addPrimarySpecialty($user);
        }

        return [
            'user' => $user,
            'organization' => $organization,
        ];
    }

    /**
     * Create organization for organization admin
     */
    private function createOrganization(User $user)
    {

        $organization = Organization::create([
            'business_name' => $this->organizationName,
            'user_id' => $user->id,
            'tax_id' => null,
            'is_active' => true,
        ]);

        // Create organization staff relationship
        $orgStaff = OrganizationStaff::create([
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'role_id' => 2,
            'start_date' => now()->toDateString(),
            'is_active' => true,
            'is_primary' => true,
        ]);

        return $organization;
    }

    /**
     * Create clinic for doctors
     */
    private function createClinic(User $user)
    {
        // Convert state code to state ID
        $state = \App\Models\State::where('code', $this->primaryState)->first();
        $stateId = $state ? $state->id : null;

            $clinic = Clinic::create([
                'user_id' => $user->id,
                'business_name' => $this->organizationName,
                'state_id' => $stateId,
                'is_active' => true,
            ]);

        return $clinic;
    }

    /**
     * Add primary specialty for doctors
     */
    private function addPrimarySpecialty(User $user)
    {
        $DoctorSpecialty = DoctorSpecialty::create([
            'user_id' => $user->id,
            'specialty_id' => $this->primarySpecialty,
            'is_primary' => true,
        ]);

        return $DoctorSpecialty;
    }
}
