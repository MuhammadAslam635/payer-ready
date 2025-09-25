<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'npi_number' => ['nullable', 'string', 'max:10', Rule::unique('users')->ignore($user->id)],
            'dea_number' => ['nullable', 'string', 'regex:/^[A-Z]{2}\d{7}$/', Rule::unique('users')->ignore($user->id)],
            'dea_expiration_date' => ['nullable', 'date'],
            'caqh_id' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'caqh_login' => ['nullable', 'string', 'max:255'],
            'caqh_password' => ['nullable', 'string', 'max:255'],
            'pecos_login' => ['nullable', 'string', 'max:255'],
            'pecos_password' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'middle_name' => $input['middle_name'] ?? null,
                'email' => $input['email'],
                'phone' => $input['phone'] ?? null,
                'date_of_birth' => $input['date_of_birth'] ?? null,
                'npi_number' => $input['npi_number'] ?? null,
                'dea_number' => $input['dea_number'] ?? null,
                'dea_expiration_date' => $input['dea_expiration_date'] ?? null,
                'caqh_id' => $input['caqh_id'] ?? null,
                'caqh_login' => $input['caqh_login'] ?? null,
                'caqh_password' => $input['caqh_password'] ?? null,
                'pecos_login' => $input['pecos_login'] ?? null,
                'pecos_password' => $input['pecos_password'] ?? null,
                'is_active' => $input['is_active'] ?? true,
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'middle_name' => $input['middle_name'] ?? null,
            'email' => $input['email'],
            'phone' => $input['phone'] ?? null,
            'date_of_birth' => $input['date_of_birth'] ?? null,
            'npi_number' => $input['npi_number'] ?? null,
            'dea_number' => $input['dea_number'] ?? null,
            'dea_expiration_date' => $input['dea_expiration_date'] ?? null,
            'caqh_id' => $input['caqh_id'] ?? null,
            'caqh_login' => $input['caqh_login'] ?? null,
            'caqh_password' => $input['caqh_password'] ?? null,
            'pecos_login' => $input['pecos_login'] ?? null,
            'pecos_password' => $input['pecos_password'] ?? null,
            'is_active' => $input['is_active'] ?? true,
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
