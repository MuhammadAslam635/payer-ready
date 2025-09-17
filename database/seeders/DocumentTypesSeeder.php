<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTypes = [
            // Identity Documents
            ['code' => 'DRIVER_LICENSE', 'name' => 'Driver\'s License', 'description' => 'Valid driver\'s license or state ID', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => true, 'is_active' => true],
            ['code' => 'PASSPORT', 'name' => 'Passport', 'description' => 'Valid passport or passport card', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'BIRTH_CERT', 'name' => 'Birth Certificate', 'description' => 'Official birth certificate', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'SSN_CARD', 'name' => 'Social Security Card', 'description' => 'Social Security card or W-2 form', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => true, 'is_active' => true],

            // Professional Licenses
            ['code' => 'MEDICAL_LICENSE', 'name' => 'Medical License', 'description' => 'Current medical license from state board', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => true, 'is_active' => true],
            ['code' => 'DEA_LICENSE', 'name' => 'DEA License', 'description' => 'DEA registration certificate', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'CDS_LICENSE', 'name' => 'Controlled Dangerous Substances License', 'description' => 'State CDS license if applicable', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'NPI_CERT', 'name' => 'NPI Certificate', 'description' => 'National Provider Identifier certificate', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => true, 'is_active' => true],

            // Education Documents
            ['code' => 'MEDICAL_DEGREE', 'name' => 'Medical Degree', 'description' => 'Medical school diploma or degree certificate', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => true, 'is_active' => true],
            ['code' => 'RESIDENCY_CERT', 'name' => 'Residency Certificate', 'description' => 'Residency training completion certificate', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => true, 'is_active' => true],
            ['code' => 'FELLOWSHIP_CERT', 'name' => 'Fellowship Certificate', 'description' => 'Fellowship training completion certificate', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'BOARD_CERT', 'name' => 'Board Certification', 'description' => 'Board certification certificate', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'TRANSCRIPT', 'name' => 'Medical School Transcript', 'description' => 'Official medical school transcript', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf'], 'is_required' => false, 'is_active' => true],

            // Training and Certifications
            ['code' => 'BLS_CERT', 'name' => 'BLS Certification', 'description' => 'Basic Life Support certification', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => true, 'is_active' => true],
            ['code' => 'ACLS_CERT', 'name' => 'ACLS Certification', 'description' => 'Advanced Cardiac Life Support certification', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'PALS_CERT', 'name' => 'PALS Certification', 'description' => 'Pediatric Advanced Life Support certification', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'ATLS_CERT', 'name' => 'ATLS Certification', 'description' => 'Advanced Trauma Life Support certification', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],

            // Insurance Documents
            ['code' => 'MALPRACTICE_INS', 'name' => 'Malpractice Insurance', 'description' => 'Current malpractice insurance certificate', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => true, 'is_active' => true],
            ['code' => 'LIABILITY_INS', 'name' => 'General Liability Insurance', 'description' => 'General liability insurance certificate', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'WORKERS_COMP', 'name' => 'Workers\' Compensation', 'description' => 'Workers\' compensation insurance certificate', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],

            // Professional References
            ['code' => 'PROF_REFERENCE', 'name' => 'Professional Reference', 'description' => 'Professional reference letter or form', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'doc', 'docx'], 'is_required' => false, 'is_active' => true],
            ['code' => 'PEER_REFERENCE', 'name' => 'Peer Reference', 'description' => 'Peer reference letter from colleague', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'doc', 'docx'], 'is_required' => false, 'is_active' => true],

            // Work History
            ['code' => 'CV_RESUME', 'name' => 'CV/Resume', 'description' => 'Current curriculum vitae or resume', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'doc', 'docx'], 'is_required' => true, 'is_active' => true],
            ['code' => 'WORK_HISTORY', 'name' => 'Work History Form', 'description' => 'Detailed work history form', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'doc', 'docx'], 'is_required' => false, 'is_active' => true],
            ['code' => 'PRIVILEGES', 'name' => 'Hospital Privileges', 'description' => 'Current hospital privileges documentation', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],

            // Background and Verification
            ['code' => 'BACKGROUND_CHECK', 'name' => 'Background Check', 'description' => 'Criminal background check results', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf'], 'is_required' => true, 'is_active' => true],
            ['code' => 'FINGERPRINTS', 'name' => 'Fingerprint Card', 'description' => 'Fingerprint card or results', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'OIG_CHECK', 'name' => 'OIG Exclusion Check', 'description' => 'OIG exclusion verification', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf'], 'is_required' => true, 'is_active' => true],
            ['code' => 'SAM_CHECK', 'name' => 'SAM Exclusion Check', 'description' => 'SAM exclusion verification', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf'], 'is_required' => true, 'is_active' => true],

            // Immunization Records
            ['code' => 'IMMUNIZATION', 'name' => 'Immunization Records', 'description' => 'Current immunization records', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => true, 'is_active' => true],
            ['code' => 'TB_TEST', 'name' => 'TB Test Results', 'description' => 'Tuberculosis test results', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => true, 'is_active' => true],
            ['code' => 'HEPATITIS_B', 'name' => 'Hepatitis B Vaccination', 'description' => 'Hepatitis B vaccination records', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => true, 'is_active' => true],
            ['code' => 'FLU_VACCINE', 'name' => 'Flu Vaccination', 'description' => 'Current flu vaccination record', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'COVID_VACCINE', 'name' => 'COVID-19 Vaccination', 'description' => 'COVID-19 vaccination record', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],

            // Drug Testing
            ['code' => 'DRUG_TEST', 'name' => 'Drug Test Results', 'description' => 'Pre-employment drug test results', 'max_file_size_mb' => 5, 'allowed_extensions' => ['pdf'], 'is_required' => true, 'is_active' => true],

            // Facility Documents
            ['code' => 'FACILITY_LICENSE', 'name' => 'Facility License', 'description' => 'Healthcare facility license', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'CLIA_CERT', 'name' => 'CLIA Certificate', 'description' => 'Clinical Laboratory Improvement Amendments certificate', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'ACCREDITATION', 'name' => 'Accreditation Certificate', 'description' => 'Facility accreditation certificate', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],

            // Other Documents
            ['code' => 'PHOTO', 'name' => 'Professional Photo', 'description' => 'Professional headshot photo', 'max_file_size_mb' => 5, 'allowed_extensions' => ['jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
            ['code' => 'SIGNATURE', 'name' => 'Digital Signature', 'description' => 'Digital signature file', 'max_file_size_mb' => 2, 'allowed_extensions' => ['png', 'jpg', 'jpeg'], 'is_required' => false, 'is_active' => true],
            ['code' => 'OTHER', 'name' => 'Other Document', 'description' => 'Other supporting documentation', 'max_file_size_mb' => 10, 'allowed_extensions' => ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'], 'is_required' => false, 'is_active' => true],
        ];

        foreach ($documentTypes as $documentType) {
            DocumentType::updateOrCreate(
                ['code' => $documentType['code']],
                $documentType
            );
        }
    }
}
