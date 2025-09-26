<?php
namespace App\Traits\Registration;

use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;

trait Step2PersonalContactTrait
{
    // Step 2: Personal & Contact
    #[Validate('nullable|string|max:255')]
    public $middleName = '';
    #[Validate('required|date|before:today')]
    public $dateOfBirth = '';
    #[Validate('nullable|string|min:3')]
    public $ssn = '';
    #[Validate('nullable|string|max:255')]
    public $homeAddress = '';
    #[Validate('nullable|string|max:255')]
    public $practiceAddress = '';
    #[Validate('nullable|string|min:10|max:14')]
    public $phoneNumber = '';
    #[Validate('nullable|string|max:255')]
    public $npiNumber = '';
    #[Validate('nullable|string|max:255')]
    public $caqhId = '';
    #[Validate('nullable|string|max:255')]
    public $caqhLogin = '';
    #[Validate('nullable|string|max:255')]
    public $caqhPassword = '';
    #[Validate('nullable|string|max:255')]
    public $pecosLogin = '';
    #[Validate('nullable|string|max:255')]
    public $pecosPassword = '';
    public function processStep2PersonalContact(User $user)
    {
        // Only process if there's data to process
        if (!$this->hasPersonalData()) {
            return null;
        }

        $this->updateUser($user);
        $addresses = [];

        // Create address records if address data is provided
        if ($this->hasAddressData()) {
            $addresses = $this->createAddressRecords($user);
        }

        return [
            'user_updated' => true,
            'addresses'    => $addresses,
        ];
    }
    public function updateUser(User $user)
    {
        $user->update([
            'middle_name'    => $this->middleName,
            'date_of_birth'  => $this->dateOfBirth,
            'ssn_encrypted'  => $this->ssn ? encrypt($this->ssn) : null,
            'phone'          => $this->phoneNumber,
            'npi_number'     => $this->npiNumber,
            'caqh_id'        => $this->caqhId,
            'caqh_login'     => $this->caqhLogin,
            'caqh_password'  => $this->caqhPassword,
            'pecos_login'    => $this->pecosLogin,
            'pecos_password' => $this->pecosPassword,
        ]);
    }
    public function hasAddressData()
    {
        return ! empty($this->homeAddress) || ! empty($this->practiceAddress);
    }

    public function createAddressRecords(User $user)
    {
        $addresses = [];

        // Get state_id from primaryState (could be either state ID or state code)
        $stateId = $this->primaryState ?? null;

        // Create home address if provided
        if (! empty($this->homeAddress)) {
            try {
                $homeAddress = Address::create([
                    'user_id'      => $user->id,
                    'address'      => $this->homeAddress,
                    'state_id'     => $stateId,
                    'address_type' => 'home',
                    'is_primary'   => true,
                ]);

                $addresses[] = $homeAddress;
            } catch (\Exception $e) {
                Log::error('Failed to create home address', [
                    'user_id'      => $user->id,
                    'error'        => $e->getMessage(),
                    'address_data' => $this->homeAddress,
                    'state_id'     => $stateId,
                ]);
            }
        }

        // Create practice address if provided
        if (! empty($this->practiceAddress)) {
            try {
                $practiceAddress = Address::create([
                    'user_id'      => $user->id,
                    'address'      => $this->practiceAddress,
                    'state_id'     => $stateId,
                    'address_type' => 'practice',
                    'is_primary'   => false,
                ]);

                $addresses[] = $practiceAddress;
            } catch (\Exception $e) {
                Log::error('Failed to create practice address', [
                    'user_id'      => $user->id,
                    'error'        => $e->getMessage(),
                    'address_data' => $this->practiceAddress,
                    'state_id'     => $stateId,
                ]);
            }
        }

        return $addresses;
    }
}
