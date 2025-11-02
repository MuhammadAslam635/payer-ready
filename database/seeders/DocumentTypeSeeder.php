<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTypes = [
            [
                'name' => 'Medical License',
                'code' => 'MED_LICENSE',
                'description' => 'Current medical license from state medical board',
                'max_file_size_mb' => 10,
                'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
                'is_required' => true,
                'is_active' => true,
            ],
            [
                'name' => 'DEA Certificate',
                'code' => 'DEA_CERT',
                'description' => 'Drug Enforcement Administration certificate',
                'max_file_size_mb' => 10,
                'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
                'is_required' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Board Certification',
                'code' => 'BOARD_CERT',
                'description' => 'Board certification in medical specialty',
                'max_file_size_mb' => 10,
                'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
                'is_required' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Malpractice Insurance',
                'code' => 'MALPRACTICE_INS',
                'description' => 'Current malpractice insurance certificate',
                'max_file_size_mb' => 10,
                'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
                'is_required' => true,
                'is_active' => true,
            ],
            [
                'name' => 'CV/Resume',
                'code' => 'CV_RESUME',
                'description' => 'Current curriculum vitae or resume',
                'max_file_size_mb' => 10,
                'allowed_extensions' => ['pdf', 'doc', 'docx'],
                'is_required' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Medical School Diploma',
                'code' => 'MED_SCHOOL_DIPLOMA',
                'description' => 'Medical school graduation diploma',
                'max_file_size_mb' => 10,
                'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
                'is_required' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Residency Certificate',
                'code' => 'RESIDENCY_CERT',
                'description' => 'Residency training completion certificate',
                'max_file_size_mb' => 10,
                'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
                'is_required' => true,
                'is_active' => true,
            ],
            [
                'name' => 'NPI Certificate',
                'code' => 'NPI_CERT',
                'description' => 'National Provider Identifier certificate',
                'max_file_size_mb' => 10,
                'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
                'is_required' => true,
                'is_active' => true,
            ],
            [
                'name' => 'CAQH Profile',
                'code' => 'CAQH_PROFILE',
                'description' => 'CAQH ProView profile document',
                'max_file_size_mb' => 10,
                'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
                'is_required' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Hospital Privileges',
                'code' => 'HOSPITAL_PRIVILEGES',
                'description' => 'Current hospital privileges documentation',
                'max_file_size_mb' => 10,
                'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'],
                'is_required' => false,
                'is_active' => true,
            ],
        ];

        foreach ($documentTypes as $type) {
            DocumentType::create($type);
        }
    }
}
