<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\DoctorProfile;
use App\Models\DoctorLicense;
use App\Models\DoctorDocument;
use App\Models\DoctorWorkHistory;
use App\Models\DoctorReference;
use App\Models\Clinic;
use App\Enums\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Title('Doctor Dashboard')]
#[Layout('layouts.dashboard')]
class DoctorDashboardComponent extends Component
{
    public function render()
    {
        // Get stats for the dashboard
        $stats = $this->getDashboardStats();

        return view('livewire.dashboard.doctor-dashboard-component', [
            'stats' => $stats
        ]);
    }

    private function getDashboardStats()
    {
        $user = Auth::user();
        $doctorProfile = $user->doctorProfile;

        if (!$doctorProfile) {
            return [
                'totalLicenses' => 0,
                'totalDocuments' => 0,
                'totalWorkHistory' => 0,
                'totalReferences' => 0,
                'activeLicenses' => 0,
                'verifiedDocuments' => 0,
                'latestLicenses' => collect(),
                'latestDocuments' => collect(),
                'latestWorkHistory' => collect(),
                'latestReferences' => collect(),
                'clinic' => null,
            ];
        }

        // Get doctor-specific counts
        $totalLicenses = DoctorLicense::where('doctor_profile_id', $doctorProfile->id)->count();
        $totalDocuments = DoctorDocument::where('doctor_profile_id', $doctorProfile->id)->count();
        $totalWorkHistory = DoctorWorkHistory::where('doctor_profile_id', $doctorProfile->id)->count();
        $totalReferences = DoctorReference::where('doctor_profile_id', $doctorProfile->id)->count();

        // Active/verified counts
        $activeLicenses = DoctorLicense::where('doctor_profile_id', $doctorProfile->id)
            ->where('expiration_date', '>', now())
            ->count();
        $verifiedDocuments = DoctorDocument::where('doctor_profile_id', $doctorProfile->id)
            ->where('is_verified', true)
            ->count();

        // Latest licenses
        $latestLicenses = DoctorLicense::with('state')
            ->where('doctor_profile_id', $doctorProfile->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($license) {
                return [
                    'id' => $license->id,
                    'license_number' => $license->license_number,
                    'state' => $license->state->name ?? 'Unknown',
                    'issue_date' => $license->issue_date,
                    'expiration_date' => $license->expiration_date,
                    'is_active' => $license->expiration_date > now(),
                    'created_at' => $license->created_at,
                ];
            });

        // Latest documents
        $latestDocuments = DoctorDocument::with('documentType')
            ->where('doctor_profile_id', $doctorProfile->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($document) {
                return [
                    'id' => $document->id,
                    'document_type' => $document->documentType->name ?? 'Unknown',
                    'original_filename' => $document->original_filename,
                    'is_verified' => $document->is_verified,
                    'upload_date' => $document->upload_date,
                    'created_at' => $document->created_at,
                ];
            });

        // Latest work history
        $latestWorkHistory = DoctorWorkHistory::where('doctor_profile_id', $doctorProfile->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($work) {
                return [
                    'id' => $work->id,
                    'organization_name' => $work->organization_name,
                    'position_title' => $work->position_title,
                    'start_date' => $work->start_date,
                    'end_date' => $work->end_date,
                    'is_current' => $work->is_current,
                    'created_at' => $work->created_at,
                ];
            });

        // Latest references
        $latestReferences = DoctorReference::where('doctor_profile_id', $doctorProfile->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($reference) {
                return [
                    'id' => $reference->id,
                    'reference_full_name' => $reference->reference_full_name,
                    'reference_title' => $reference->reference_title,
                    'phone' => $reference->phone,
                    'email' => $reference->email,
                    'status' => $reference->status,
                    'created_at' => $reference->created_at,
                ];
            });

        // Get clinic information
        $clinic = $user->clinic;

        return [
            'doctorProfile' => $doctorProfile,
            'clinic' => $clinic,
            'totalLicenses' => $totalLicenses,
            'totalDocuments' => $totalDocuments,
            'totalWorkHistory' => $totalWorkHistory,
            'totalReferences' => $totalReferences,
            'activeLicenses' => $activeLicenses,
            'verifiedDocuments' => $verifiedDocuments,
            'latestLicenses' => $latestLicenses,
            'latestDocuments' => $latestDocuments,
            'latestWorkHistory' => $latestWorkHistory,
            'latestReferences' => $latestReferences,
        ];
    }
}
