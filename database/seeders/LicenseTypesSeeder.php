<?php

namespace Database\Seeders;

use App\Models\LicenseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LicenseTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $licenseTypes = [
            // Medical Licenses
            ['code' => 'MD', 'name' => 'Medical Doctor', 'description' => 'Doctor of Medicine License', 'issuing_authority' => 'State Medical Board', 'is_active' => true],
            ['code' => 'DO', 'name' => 'Doctor of Osteopathic Medicine', 'description' => 'Doctor of Osteopathic Medicine License', 'issuing_authority' => 'State Osteopathic Medical Board', 'is_active' => true],
            ['code' => 'DPM', 'name' => 'Doctor of Podiatric Medicine', 'description' => 'Doctor of Podiatric Medicine License', 'issuing_authority' => 'State Podiatric Medical Board', 'is_active' => true],
            ['code' => 'DDS', 'name' => 'Doctor of Dental Surgery', 'description' => 'Doctor of Dental Surgery License', 'issuing_authority' => 'State Dental Board', 'is_active' => true],
            ['code' => 'DMD', 'name' => 'Doctor of Dental Medicine', 'description' => 'Doctor of Dental Medicine License', 'issuing_authority' => 'State Dental Board', 'is_active' => true],
            ['code' => 'OD', 'name' => 'Doctor of Optometry', 'description' => 'Doctor of Optometry License', 'issuing_authority' => 'State Optometry Board', 'is_active' => true],
            ['code' => 'DC', 'name' => 'Doctor of Chiropractic', 'description' => 'Doctor of Chiropractic License', 'issuing_authority' => 'State Chiropractic Board', 'is_active' => true],
            ['code' => 'DVM', 'name' => 'Doctor of Veterinary Medicine', 'description' => 'Doctor of Veterinary Medicine License', 'issuing_authority' => 'State Veterinary Medical Board', 'is_active' => true],
            ['code' => 'PharmD', 'name' => 'Doctor of Pharmacy', 'description' => 'Doctor of Pharmacy License', 'issuing_authority' => 'State Board of Pharmacy', 'is_active' => true],
            ['code' => 'PhD', 'name' => 'Doctor of Philosophy', 'description' => 'Doctor of Philosophy License', 'issuing_authority' => 'Educational Institution', 'is_active' => true],

            // Nursing Licenses
            ['code' => 'RN', 'name' => 'Registered Nurse', 'description' => 'Registered Nurse License', 'issuing_authority' => 'State Board of Nursing', 'is_active' => true],
            ['code' => 'LPN', 'name' => 'Licensed Practical Nurse', 'description' => 'Licensed Practical Nurse License', 'issuing_authority' => 'State Board of Nursing', 'is_active' => true],
            ['code' => 'LVN', 'name' => 'Licensed Vocational Nurse', 'description' => 'Licensed Vocational Nurse License', 'issuing_authority' => 'State Board of Nursing', 'is_active' => true],
            ['code' => 'APRN', 'name' => 'Advanced Practice Registered Nurse', 'description' => 'Advanced Practice Registered Nurse License', 'issuing_authority' => 'State Board of Nursing', 'is_active' => true],
            ['code' => 'NP', 'name' => 'Nurse Practitioner', 'description' => 'Nurse Practitioner License', 'issuing_authority' => 'State Board of Nursing', 'is_active' => true],
            ['code' => 'CNM', 'name' => 'Certified Nurse Midwife', 'description' => 'Certified Nurse Midwife License', 'issuing_authority' => 'State Board of Nursing', 'is_active' => true],
            ['code' => 'CRNA', 'name' => 'Certified Registered Nurse Anesthetist', 'description' => 'Certified Registered Nurse Anesthetist License', 'issuing_authority' => 'State Board of Nursing', 'is_active' => true],
            ['code' => 'CNS', 'name' => 'Clinical Nurse Specialist', 'description' => 'Clinical Nurse Specialist License', 'issuing_authority' => 'State Board of Nursing', 'is_active' => true],

            // Allied Health Licenses
            ['code' => 'PA', 'name' => 'Physician Assistant', 'description' => 'Physician Assistant License', 'issuing_authority' => 'State Medical Board', 'is_active' => true],
            ['code' => 'PT', 'name' => 'Physical Therapist', 'description' => 'Physical Therapist License', 'issuing_authority' => 'State Physical Therapy Board', 'is_active' => true],
            ['code' => 'OT', 'name' => 'Occupational Therapist', 'description' => 'Occupational Therapist License', 'issuing_authority' => 'State Occupational Therapy Board', 'is_active' => true],
            ['code' => 'SLP', 'name' => 'Speech-Language Pathologist', 'description' => 'Speech-Language Pathologist License', 'issuing_authority' => 'State Speech-Language Pathology Board', 'is_active' => true],
            ['code' => 'RT', 'name' => 'Respiratory Therapist', 'description' => 'Respiratory Therapist License', 'issuing_authority' => 'State Respiratory Care Board', 'is_active' => true],
            ['code' => 'MT', 'name' => 'Medical Technologist', 'description' => 'Medical Technologist License', 'issuing_authority' => 'State Medical Technology Board', 'is_active' => true],
            ['code' => 'MLT', 'name' => 'Medical Laboratory Technician', 'description' => 'Medical Laboratory Technician License', 'issuing_authority' => 'State Medical Technology Board', 'is_active' => true],
            ['code' => 'RAD_TECH', 'name' => 'Radiologic Technologist', 'description' => 'Radiologic Technologist License', 'issuing_authority' => 'State Radiologic Technology Board', 'is_active' => true],
            ['code' => 'CT_TECH', 'name' => 'CT Technologist', 'description' => 'CT Technologist License', 'issuing_authority' => 'State Radiologic Technology Board', 'is_active' => true],
            ['code' => 'MRI_TECH', 'name' => 'MRI Technologist', 'description' => 'MRI Technologist License', 'issuing_authority' => 'State Radiologic Technology Board', 'is_active' => true],
            ['code' => 'ULTRASOUND', 'name' => 'Ultrasound Technologist', 'description' => 'Ultrasound Technologist License', 'issuing_authority' => 'State Radiologic Technology Board', 'is_active' => true],
            ['code' => 'NUCLEAR_TECH', 'name' => 'Nuclear Medicine Technologist', 'description' => 'Nuclear Medicine Technologist License', 'issuing_authority' => 'State Radiologic Technology Board', 'is_active' => true],

            // Mental Health Licenses
            ['code' => 'LCSW', 'name' => 'Licensed Clinical Social Worker', 'description' => 'Licensed Clinical Social Worker License', 'issuing_authority' => 'State Social Work Board', 'is_active' => true],
            ['code' => 'LMSW', 'name' => 'Licensed Master Social Worker', 'description' => 'Licensed Master Social Worker License', 'issuing_authority' => 'State Social Work Board', 'is_active' => true],
            ['code' => 'LPC', 'name' => 'Licensed Professional Counselor', 'description' => 'Licensed Professional Counselor License', 'issuing_authority' => 'State Professional Counselor Board', 'is_active' => true],
            ['code' => 'LMFT', 'name' => 'Licensed Marriage and Family Therapist', 'description' => 'Licensed Marriage and Family Therapist License', 'issuing_authority' => 'State Marriage and Family Therapy Board', 'is_active' => true],
            ['code' => 'LPCC', 'name' => 'Licensed Professional Clinical Counselor', 'description' => 'Licensed Professional Clinical Counselor License', 'issuing_authority' => 'State Professional Counselor Board', 'is_active' => true],
            ['code' => 'LADC', 'name' => 'Licensed Alcohol and Drug Counselor', 'description' => 'Licensed Alcohol and Drug Counselor License', 'issuing_authority' => 'State Alcohol and Drug Counselor Board', 'is_active' => true],

            // Pharmacy Licenses
            ['code' => 'RPH', 'name' => 'Registered Pharmacist', 'description' => 'Registered Pharmacist License', 'issuing_authority' => 'State Board of Pharmacy', 'is_active' => true],
            ['code' => 'CPhT', 'name' => 'Certified Pharmacy Technician', 'description' => 'Certified Pharmacy Technician License', 'issuing_authority' => 'State Board of Pharmacy', 'is_active' => true],

            // Emergency Medical Services
            ['code' => 'EMT', 'name' => 'Emergency Medical Technician', 'description' => 'Emergency Medical Technician License', 'issuing_authority' => 'State Emergency Medical Services Board', 'is_active' => true],
            ['code' => 'PARAMEDIC', 'name' => 'Paramedic', 'description' => 'Paramedic License', 'issuing_authority' => 'State Emergency Medical Services Board', 'is_active' => true],
            ['code' => 'AEMT', 'name' => 'Advanced Emergency Medical Technician', 'description' => 'Advanced Emergency Medical Technician License', 'issuing_authority' => 'State Emergency Medical Services Board', 'is_active' => true],

            // Dietitian and Nutrition
            ['code' => 'RD', 'name' => 'Registered Dietitian', 'description' => 'Registered Dietitian License', 'issuing_authority' => 'State Dietitian Board', 'is_active' => true],
            ['code' => 'LDN', 'name' => 'Licensed Dietitian Nutritionist', 'description' => 'Licensed Dietitian Nutritionist License', 'issuing_authority' => 'State Dietitian Board', 'is_active' => true],

            // Other Healthcare Licenses
            ['code' => 'AUD', 'name' => 'Audiologist', 'description' => 'Audiologist License', 'issuing_authority' => 'State Audiology Board', 'is_active' => true],
            ['code' => 'PSYCH', 'name' => 'Psychologist', 'description' => 'Psychologist License', 'issuing_authority' => 'State Psychology Board', 'is_active' => true],
            ['code' => 'PSYCH_ASSOC', 'name' => 'Psychological Associate', 'description' => 'Psychological Associate License', 'issuing_authority' => 'State Psychology Board', 'is_active' => true],
            ['code' => 'MFT', 'name' => 'Marriage and Family Therapist', 'description' => 'Marriage and Family Therapist License', 'issuing_authority' => 'State Marriage and Family Therapy Board', 'is_active' => true],
            ['code' => 'ACUPUNCTURE', 'name' => 'Acupuncturist', 'description' => 'Acupuncturist License', 'issuing_authority' => 'State Acupuncture Board', 'is_active' => true],
            ['code' => 'MASSAGE', 'name' => 'Massage Therapist', 'description' => 'Massage Therapist License', 'issuing_authority' => 'State Massage Therapy Board', 'is_active' => true],
            ['code' => 'HOMEOPATH', 'name' => 'Homeopath', 'description' => 'Homeopath License', 'issuing_authority' => 'State Homeopathic Board', 'is_active' => true],
            ['code' => 'NATUROPATH', 'name' => 'Naturopathic Doctor', 'description' => 'Naturopathic Doctor License', 'issuing_authority' => 'State Naturopathic Board', 'is_active' => true],

            // Facility Licenses
            ['code' => 'FACILITY', 'name' => 'Healthcare Facility License', 'description' => 'Healthcare Facility License', 'issuing_authority' => 'State Health Department', 'is_active' => true],
            ['code' => 'CLINIC', 'name' => 'Medical Clinic License', 'description' => 'Medical Clinic License', 'issuing_authority' => 'State Health Department', 'is_active' => true],
            ['code' => 'LAB', 'name' => 'Clinical Laboratory License', 'description' => 'Clinical Laboratory License', 'issuing_authority' => 'State Health Department', 'is_active' => true],
            ['code' => 'PHARMACY', 'name' => 'Pharmacy License', 'description' => 'Pharmacy License', 'issuing_authority' => 'State Board of Pharmacy', 'is_active' => true],
            ['code' => 'AMBULATORY', 'name' => 'Ambulatory Surgery Center License', 'description' => 'Ambulatory Surgery Center License', 'issuing_authority' => 'State Health Department', 'is_active' => true],
            ['code' => 'HOSPICE', 'name' => 'Hospice License', 'description' => 'Hospice License', 'issuing_authority' => 'State Health Department', 'is_active' => true],
            ['code' => 'HOME_HEALTH', 'name' => 'Home Health Agency License', 'description' => 'Home Health Agency License', 'issuing_authority' => 'State Health Department', 'is_active' => true],
            ['code' => 'NURSING_HOME', 'name' => 'Nursing Home License', 'description' => 'Nursing Home License', 'issuing_authority' => 'State Health Department', 'is_active' => true],
            ['code' => 'ASSISTED_LIVING', 'name' => 'Assisted Living Facility License', 'description' => 'Assisted Living Facility License', 'issuing_authority' => 'State Health Department', 'is_active' => true],
        ];

        foreach ($licenseTypes as $licenseType) {
            LicenseType::updateOrCreate(
                ['code' => $licenseType['code']],
                $licenseType
            );
        }
    }
}
