<?php

namespace App\Services;

use App\Models\DoctorReference;

class DoctorReference
{
    /**
     * Create a new class instance.
     */
    public function createDoctorReference(array $data): DoctorReference
    {
        return DoctorReference::create($data);
    }
    public function updateDoctorReference(DoctorReference $doctorReference, array $data): DoctorReference
    {
        $doctorReference->update($data);
        return $doctorReference;
    }
    public function deleteDoctorReference(DoctorReference $doctorReference): void
    {
        $doctorReference->delete();
    }
}
