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

        // Get doctor-specific counts using user_id directly
        $totalLicenses = DoctorLicense::where('user_id', $user->id)->count();
        $totalDocuments = DoctorDocument::where('user_id', $user->id)->count();
        $totalWorkHistory = DoctorWorkHistory::where('user_id', $user->id)->count();
        $totalReferences = DoctorReference::where('user_id', $user->id)->count();

        // Active/verified counts
        $activeLicenses = DoctorLicense::where('user_id', $user->id)
            ->where('expiration_date', '>', now())
            ->count();
        $verifiedDocuments = DoctorDocument::where('user_id', $user->id)
            ->where('is_verified', true)
            ->count();

        // Latest licenses
        $latestLicenses = DoctorLicense::with('state')
            ->where('user_id', $user->id)
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
            ->where('user_id', $user->id)
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
        $latestWorkHistory = DoctorWorkHistory::where('user_id', $user->id)
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
        $latestReferences = DoctorReference::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($reference) {
                return [
                    'id' => $reference->id,
                    'reference_full_name' => $reference->reference_full_name,
                    'reference_title' => $reference->reference_title,
                    'reference_specialty' => $reference->reference_specialty,
                    'organization_name' => $reference->organization_name,
                    'phone' => $reference->phone,
                    'email' => $reference->email,
                    'relationship_type' => $reference->relationship_type,
                    'years_known' => $reference->years_known,
                    'status' => $reference->status,
                    'created_at' => $reference->created_at,
                ];
            });

        // All reference providers for the main table
        $allReferences = DoctorReference::where('user_id', $user->id)
            ->latest()
            ->get()
            ->map(function ($reference) {
                return [
                    'id' => $reference->id,
                    'reference_full_name' => $reference->reference_full_name,
                    'reference_title' => $reference->reference_title,
                    'reference_specialty' => $reference->reference_specialty,
                    'organization_name' => $reference->organization_name,
                    'phone' => $reference->phone,
                    'email' => $reference->email,
                    'relationship_type' => $reference->relationship_type,
                    'years_known' => $reference->years_known,
                    'status' => $reference->status,
                    'created_at' => $reference->created_at,
                ];
            });

        // Get clinic information
        // $clinic = $user->clinic; // Removed clinic reference

        return [
            'doctorProfile' => null, // No longer using doctor profile
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
            'allReferences' => $allReferences,
        ];
    }
}
