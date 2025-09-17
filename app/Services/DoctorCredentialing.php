<?php

namespace App\Services;

class DoctorCredentialing
{
    /**
     * Create a new class instance.
     */
    public function createDoctorCredentialing(array $data): DoctorCredentialing
    {
        return DoctorCredentialing::create($data);
    }
    public function updateDoctorCredentialing(Credentialing $doctorCredentialing, array $data): Credentialing
    {
        $doctorCredentialing->update($data);
        return $doctorCredentialing;
    }
    public function deleteDoctorCredentialing(Credentialing $doctorCredentialing): void
    {
        $doctorCredentialing->delete();
    }
}
