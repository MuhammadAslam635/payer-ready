<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = [
            // Primary Care
            ['code' => 'FAM', 'name' => 'Family Medicine', 'taxonomy_code' => '207Q00000X', 'description' => 'Family Medicine Physician', 'is_active' => true],
            ['code' => 'INT', 'name' => 'Internal Medicine', 'taxonomy_code' => '207R00000X', 'description' => 'Internal Medicine Physician', 'is_active' => true],
            ['code' => 'PED', 'name' => 'Pediatrics', 'taxonomy_code' => '208000000X', 'description' => 'Pediatrics Physician', 'is_active' => true],
            ['code' => 'OBG', 'name' => 'Obstetrics and Gynecology', 'taxonomy_code' => '207V00000X', 'description' => 'Obstetrics & Gynecology Physician', 'is_active' => true],
            ['code' => 'GER', 'name' => 'Geriatric Medicine', 'taxonomy_code' => '207QG0300X', 'description' => 'Family Medicine - Geriatric Medicine', 'is_active' => true],

            // Emergency Medicine
            ['code' => 'EM', 'name' => 'Emergency Medicine', 'taxonomy_code' => '207P00000X', 'description' => 'Emergency Medicine Physician', 'is_active' => true],
            ['code' => 'PEM', 'name' => 'Pediatric Emergency Medicine', 'taxonomy_code' => '2080P0204X', 'description' => 'Pediatrics - Pediatric Emergency Medicine', 'is_active' => true],

            // Surgery
            ['code' => 'GS', 'name' => 'General Surgery', 'taxonomy_code' => '208600000X', 'description' => 'Surgery Physician', 'is_active' => true],
            ['code' => 'CTS', 'name' => 'Cardiothoracic Surgery', 'taxonomy_code' => '208G00000X', 'description' => 'Thoracic Surgery (Cardiothoracic Vascular Surgery)', 'is_active' => true],
            ['code' => 'NS', 'name' => 'Neurosurgery', 'taxonomy_code' => '207T00000X', 'description' => 'Neurological Surgery Physician', 'is_active' => true],
            ['code' => 'ORS', 'name' => 'Orthopedic Surgery', 'taxonomy_code' => '207X00000X', 'description' => 'Orthopaedic Surgery Physician', 'is_active' => true],
            ['code' => 'PS', 'name' => 'Plastic Surgery', 'taxonomy_code' => '2086S0122X', 'description' => 'Surgery - Plastic and Reconstructive Surgery', 'is_active' => true],
            ['code' => 'VS', 'name' => 'Vascular Surgery', 'taxonomy_code' => '2086S0129X', 'description' => 'Surgery - Vascular Surgery', 'is_active' => true],
            ['code' => 'URO', 'name' => 'Urology', 'taxonomy_code' => '208800000X', 'description' => 'Urology Physician', 'is_active' => true],

            // Cardiology
            ['code' => 'CARD', 'name' => 'Cardiology', 'taxonomy_code' => '207RC0000X', 'description' => 'Internal Medicine - Cardiovascular Disease', 'is_active' => true],
            ['code' => 'IC', 'name' => 'Interventional Cardiology', 'taxonomy_code' => '207RI0001X', 'description' => 'Internal Medicine - Interventional Cardiology', 'is_active' => true],
            ['code' => 'EP', 'name' => 'Electrophysiology', 'taxonomy_code' => '207RI0008X', 'description' => 'Internal Medicine - Clinical Cardiac Electrophysiology', 'is_active' => true],

            // Neurology
            ['code' => 'NEURO', 'name' => 'Neurology', 'taxonomy_code' => '2084N0400X', 'description' => 'Psychiatry & Neurology - Neurology', 'is_active' => true],
            ['code' => 'CHILD_NEURO', 'name' => 'Child Neurology', 'taxonomy_code' => '2084N0402X', 'description' => 'Psychiatry & Neurology - Child & Adolescent Psychiatry', 'is_active' => true],

            // Psychiatry
            ['code' => 'PSYCH', 'name' => 'Psychiatry', 'taxonomy_code' => '2084P0800X', 'description' => 'Psychiatry & Neurology - Psychiatry', 'is_active' => true],
            ['code' => 'CHILD_PSYCH', 'name' => 'Child Psychiatry', 'taxonomy_code' => '2084P0804X', 'description' => 'Psychiatry & Neurology - Child & Adolescent Psychiatry', 'is_active' => true],
            ['code' => 'ADDICT', 'name' => 'Addiction Medicine', 'taxonomy_code' => '207QA0401X', 'description' => 'Family Medicine - Addiction Medicine', 'is_active' => true],

            // Dermatology
            ['code' => 'DERM', 'name' => 'Dermatology', 'taxonomy_code' => '207N00000X', 'description' => 'Dermatology Physician', 'is_active' => true],
            ['code' => 'DERM_PATH', 'name' => 'Dermatopathology', 'taxonomy_code' => '207ND0900X', 'description' => 'Dermatology - Dermatopathology', 'is_active' => true],

            // Ophthalmology
            ['code' => 'OPHTH', 'name' => 'Ophthalmology', 'taxonomy_code' => '207W00000X', 'description' => 'Ophthalmology Physician', 'is_active' => true],
            ['code' => 'RETINA', 'name' => 'Retina Specialist', 'taxonomy_code' => '207WX0200X', 'description' => 'Ophthalmology - Retina Specialist', 'is_active' => true],

            // ENT
            ['code' => 'ENT', 'name' => 'Otolaryngology', 'taxonomy_code' => '207Y00000X', 'description' => 'Otolaryngology Physician', 'is_active' => true],
            ['code' => 'HEAD_NECK', 'name' => 'Head and Neck Surgery', 'taxonomy_code' => '207YX0007X', 'description' => 'Otolaryngology - Head and Neck Surgery', 'is_active' => true],

            // Radiology
            ['code' => 'RAD', 'name' => 'Radiology', 'taxonomy_code' => '2085R0001X', 'description' => 'Radiology - Diagnostic Radiology', 'is_active' => true],
            ['code' => 'IR', 'name' => 'Interventional Radiology', 'taxonomy_code' => '2085R0204X', 'description' => 'Radiology - Vascular & Interventional Radiology', 'is_active' => true],
            ['code' => 'NUC_MED', 'name' => 'Nuclear Medicine', 'taxonomy_code' => '207UN0901X', 'description' => 'Nuclear Medicine - Nuclear Imaging & Therapy', 'is_active' => true],

            // Pathology
            ['code' => 'PATH', 'name' => 'Pathology', 'taxonomy_code' => '207ZP0102X', 'description' => 'Pathology - Anatomic Pathology & Clinical Pathology', 'is_active' => true],
            ['code' => 'FORENSIC', 'name' => 'Forensic Pathology', 'taxonomy_code' => '207ZF0201X', 'description' => 'Pathology - Forensic Pathology', 'is_active' => true],

            // Anesthesiology
            ['code' => 'ANES', 'name' => 'Anesthesiology', 'taxonomy_code' => '207L00000X', 'description' => 'Anesthesiology Physician', 'is_active' => true],
            ['code' => 'PAIN', 'name' => 'Pain Medicine', 'taxonomy_code' => '207LP2900X', 'description' => 'Anesthesiology - Pain Medicine', 'is_active' => true],

            // Physical Medicine
            ['code' => 'PMR', 'name' => 'Physical Medicine & Rehabilitation', 'taxonomy_code' => '208100000X', 'description' => 'Physical Medicine & Rehabilitation Physician', 'is_active' => true],
            ['code' => 'SPORTS', 'name' => 'Sports Medicine', 'taxonomy_code' => '207QS0010X', 'description' => 'Family Medicine - Sports Medicine', 'is_active' => true],

            // Oncology
            ['code' => 'ONC', 'name' => 'Medical Oncology', 'taxonomy_code' => '207RX0202X', 'description' => 'Internal Medicine - Medical Oncology', 'is_active' => true],
            ['code' => 'HEME', 'name' => 'Hematology', 'taxonomy_code' => '207RH0003X', 'description' => 'Internal Medicine - Hematology', 'is_active' => true],
            ['code' => 'RAD_ONC', 'name' => 'Radiation Oncology', 'taxonomy_code' => '2085R0001X', 'description' => 'Radiology - Radiation Oncology', 'is_active' => true],

            // Gastroenterology
            ['code' => 'GI', 'name' => 'Gastroenterology', 'taxonomy_code' => '207RG0100X', 'description' => 'Internal Medicine - Gastroenterology', 'is_active' => true],
            ['code' => 'HEP', 'name' => 'Hepatology', 'taxonomy_code' => '207RI0008X', 'description' => 'Internal Medicine - Hepatology', 'is_active' => true],

            // Nephrology
            ['code' => 'NEPH', 'name' => 'Nephrology', 'taxonomy_code' => '207RN0300X', 'description' => 'Internal Medicine - Nephrology', 'is_active' => true],

            // Endocrinology
            ['code' => 'ENDO', 'name' => 'Endocrinology', 'taxonomy_code' => '207RE0101X', 'description' => 'Internal Medicine - Endocrinology, Diabetes & Metabolism', 'is_active' => true],

            // Rheumatology
            ['code' => 'RHEUM', 'name' => 'Rheumatology', 'taxonomy_code' => '207RR0500X', 'description' => 'Internal Medicine - Rheumatology', 'is_active' => true],

            // Pulmonology
            ['code' => 'PULM', 'name' => 'Pulmonology', 'taxonomy_code' => '207RP1001X', 'description' => 'Internal Medicine - Pulmonary Disease', 'is_active' => true],
            ['code' => 'SLEEP', 'name' => 'Sleep Medicine', 'taxonomy_code' => '207RS0012X', 'description' => 'Internal Medicine - Sleep Medicine', 'is_active' => true],

            // Infectious Disease
            ['code' => 'ID', 'name' => 'Infectious Disease', 'taxonomy_code' => '207RI0200X', 'description' => 'Internal Medicine - Infectious Disease', 'is_active' => true],

            // Allergy & Immunology
            ['code' => 'ALLERGY', 'name' => 'Allergy & Immunology', 'taxonomy_code' => '207K00000X', 'description' => 'Allergy & Immunology Physician', 'is_active' => true],

            // Critical Care
            ['code' => 'CCM', 'name' => 'Critical Care Medicine', 'taxonomy_code' => '207RC0200X', 'description' => 'Internal Medicine - Critical Care Medicine', 'is_active' => true],

            // Hospitalist
            ['code' => 'HOSP', 'name' => 'Hospitalist', 'taxonomy_code' => '207RH0003X', 'description' => 'Internal Medicine - Hospitalist', 'is_active' => true],

            // Preventive Medicine
            ['code' => 'PREV', 'name' => 'Preventive Medicine', 'taxonomy_code' => '2083P0901X', 'description' => 'Preventive Medicine - Public Health & General Preventive Medicine', 'is_active' => true],

            // Occupational Medicine
            ['code' => 'OCC', 'name' => 'Occupational Medicine', 'taxonomy_code' => '2083X0100X', 'description' => 'Preventive Medicine - Occupational Medicine', 'is_active' => true],

            // Other Specialties
            ['code' => 'GENETICS', 'name' => 'Medical Genetics', 'taxonomy_code' => '207SG0201X', 'description' => 'Medical Genetics - Clinical Genetics (M.D.)', 'is_active' => true],
            ['code' => 'NUCLEAR', 'name' => 'Nuclear Medicine', 'taxonomy_code' => '207UN0901X', 'description' => 'Nuclear Medicine - Nuclear Imaging & Therapy', 'is_active' => true],
            ['code' => 'RADIOLOGY', 'name' => 'Diagnostic Radiology', 'taxonomy_code' => '2085R0202X', 'description' => 'Radiology - Diagnostic Radiology', 'is_active' => true],
        ];

        foreach ($specialties as $specialty) {
            Specialty::updateOrCreate(
                ['code' => $specialty['code']],
                $specialty
            );
        }
    }
}
