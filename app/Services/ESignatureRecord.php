<?php

namespace App\Services;

use App\Models\ESignatureRecord;

class ESignatureRecordService
{
    /**
     * Create a new class instance.
     */
    public function createESignatureRecord(array $data): ESignatureRecord
    {
        return ESignatureRecord::create($data);
    }
    public function updateESignatureRecord(ESignatureRecord $eSignatureRecord, array $data): ESignatureRecord
    {
        $eSignatureRecord->update($data);
        return $eSignatureRecord;
    }
    public function deleteESignatureRecord(ESignatureRecord $eSignatureRecord): void
    {
        $eSignatureRecord->delete();
    }
}
