<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\DoctorCredential;
use App\Enums\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Title('Organization Manager Dashboard')]
#[Layout('layouts.dashboard')]
class OrganizationManagerDashboardComponent extends Component
{
    public function render()
    {
        // Get stats for the dashboard
        $stats = $this->getDashboardStats();

        return view('livewire.dashboard.organization-manager-dashboard-component', [
            'stats' => $stats
        ]);
    }

    private function getDashboardStats()
    {
        $user = Auth::user();

        // Check if user is an organization
        if (!$user->isOrganization()) {
            return [
                'totalStaff' => 0,
                'totalDoctors' => 0,
                'activeStaff' => 0,
                'activeDoctors' => 0,
                'recentStaff' => 0,
                'recentDoctors' => 0,
                'latestStaff' => collect(),
                'latestDoctors' => collect(),
                'latestApplications' => collect(),
            ];
        }

        // Get organization staff counts (users who belong to this organization)
        $totalStaff = User::where('org_id', $user->id)->count();
        $activeStaff = User::where('org_id', $user->id)
            ->where('is_active', true)
            ->count();

        // Get doctors associated with this organization
        $organizationDoctorIds = User::where('org_id', $user->id)
            ->where('user_type', UserType::DOCTOR)
            ->pluck('id');

        $totalDoctors = $organizationDoctorIds->count();
        $activeDoctors = User::whereIn('id', $organizationDoctorIds)
            ->where('is_active', true)
            ->count();

        // Recent activity (last 30 days)
        $recentStaff = User::where('org_id', $user->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $recentDoctors = User::whereIn('id', $organizationDoctorIds)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Latest staff members
        $latestStaff = User::where('org_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($staff) {
                return [
                    'id' => $staff->id,
                    'name' => $staff->name,
                    'email' => $staff->email,
                    'role' => 'Staff', // Default role since we removed OrganizationStaff
                    'is_active' => $staff->is_active ?? true,
                    'profile_photo_url' => $staff->profile_photo_url,
                    'created_at' => $staff->created_at,
                ];
            });

        // Latest doctors
        $latestDoctors = User::with(['doctorProfile', 'specialties'])
            ->whereIn('id', $organizationDoctorIds)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'name' => $doctor->name,
                    'email' => $doctor->email,
                    'specialty' => $doctor->specialties->first()?->name ?? 'General',
                    'is_active' => $doctor->is_active,
                    'profile_photo_url' => $doctor->profile_photo_url,
                    'created_at' => $doctor->created_at,
                ];
            });

        // Latest applications (payer enrollments)
        $latestApplications = $this->getLatestApplications();

        return [
            'organization' => $user, // The user is now the organization
            'totalStaff' => $totalStaff,
            'totalDoctors' => $totalDoctors,
            'activeStaff' => $activeStaff,
            'activeDoctors' => $activeDoctors,
            'recentStaff' => $recentStaff,
            'recentDoctors' => $recentDoctors,
            'latestStaff' => $latestStaff,
            'latestDoctors' => $latestDoctors,
            'latestApplications' => $latestApplications,
        ];
    }

    private function getLatestApplications()
    {
        $user = Auth::user();
        
        // Get doctors associated with this organization
        $organizationDoctorIds = User::where('org_id', $user->id)
            ->where('user_type', UserType::DOCTOR)
            ->pluck('id');

        if ($organizationDoctorIds->isEmpty()) {
            return collect();
        }

        return DoctorCredential::with(['payer', 'state', 'user'])
            ->whereIn('user_id', $organizationDoctorIds)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($credential) {
                return [
                    'id' => $credential->id,
                    'payer_name' => $credential->payer?->name ?? 'N/A',
                    'provider_name' => $credential->user?->name ?? 'N/A',
                    'state_name' => $credential->state?->name ?? 'N/A',
                    'request_type' => $credential->request_type ?? 'N/A',
                    'status' => $credential->status ?? 'N/A',
                    'created_at' => $credential->created_at,
                ];
            });
    }
}
