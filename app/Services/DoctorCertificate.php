<?php

namespace App\Services;

class DoctorCertificate
{
    public function createDoctorCertificate(array $data): DoctorCertificate
    {
        return DoctorCertificate::create($data);
    }
    public function updateDoctorCertificate(DoctorCertificate $doctorCertificate, array $data): DoctorCertificate
    {
        $doctorCertificate->update($data);
        return $doctorCertificate;
    }
    public function deleteDoctorCertificate(DoctorCertificate $doctorCertificate): void
    {
        $doctorCertificate->delete();
    }
}
    {
        //
    }
}
