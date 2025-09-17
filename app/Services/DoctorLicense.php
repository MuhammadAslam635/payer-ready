<?php

namespace App\Services;

use App\Models\DoctorLicense;

class DoctorLicense
{
    public function createDoctorLicense(array $data): DoctorLicense
    {
        return DoctorLicense::create($data);
    }
    public function updateDoctorLicense(DoctorLicense $doctorLicense, array $data): DoctorLicense
    {
        $doctorLicense->update($data);
        return $doctorLicense;
    }
    public function deleteDoctorLicense(DoctorLicense $doctorLicense): void
    {
        $doctorLicense->delete();
    }
}
