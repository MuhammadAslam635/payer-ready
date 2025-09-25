<?php

namespace App\Traits\Registration;

use App\Models\User;
use App\Models\Address;
use App\Models\State;
use Illuminate\Support\Facades\Log;

trait Step2PersonalContactTrait
{
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
    /**
     * Process Step 2: Personal & Contact data
     */
     private function validateStep2PersonalContact()
    {
        if ($this->userType === 'doctor') {
            $this->validate([
                'middleName' => 'nullable|string|max:255',
                'dateOfBirth' => 'nullable|date|before:today',
                'ssn' => 'nullable|string|regex:/^\d{3}-\d{2}-\d{4}$/',
                'homeAddress' => 'nullable|string|max:500',
                'practiceAddress' => 'nullable|string|max:500',
                'phoneNumber' => 'nullable|string|regex:/^\+?[\d\s\-\(\)]+$/',
                'npiNumber' => 'nullable|string|regex:/^\d{10}$/',
            ]);
        }
    }
    public function processStep2PersonalContact(User $user)
    {
        // Validate step 2 data internally
        $this->validateStep2PersonalContact();

        $this->updateUser($user);
        $addresses = [];

        // Create address records if address data is provided
        if ($this->hasAddressData()) {
            $addresses = $this->createAddressRecords($user);
        }

        return [
            'user_updated' => true,
            'addresses' => $addresses,
        ];
    }
    public function updateUser(User $user)
    {
        $user->update([
            'middle_name' => $this->middleName,
            'date_of_birth' => $this->dateOfBirth,
            'ssn_encrypted' => $this->ssn ? encrypt($this->ssn) : null,
            'phone' => $this->phoneNumber,
            'npi_number' => $this->npiNumber,
            'caqh_id' => $this->caqhId,
            'caqh_login' => $this->caqhLogin,
            'caqh_password' => $this->caqhPassword,
            'pecos_login' => $this->pecosLogin,
            'pecos_password' => $this->pecosPassword,
        ]);
    }
    public function hasAddressData()
    {
        return !empty($this->homeAddress) || !empty($this->practiceAddress);
    }

    public function createAddressRecords(User $user)
    {
        $addresses = [];
        
        // Get state_id from primaryState (could be either state ID or state code)
        $stateId = null;
        if (!empty($this->primaryState)) {
            // Check if primaryState is numeric (state ID) or string (state code)
            if (is_numeric($this->primaryState)) {
                $stateId = $this->primaryState;
            } else {
                // Convert state code to state ID
                $state = \App\Models\State::where('code', $this->primaryState)->first();
                $stateId = $state ? $state->id : null;
            }
        }

        Log::info('Creating addresses with state information', [
            'primaryState' => $this->primaryState,
            'resolved_state_id' => $stateId,
            'user_id' => $user->id
        ]);
        
        // Create home address if provided
        if (!empty($this->homeAddress)) {
            try {
                $homeAddress = Address::create([
                    'user_id' => $user->id,
                    'address' => $this->homeAddress,
                    'state_id' => $stateId,
                    'address_type' => 'home',
                    'is_primary' => true,
                ]);

                $addresses[] = $homeAddress;

                Log::info('Home address created successfully', [
                    'address_id' => $homeAddress->id,
                    'user_id' => $homeAddress->user_id,
                    'address_type' => $homeAddress->address_type,
                    'address' => $homeAddress->address,
                    'state_id' => $homeAddress->state_id
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to create home address', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                    'address_data' => $this->homeAddress,
                    'state_id' => $stateId
                ]);
            }
        }

        // Create practice address if provided
        if (!empty($this->practiceAddress)) {
            try {
                $practiceAddress = Address::create([
                    'user_id' => $user->id,
                    'address' => $this->practiceAddress,
                    'state_id' => $stateId,
                    'address_type' => 'practice',
                    'is_primary' => false,
                ]);

                $addresses[] = $practiceAddress;

                Log::info('Practice address created successfully', [
                    'address_id' => $practiceAddress->id,
                    'user_id' => $practiceAddress->user_id,
                    'address_type' => $practiceAddress->address_type,
                    'address' => $practiceAddress->address,
                    'state_id' => $practiceAddress->state_id
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to create practice address', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                    'address_data' => $this->practiceAddress,
                    'state_id' => $stateId
                ]);
            }
        }

        return $addresses;
    }

    public function createAddress(User $user, $address, $addressType, State $state)
    {
        $address = Address::create([
            'address' => $address,
            'state_id' => $state->id,
            'address_type' => $addressType,
            'is_primary' => true,
        ]);

        return $address;
    }
}



