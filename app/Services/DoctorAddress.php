<?php

namespace App\Services;

use App\Models\Address;

class DoctorAddress
{
    public function createDoctorAddress(array $data): Address
    {
        return Address::create($data);
    }
    public function updateDoctorAddress(Address $doctorAddress, array $data): Address
    {
        $doctorAddress->update($data);
        return $doctorAddress;
    }
    public function deleteDoctorAddress(Address $doctorAddress): void
    {
        $doctorAddress->delete();
    }
}
