<?php

namespace App\Traits\Registration;

use App\Enums\UserType;
use App\Models\Organization;
use App\Models\OrganizationStaff;
use App\Models\User;
use App\Models\DoctorSpecialty;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
trait Step1CoreProfileTrait
{
    // Step 1: Core Profile
    #[Validate('required|string|max:255')]
    public string $name;
    #[Validate('required|email')]
    public string $email;
    #[Validate('nullable|string|max:255')]
    public string $organizationName;
    #[Validate('nullable|exists:specialties,id')]
    public string $primarySpecialty;
    #[Validate('nullable|exists:states,id')]
    public string $primaryState;
    #[Validate('required|string|min:8|max:255|confirmed')]
    public string $password;
    #[Validate('required|string|min:8|max:255')]
    public string $password_confirmation;
    #[Validate('nullable|string|max:255')]
    public string $taxnomy_code;

    public function processStep1CoreProfile()
    {
        // Set correct user type
        $userType = $this->userType === 'organization' ? UserType::ORGANIZATION_ADMIN : UserType::DOCTOR;

        // Check if user already exists with this email
        $existingUser = User::where('email', $this->email)->first();

        if ($existingUser) {
            Log::info('Existing user found with email: ' . $this->email);

            // Validate without unique email constraint for existing users
            $this->validateWithoutUniqueEmail();

            // Return existing user and their organization
            $organization = null;
            if ($userType === UserType::ORGANIZATION_ADMIN) {
                // For organization admin, check if they are an organization themselves
                if ($existingUser->is_org) {
                    $organization = $existingUser;
                } else {
                    // Or check if they belong to a parent organization
                    $organization = $existingUser->parentOrganization;
                }
            }

            return [
                'user' => $existingUser,
                'organization' => $organization,
            ];
        }


        // Create user account
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'taxnomy_code' => $this->taxnomy_code ?? null,
            'password' => Hash::make($this->password),
            'speciality_id'=>$this->primarySpecialty,
            'state_id'=>$this->primaryState,
            'user_type' => $userType,
            'is_active' => true,
            'email_verified_at' => null, // User must verify email before login
        ]);

        $organization = null;

        // Create organization for organization types
        if ($userType === UserType::ORGANIZATION_ADMIN && $this->organizationName) {
            $organization = $this->createOrganization($user);
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
        // Update the user to be an organization
        $user->update([
            'business_name' => $this->organizationName,
            'is_org' => true,
        ]);

        return $user;
    }

    /**
     * Validate form data without unique email constraint for existing users
     */
    private function validateWithoutUniqueEmail()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email', // Remove unique constraint
            'organizationName' => 'nullable|string|max:255',
            'primarySpecialty' => 'nullable|exists:specialties,id',
            'primaryState' => 'nullable|exists:states,id',
            'password' => 'required|string|min:8|max:255|confirmed',
            'password_confirmation' => 'required|string|min:8|max:255',
            'taxnomy_code' => 'nullable|string|max:255',
        ]);
    }
}
