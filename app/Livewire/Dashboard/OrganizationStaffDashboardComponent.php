<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Organization;
use App\Models\OrganizationStaff;
use App\Models\DoctorProfile;
use App\Enums\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Title('Organization Staff Dashboard')]
#[Layout('layouts.dashboard')]
class OrganizationStaffDashboardComponent extends Component
{
    public function render()
    {
        // Get stats for the dashboard
        $stats = $this->getDashboardStats();

        return view('livewire.dashboard.organization-staff-dashboard-component', [
            'stats' => $stats
        ]);
    }

    private function getDashboardStats()
    {
        $user = Auth::user();
        $organizationStaff = $user->organizationStaff()->with('organization')->first();

        if (!$organizationStaff) {
            return [
                'totalColleagues' => 0,
                'totalDoctors' => 0,
                'activeColleagues' => 0,
                'activeDoctors' => 0,
                'recentColleagues' => 0,
                'recentDoctors' => 0,
                'latestColleagues' => collect(),
                'latestDoctors' => collect(),
                'latestActivities' => collect(),
                'organization' => null,
            ];
        }

        $organization = $organizationStaff->organization;

        // Get organization staff counts (excluding current user)
        $totalColleagues = OrganizationStaff::where('organization_id', $organization->id)
            ->where('user_id', '!=', $user->id)
            ->count();
        $activeColleagues = OrganizationStaff::where('organization_id', $organization->id)
            ->where('user_id', '!=', $user->id)
            ->where('is_active', true)
            ->count();

        // Get doctors associated with this organization
        $organizationDoctorIds = OrganizationStaff::where('organization_id', $organization->id)
            ->whereHas('user', function($query) {
                $query->where('user_type', UserType::DOCTOR);
            })
            ->pluck('user_id');

        $totalDoctors = $organizationDoctorIds->count();
        $activeDoctors = User::whereIn('id', $organizationDoctorIds)
            ->where('is_active', true)
            ->count();

        // Recent activity (last 30 days)
        $recentColleagues = OrganizationStaff::where('organization_id', $organization->id)
            ->where('user_id', '!=', $user->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $recentDoctors = User::whereIn('id', $organizationDoctorIds)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Latest colleagues
        $latestColleagues = OrganizationStaff::with(['user', 'role'])
            ->where('organization_id', $organization->id)
            ->where('user_id', '!=', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($staff) {
                return [
                    'id' => $staff->id,
                    'name' => $staff->user->name,
                    'email' => $staff->user->email,
                    'role' => $staff->role->name ?? 'Staff',
                    'is_active' => $staff->is_active,
                    'profile_photo_url' => $staff->user->profile_photo_url,
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

        // Latest activities (mock data for now)
        $latestActivities = $this->getLatestActivities();

        return [
            'organization' => $organization,
            'userRole' => $organizationStaff->role->name ?? 'Staff',
            'totalColleagues' => $totalColleagues,
            'totalDoctors' => $totalDoctors,
            'activeColleagues' => $activeColleagues,
            'activeDoctors' => $activeDoctors,
            'recentColleagues' => $recentColleagues,
            'recentDoctors' => $recentDoctors,
            'latestColleagues' => $latestColleagues,
            'latestDoctors' => $latestDoctors,
            'latestActivities' => $latestActivities,
        ];
    }

    private function getLatestActivities()
    {
        // Mock data for organization activities
        return collect([
            [
                'id' => 1,
                'activity' => 'New staff member joined',
                'description' => 'Dr. Sarah Wilson joined the organization',
                'type' => 'staff_joined',
                'created_at' => now()->subHours(2),
            ],
            [
                'id' => 2,
                'activity' => 'License updated',
                'description' => 'Dr. John Smith updated their medical license',
                'type' => 'license_update',
                'created_at' => now()->subHours(5),
            ],
            [
                'id' => 3,
                'activity' => 'Document uploaded',
                'description' => 'Dr. Mike Johnson uploaded a new certificate',
                'type' => 'document_upload',
                'created_at' => now()->subDays(1),
            ],
            [
                'id' => 4,
                'activity' => 'Profile completed',
                'description' => 'Dr. Emily Davis completed their profile',
                'type' => 'profile_complete',
                'created_at' => now()->subDays(2),
            ],
        ])->take(5);
    }
}
