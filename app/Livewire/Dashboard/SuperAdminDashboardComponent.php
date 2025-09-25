<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Organization;
use App\Models\Clinic;
use App\Models\DoctorProfile;
use App\Enums\UserType;
use Illuminate\Support\Facades\DB;

#[Title('Super Admin Dashboard')]
#[Layout('layouts.dashboard')]
class SuperAdminDashboardComponent extends Component
{
    public function render()
    {
        // Get stats for the dashboard
        $stats = $this->getDashboardStats();

        return view('livewire.dashboard.super-admin-dashboard-component', [
            'stats' => $stats
        ]);
    }

    private function getDashboardStats()
    {
        // Total counts
        $totalOrganizations = Organization::count();
        $totalClinics = Clinic::count();
        $totalDoctors = User::where('user_type', UserType::DOCTOR)->count();
        $totalUsers = User::count();

        // Active counts
        $activeOrganizations = Organization::where('is_active', true)->count();
        $activeClinics = Clinic::where('is_active', true)->count();
        $activeDoctors = User::where('user_type', UserType::DOCTOR)
            ->where('is_active', true)
            ->count();

        // Recent activity (last 30 days)
        $recentOrganizations = Organization::where('created_at', '>=', now()->subDays(30))->count();
        $recentDoctors = User::where('user_type', UserType::DOCTOR)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // User type breakdown
        $userTypeStats = User::select('user_type', DB::raw('count(*) as count'))
            ->groupBy('user_type')
            ->pluck('count', 'user_type')
            ->toArray();

        // Monthly growth (last 6 months)
        $monthlyGrowth = $this->getMonthlyGrowth();

        // Latest transactions
        $latestTransactions = $this->getLatestTransactions();

        // Latest registered users
        $latestUsers = $this->getLatestUsers();

        // Latest certificate requests
        $latestCertificateRequests = $this->getLatestCertificateRequests();

        return [
            'totalOrganizations' => $totalOrganizations,
            'totalClinics' => $totalClinics,
            'totalDoctors' => $totalDoctors,
            'totalUsers' => $totalUsers,
            'activeOrganizations' => $activeOrganizations,
            'activeClinics' => $activeClinics,
            'activeDoctors' => $activeDoctors,
            'recentOrganizations' => $recentOrganizations,
            'recentDoctors' => $recentDoctors,
            'userTypeStats' => $userTypeStats,
            'monthlyGrowth' => $monthlyGrowth,
            'latestTransactions' => $latestTransactions,
            'latestUsers' => $latestUsers,
            'latestCertificateRequests' => $latestCertificateRequests,
        ];
    }

    private function getMonthlyGrowth()
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $months[] = [
                'month' => $date->format('M Y'),
                'organizations' => Organization::whereBetween('created_at', [$monthStart, $monthEnd])->count(),
                'doctors' => User::where('user_type', UserType::DOCTOR)
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->count(),
            ];
        }

        return $months;
    }

    private function getLatestTransactions()
    {
        // For now, return mock data since we don't have a transactions table yet
        // In a real application, you would query the actual transactions table
        return collect([
            [
                'id' => 1,
                'description' => 'Credentialing Service Fee',
                'amount' => 299.99,
                'status' => 'completed',
                'user_name' => 'Dr. John Smith',
                'created_at' => now()->subHours(2),
            ],
            [
                'id' => 2,
                'description' => 'License Verification',
                'amount' => 150.00,
                'status' => 'pending',
                'user_name' => 'Dr. Jane Doe',
                'created_at' => now()->subHours(5),
            ],
            [
                'id' => 3,
                'description' => 'Background Check',
                'amount' => 89.99,
                'status' => 'completed',
                'user_name' => 'Dr. Mike Johnson',
                'created_at' => now()->subDays(1),
            ],
        ])->take(5);
    }

    private function getLatestUsers()
    {
        return User::with(['organization'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_type' => $user->user_type->value,
                    'is_active' => $user->is_active,
                    'profile_photo_url' => $user->profile_photo_url,
                    'created_at' => $user->created_at,
                    'organization_name' => $user->organization->first()?->business_name,
                ];
            });
    }

    private function getLatestCertificateRequests()
    {
        // For now, return mock data since we don't have a certificate requests table yet
        // In a real application, you would query the actual certificate requests table
        return collect([
            [
                'id' => 1,
                'certificate_type' => 'Medical License',
                'status' => 'pending',
                'organization_name' => 'City Medical Center',
                'doctor' => [
                    'name' => 'Dr. Sarah Wilson',
                    'email' => 'sarah.wilson@example.com',
                    'profile_photo_url' => 'https://ui-avatars.com/api/?name=Sarah+Wilson&background=random',
                ],
                'created_at' => now()->subHours(1),
            ],
            [
                'id' => 2,
                'certificate_type' => 'DEA License',
                'status' => 'approved',
                'organization_name' => 'Regional Hospital',
                'doctor' => [
                    'name' => 'Dr. Robert Brown',
                    'email' => 'robert.brown@example.com',
                    'profile_photo_url' => 'https://ui-avatars.com/api/?name=Robert+Brown&background=random',
                ],
                'created_at' => now()->subHours(3),
            ],
            [
                'id' => 3,
                'certificate_type' => 'Board Certification',
                'status' => 'pending',
                'organization_name' => 'University Medical',
                'doctor' => [
                    'name' => 'Dr. Emily Davis',
                    'email' => 'emily.davis@example.com',
                    'profile_photo_url' => 'https://ui-avatars.com/api/?name=Emily+Davis&background=random',
                ],
                'created_at' => now()->subDays(1),
            ],
        ])->take(5);
    }
}
