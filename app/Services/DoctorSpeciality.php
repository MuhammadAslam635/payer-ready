<?php

namespace App\Services;

use App\Models\DoctorSpeciality;
class DoctorSpeciality
{
    public function createDoctorSpeciality(array $data): DoctorSpeciality
    {
        return DoctorSpeciality::create($data);
    }
    public function updateDoctorSpeciality(DoctorSpeciality $doctorSpeciality, array $data): DoctorSpeciality
    {
        $doctorSpeciality->update($data);
        return $doctorSpeciality;
    }
    public function deleteDoctorSpeciality(DoctorSpeciality $doctorSpeciality): void
    {
        $doctorSpeciality->delete();
    }
}
