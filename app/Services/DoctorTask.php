<?php

namespace App\Services;

use App\Models\DoctorTask;

class DoctorTask
{
    /**
     * Create a new class instance.
     */
    public function createDoctorTask(array $data): DoctorTask
    {
        return DoctorTask::create($data);
    }
    public function updateDoctorTask(DoctorTask $doctorTask, array $data): DoctorTask
    {
        $doctorTask->update($data);
        return $doctorTask;
    }
    public function deleteDoctorTask(DoctorTask $doctorTask): void
    {
        $doctorTask->delete();
    }
}
