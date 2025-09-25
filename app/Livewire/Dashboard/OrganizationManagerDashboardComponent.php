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
        $organization = $user->organization()->first();

        if (!$organization) {
            return [
                'totalStaff' => 0,
                'totalDoctors' => 0,
                'activeStaff' => 0,
                'activeDoctors' => 0,
                'recentStaff' => 0,
                'recentDoctors' => 0,
                'latestStaff' => collect(),
                'latestDoctors' => collect(),
                'latestTransactions' => collect(),
            ];
        }

        // Get organization staff counts
        $totalStaff = OrganizationStaff::where('organization_id', $organization->id)->count();
        $activeStaff = OrganizationStaff::where('organization_id', $organization->id)
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
        $recentStaff = OrganizationStaff::where('organization_id', $organization->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $recentDoctors = User::whereIn('id', $organizationDoctorIds)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Latest staff members
        $latestStaff = OrganizationStaff::with(['user', 'role'])
            ->where('organization_id', $organization->id)
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

        // Latest transactions (mock data for now)
        $latestTransactions = $this->getLatestTransactions();

        return [
            'organization' => $organization,
            'totalStaff' => $totalStaff,
            'totalDoctors' => $totalDoctors,
            'activeStaff' => $activeStaff,
            'activeDoctors' => $activeDoctors,
            'recentStaff' => $recentStaff,
            'recentDoctors' => $recentDoctors,
            'latestStaff' => $latestStaff,
            'latestDoctors' => $latestDoctors,
            'latestTransactions' => $latestTransactions,
        ];
    }

    private function getLatestTransactions()
    {
        // Mock data for organization transactions
        return collect([
            [
                'id' => 1,
                'description' => 'Staff Credentialing Fee',
                'amount' => 199.99,
                'status' => 'completed',
                'staff_name' => 'Dr. John Smith',
                'created_at' => now()->subHours(2),
            ],
            [
                'id' => 2,
                'description' => 'License Verification',
                'amount' => 150.00,
                'status' => 'pending',
                'staff_name' => 'Dr. Jane Doe',
                'created_at' => now()->subHours(5),
            ],
            [
                'id' => 3,
                'description' => 'Background Check',
                'amount' => 89.99,
                'status' => 'completed',
                'staff_name' => 'Dr. Mike Johnson',
                'created_at' => now()->subDays(1),
            ],
        ])->take(5);
    }
}
