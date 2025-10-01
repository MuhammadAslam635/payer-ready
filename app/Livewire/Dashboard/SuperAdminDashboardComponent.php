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
use App\Models\DoctorCertificate;
use App\Models\Transaction;
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
        $totalOrganizations = User::where('user_type', UserType::ORGANIZATION_ADMIN)->count();
        $totalDoctors = User::where('user_type', UserType::DOCTOR)->count();
        $totalUsers = User::count();

        // Active counts
        $activeOrganizations = User::where('user_type',UserType::ORGANIZATION_ADMIN)->where('is_active', true)->count();
        $activeDoctors = User::where('user_type', UserType::DOCTOR)
            ->where('is_active', true)
            ->count();

        // Recent activity (last 30 days)
        $recentOrganizations = User::where('user_type',UserType::ORGANIZATION_ADMIN)->where('created_at', '>=', now()->subDays(30))->count();
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
            'totalClinics' => 0,
            'totalDoctors' => $totalDoctors,
            'totalUsers' => $totalUsers,
            'activeOrganizations' => $activeOrganizations,
            'activeClinics' => 0,
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
                'organizations' => User::where('user_type', UserType::ORGANIZATION_ADMIN)
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->count(),
                'doctors' => User::where('user_type', UserType::DOCTOR)
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->count(),
            ];
        }

        return $months;
    }

    private function getLatestTransactions()
    {
        return Transaction::latest()->take(5)->get();
    }

    private function getLatestUsers()
    {
        return User::with(['parentOrganization'])
            ->whereNot('user_type',UserType::SUPER_ADMIN)
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
                    'organization_name' => $user->is_org ? $user->business_name : $user->parentOrganization?->business_name,
                ];
            });
    }

    private function getLatestCertificateRequests()
    {
        return DoctorCertificate::latest()->take(5)->get();
    }
}
