<?php

namespace App\Services;

use App\Models\DoctorDocument;

class DoctorDocument
{
    public function createDoctorDocument(array $data): DoctorDocument
    {
        return DoctorDocument::create($data);
    }
    public function updateDoctorDocument(DoctorDocument $doctorDocument, array $data): DoctorDocument
    {
        $doctorDocument->update($data);
        return $doctorDocument;
    }
    public function deleteDoctorDocument(DoctorDocument $doctorDocument): void
    {
        $doctorDocument->delete();
    }
}
