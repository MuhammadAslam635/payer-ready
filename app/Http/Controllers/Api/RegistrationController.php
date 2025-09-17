<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registration\Step1Request;
use App\Http\Requests\Registration\Step2Request;
use App\Models\Address;
use App\Models\Organization;
use App\Models\OrganizationStaff;
use App\Models\Provider;
use App\Models\ProviderCredential;
use App\Models\Specialty;
use App\Models\State;
use App\Models\User;
use App\Models\UserPersonalInfo;
use App\Models\UserSpecialty;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    /**
     * Step 1: Welcome & Core Profile
     */
    public function createProvider(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'legal_full_name' => $request->legal_full_name,
                'user_type' => 'provider',
                'is_active' => true,
            ]);

            // Create organization
            $organization = Organization::create([
                'business_name' => $request->organization_name,
                'legal_business_name' => $request->organization_name,
                'primary_state_id' => State::where('code', $request->primary_state)->first()->id,
                'admin_user_id' => $user->id,
                'organization_type' => $request->organization_type,
            ]);

            // Create organizational staff relationship
            OrganizationStaff::create([
                'user_id' => $user->id,
                'organization_id' => $organization->id,
                'role_id' => 1, // provider role
                'is_active' => true,
                'is_primary' => true,
            ]);

            // Add primary specialty
            UserSpecialty::create([
                'user_id' => $user->id,
                'specialty_id' => Specialty::where('code', $request->primary_specialty)->first()->id,
                'is_primary' => true,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Step 1 completed successfully',
                'data' => [
                    'user_id' => $user->id,
                    'current_step' => 1,
                    'completion_percentage' => 15,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete step 1',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Step 2: Personal & Contact Information
     */
    public function step2(Step2Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->user_id);

            // Update user
            $user->update([
                'middle_name' => $request->middle_name,
                'phone' => $request->phone,
                'profile_completeness' => 30,
                'registration_step' => 2,
            ]);

            // Create home address
            $homeAddress = Address::create([
                'user_id' => $user->id,
                'address_line_1' => $request->home_address_line_1,
                'address_line_2' => $request->home_address_line_2,
                'city' => $request->home_city,
                'state_id' => State::where('code', $request->home_state)->first()->id,
                'zip_code' => $request->home_zip_code,
                'country' => 'US',
                'address_type' => 'home',
            ]);

            // Create practice address
            $practiceAddress = Address::create([
                'user_id' => $user->id,
                'address_line_1' => $request->practice_address_line_1,
                'address_line_2' => $request->practice_address_line_2,
                'city' => $request->practice_city,
                'state_id' => State::where('code', $request->practice_state)->first()->id,
                'zip_code' => $request->practice_zip_code,
                'country' => 'US',
                'address_type' => 'practice',
            ]);

            // Create personal info
            UserPersonalInfo::create([
                'user_id' => $user->id,
                'ssn_encrypted' => encrypt($request->ssn),
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'primary_address_id' => $homeAddress->id,
                'practice_address_id' => $practiceAddress->id,
            ]);

            // Update user with provider information
            $user->update([
                'npi_number' => $request->npi_number,
                'caqh_id' => $request->caqh_id,
                'caqh_login_encrypted' => encrypt($request->caqh_login),
                'caqh_password_encrypted' => encrypt($request->caqh_password),
                'pecos_login_encrypted' => encrypt($request->pecos_login),
                'pecos_password_encrypted' => encrypt($request->pecos_password),
                'provider_status' => 'pending_verification',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Step 2 completed successfully',
                'data' => [
                    'user_id' => $user->id,
                    'current_step' => 2,
                    'completion_percentage' => 30,
                ],
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete step 2',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get registration progress for a user
     */
    public function getProgress(Request $request, $userId): JsonResponse
    {
        try {
            $user = User::with([
                'personalInfo',
                'organization',
                'specialties'
            ])->findOrFail($userId);

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'current_step' => $user->registration_step,
                    'completion_percentage' => $user->profile_completeness,
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get registration progress',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
