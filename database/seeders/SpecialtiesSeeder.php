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
            ['code' => 'FAM', 'name' => 'Family Medicine', 'description' => 'Family Medicine Physician', 'is_active' => true],
            ['code' => 'INT', 'name' => 'Internal Medicine', 'description' => 'Internal Medicine Physician', 'is_active' => true],
            ['code' => 'PED', 'name' => 'Pediatrics', 'description' => 'Pediatrics Physician', 'is_active' => true],
            ['code' => 'OBG', 'name' => 'Obstetrics and Gynecology', 'description' => 'Obstetrics & Gynecology Physician', 'is_active' => true],
            ['code' => 'GER', 'name' => 'Geriatric Medicine', 'description' => 'Family Medicine - Geriatric Medicine', 'is_active' => true],

            // Emergency Medicine
            ['code' => 'EM', 'name' => 'Emergency Medicine', 'description' => 'Emergency Medicine Physician', 'is_active' => true],
            ['code' => 'PEM', 'name' => 'Pediatric Emergency Medicine', 'description' => 'Pediatrics - Pediatric Emergency Medicine', 'is_active' => true],

            // Surgery
            ['code' => 'GS', 'name' => 'General Surgery', 'description' => 'Surgery Physician', 'is_active' => true],
            ['code' => 'CTS', 'name' => 'Cardiothoracic Surgery', 'description' => 'Thoracic Surgery (Cardiothoracic Vascular Surgery)', 'is_active' => true],
            ['code' => 'NS', 'name' => 'Neurosurgery', 'description' => 'Neurological Surgery Physician', 'is_active' => true],
            ['code' => 'ORS', 'name' => 'Orthopedic Surgery', 'description' => 'Orthopaedic Surgery Physician', 'is_active' => true],
            ['code' => 'PS', 'name' => 'Plastic Surgery', 'description' => 'Surgery - Plastic and Reconstructive Surgery', 'is_active' => true],
            ['code' => 'VS', 'name' => 'Vascular Surgery', 'description' => 'Surgery - Vascular Surgery', 'is_active' => true],
            ['code' => 'URO', 'name' => 'Urology', 'description' => 'Urology Physician', 'is_active' => true],

            // Cardiology
            ['code' => 'CARD', 'name' => 'Cardiology', 'description' => 'Internal Medicine - Cardiovascular Disease', 'is_active' => true],
            ['code' => 'IC', 'name' => 'Interventional Cardiology', 'description' => 'Internal Medicine - Interventional Cardiology', 'is_active' => true],
            ['code' => 'EP', 'name' => 'Electrophysiology', 'description' => 'Internal Medicine - Clinical Cardiac Electrophysiology', 'is_active' => true],

            // Neurology
            ['code' => 'NEURO', 'name' => 'Neurology', 'description' => 'Psychiatry & Neurology - Neurology', 'is_active' => true],
            ['code' => 'CHILD_NEURO', 'name' => 'Child Neurology', 'description' => 'Psychiatry & Neurology - Child & Adolescent Psychiatry', 'is_active' => true],

            // Psychiatry
            ['code' => 'PSYCH', 'name' => 'Psychiatry', 'description' => 'Psychiatry & Neurology - Psychiatry', 'is_active' => true],
            ['code' => 'CHILD_PSYCH', 'name' => 'Child Psychiatry', 'description' => 'Psychiatry & Neurology - Child & Adolescent Psychiatry', 'is_active' => true],
            ['code' => 'ADDICT', 'name' => 'Addiction Medicine', 'description' => 'Family Medicine - Addiction Medicine', 'is_active' => true],

            // Dermatology
            ['code' => 'DERM', 'name' => 'Dermatology', 'description' => 'Dermatology Physician', 'is_active' => true],
            ['code' => 'DERM_PATH', 'name' => 'Dermatopathology', 'description' => 'Dermatology - Dermatopathology', 'is_active' => true],

            // Ophthalmology
            ['code' => 'OPHTH', 'name' => 'Ophthalmology', 'description' => 'Ophthalmology Physician', 'is_active' => true],
            ['code' => 'RETINA', 'name' => 'Retina Specialist', 'description' => 'Ophthalmology - Retina Specialist', 'is_active' => true],

            // ENT
            ['code' => 'ENT', 'name' => 'Otolaryngology', 'description' => 'Otolaryngology Physician', 'is_active' => true],
            ['code' => 'HEAD_NECK', 'name' => 'Head and Neck Surgery', 'description' => 'Otolaryngology - Head and Neck Surgery', 'is_active' => true],

            // Radiology
            ['code' => 'RAD', 'name' => 'Radiology', 'description' => 'Radiology - Diagnostic Radiology', 'is_active' => true],
            ['code' => 'IR', 'name' => 'Interventional Radiology', 'description' => 'Radiology - Vascular & Interventional Radiology', 'is_active' => true],
            ['code' => 'NUC_MED', 'name' => 'Nuclear Medicine', 'description' => 'Nuclear Medicine - Nuclear Imaging & Therapy', 'is_active' => true],

            // Pathology
            ['code' => 'PATH', 'name' => 'Pathology', 'description' => 'Pathology - Anatomic Pathology & Clinical Pathology', 'is_active' => true],
            ['code' => 'FORENSIC', 'name' => 'Forensic Pathology', 'description' => 'Pathology - Forensic Pathology', 'is_active' => true],

            // Anesthesiology
            ['code' => 'ANES', 'name' => 'Anesthesiology', 'description' => 'Anesthesiology Physician', 'is_active' => true],
            ['code' => 'PAIN', 'name' => 'Pain Medicine', 'description' => 'Anesthesiology - Pain Medicine', 'is_active' => true],

            // Physical Medicine
            ['code' => 'PMR', 'name' => 'Physical Medicine & Rehabilitation', 'description' => 'Physical Medicine & Rehabilitation Physician', 'is_active' => true],
            ['code' => 'SPORTS', 'name' => 'Sports Medicine', 'description' => 'Family Medicine - Sports Medicine', 'is_active' => true],

            // Oncology
            ['code' => 'ONC', 'name' => 'Medical Oncology', 'description' => 'Internal Medicine - Medical Oncology', 'is_active' => true],
            ['code' => 'HEME', 'name' => 'Hematology', 'description' => 'Internal Medicine - Hematology', 'is_active' => true],
            ['code' => 'RAD_ONC', 'name' => 'Radiation Oncology', 'description' => 'Radiology - Radiation Oncology', 'is_active' => true],

            // Gastroenterology
            ['code' => 'GI', 'name' => 'Gastroenterology', 'description' => 'Internal Medicine - Gastroenterology', 'is_active' => true],
            ['code' => 'HEP', 'name' => 'Hepatology', 'description' => 'Internal Medicine - Hepatology', 'is_active' => true],

            // Nephrology
            ['code' => 'NEPH', 'name' => 'Nephrology', 'description' => 'Internal Medicine - Nephrology', 'is_active' => true],

            // Endocrinology
            ['code' => 'ENDO', 'name' => 'Endocrinology', 'description' => 'Internal Medicine - Endocrinology, Diabetes & Metabolism', 'is_active' => true],

            // Rheumatology
            ['code' => 'RHEUM', 'name' => 'Rheumatology', 'description' => 'Internal Medicine - Rheumatology', 'is_active' => true],

            // Pulmonology
            ['code' => 'PULM', 'name' => 'Pulmonology', 'description' => 'Internal Medicine - Pulmonary Disease', 'is_active' => true],
            ['code' => 'SLEEP', 'name' => 'Sleep Medicine', 'description' => 'Internal Medicine - Sleep Medicine', 'is_active' => true],

            // Infectious Disease
            ['code' => 'ID', 'name' => 'Infectious Disease', 'description' => 'Internal Medicine - Infectious Disease', 'is_active' => true],

            // Allergy & Immunology
            ['code' => 'ALLERGY', 'name' => 'Allergy & Immunology', 'description' => 'Allergy & Immunology Physician', 'is_active' => true],

            // Critical Care
            ['code' => 'CCM', 'name' => 'Critical Care Medicine', 'description' => 'Internal Medicine - Critical Care Medicine', 'is_active' => true],

            // Hospitalist
            ['code' => 'HOSP', 'name' => 'Hospitalist', 'description' => 'Internal Medicine - Hospitalist', 'is_active' => true],

            // Preventive Medicine
            ['code' => 'PREV', 'name' => 'Preventive Medicine', 'description' => 'Preventive Medicine - Public Health & General Preventive Medicine', 'is_active' => true],

            // Occupational Medicine
            ['code' => 'OCC', 'name' => 'Occupational Medicine', 'description' => 'Preventive Medicine - Occupational Medicine', 'is_active' => true],

            // Other Specialties
            ['code' => 'GENETICS', 'name' => 'Medical Genetics', 'description' => 'Medical Genetics - Clinical Genetics (M.D.)', 'is_active' => true],
            ['code' => 'NUCLEAR', 'name' => 'Nuclear Medicine', 'description' => 'Nuclear Medicine - Nuclear Imaging & Therapy', 'is_active' => true],
            ['code' => 'RADIOLOGY', 'name' => 'Diagnostic Radiology', 'description' => 'Radiology - Diagnostic Radiology', 'is_active' => true],
        ];

        foreach ($specialties as $specialty) {
            Specialty::updateOrCreate(
                ['code' => $specialty['code']],
                $specialty
            );
        }
    }
}
