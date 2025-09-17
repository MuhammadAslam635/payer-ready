<?php

namespace App\Services;

use App\Models\DoctorProfile;

class DoctorProfile
{
    public function createDoctorProfile(array $data): DoctorProfile
    {
        return DoctorProfile::create($data);
    }
    public function updateDoctorProfile(DoctorProfile $doctorProfile, array $data): DoctorProfile
    {
        $doctorProfile->update($data);
        return $doctorProfile;
    }
    public function deleteDoctorProfile(DoctorProfile $doctorProfile): void
    {
        $doctorProfile->delete();
    }
}
