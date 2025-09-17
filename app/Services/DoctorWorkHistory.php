<?php

namespace App\Services;

use App\Models\DoctorWorkHistory;

class DoctorWorkHistory
{
    /**
     * Create a new class instance.
     */
    public function createDoctorWorkHistory(array $data): DoctorWorkHistory
    {
        return DoctorWorkHistory::create($data);
    }
    public function updateDoctorWorkHistory(DoctorWorkHistory $doctorWorkHistory, array $data): DoctorWorkHistory
    {
        $doctorWorkHistory->update($data);
        return $doctorWorkHistory;
    }
    public function deleteDoctorWorkHistory(DoctorWorkHistory $doctorWorkHistory): void
    {
        $doctorWorkHistory->delete();
    }
}
