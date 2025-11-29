<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\DoctorCredential;
use App\Models\DoctorLicense;
use App\Models\OrganizationLicense;
use App\Models\OrganizationCertificate;
use App\Enums\UserType;
use App\Enums\CredentialStatus;
use App\Enums\LicenseStatus;
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
            return $this->getEmptyStats();
        }

        // Get doctors associated with this organization
        $organizationDoctorIds = User::where('org_id', $user->id)
            ->where('user_type', UserType::DOCTOR)
            ->pluck('id');

        // Metrics Cards
        $metrics = $this->getMetrics($organizationDoctorIds, $user->id);
        
        // Attention List (Expiring/Missing Items)
        $attentionList = $this->getAttentionList($organizationDoctorIds, $user->id);
        
        // Activity Feed
        $activityFeed = $this->getActivityFeed($organizationDoctorIds, $user->id);
        
        // Applications Snapshot
        $applicationsSnapshot = $this->getApplicationsSnapshot($organizationDoctorIds);
        
        // Compliance Score
        $complianceScore = $this->calculateComplianceScore($organizationDoctorIds, $user->id);

        return [
            'organization' => $user,
            'metrics' => $metrics,
            'attentionList' => $attentionList,
            'activityFeed' => $activityFeed,
            'applicationsSnapshot' => $applicationsSnapshot,
            'complianceScore' => $complianceScore,
            // Keep old data for backward compatibility (commented out sections)
            'totalStaff' => User::where('org_id', $user->id)->count(),
            'totalDoctors' => $organizationDoctorIds->count(),
            'activeStaff' => User::where('org_id', $user->id)->where('is_active', true)->count(),
            'activeDoctors' => User::whereIn('id', $organizationDoctorIds)->where('is_active', true)->count(),
            'recentStaff' => User::where('org_id', $user->id)->where('created_at', '>=', now()->subDays(30))->count(),
            'recentDoctors' => User::whereIn('id', $organizationDoctorIds)->where('created_at', '>=', now()->subDays(30))->count(),
            'latestStaff' => collect(),
            'latestDoctors' => collect(),
            'latestApplications' => $this->getLatestApplications(),
        ];
    }

    private function getEmptyStats()
    {
            return [
            'organization' => null,
            'metrics' => [
                'providers' => 0,
                'credentialing' => 0,
                'licensing' => 0,
                'enrollment' => 0,
            ],
            'attentionList' => collect(),
            'activityFeed' => collect(),
            'applicationsSnapshot' => collect(),
            'complianceScore' => 0,
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

    private function getMetrics($organizationDoctorIds, $orgId)
    {
        // Providers count (active doctors)
        $providers = User::whereIn('id', $organizationDoctorIds)
            ->where('is_active', true)
            ->count();

        // Credentialing count (all credentials)
        $credentialing = DoctorCredential::whereIn('user_id', $organizationDoctorIds)->count();

        // Licensing count (doctor licenses + organization licenses)
        $doctorLicenses = DoctorLicense::whereIn('user_id', $organizationDoctorIds)->count();
        $orgLicenses = OrganizationLicense::where('user_id', $orgId)->count();
        $licensing = $doctorLicenses + $orgLicenses;

        // Enrollment count (credentials with payer_id)
        $enrollment = DoctorCredential::whereIn('user_id', $organizationDoctorIds)
            ->whereNotNull('payer_id')
            ->count();

        return [
            'providers' => $providers,
            'credentialing' => $credentialing,
            'licensing' => $licensing,
            'enrollment' => $enrollment,
        ];
    }

    private function getAttentionList($organizationDoctorIds, $orgId)
    {
        $threshold = now()->addMonths(3);
        $items = collect();

        // Expiring Doctor Licenses
        $expiringDoctorLicenses = DoctorLicense::whereIn('user_id', $organizationDoctorIds)
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<=', $threshold)
            ->whereDate('expiration_date', '>=', now())
            ->with(['licenseType', 'state', 'user'])
            ->get()
            ->map(function ($license) {
                return [
                    'type' => 'expiring',
                    'category' => 'License',
                    'doctor' => $license->user->name ?? 'N/A',
                    'item' => ($license->licenseType->name ?? 'License') . ' ' . ($license->state ? '(' . ($license->state->code ?? $license->state->name) . ')' : ''),
                    'number' => $license->license_number,
                    'expires_at' => $license->expiration_date,
                    'days_until_expiry' => now()->diffInDays($license->expiration_date, false),
                ];
            });

        // Expiring Doctor Credentials
        $expiringDoctorCredentials = DoctorCredential::whereIn('user_id', $organizationDoctorIds)
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<=', $threshold)
            ->whereDate('expiration_date', '>=', now())
            ->with(['payer', 'user'])
            ->get()
            ->map(function ($cred) {
                return [
                    'type' => 'expiring',
                    'category' => 'Credential',
                    'doctor' => $cred->user->name ?? 'N/A',
                    'item' => ($cred->payer->name ?? 'Payer') . ' - ' . ($cred->credential_name ?? 'Credential'),
                    'number' => $cred->credential_number,
                    'expires_at' => $cred->expiration_date,
                    'days_until_expiry' => now()->diffInDays($cred->expiration_date, false),
                ];
            });

        // Expiring Organization Licenses
        $expiringOrgLicenses = OrganizationLicense::where('user_id', $orgId)
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<=', $threshold)
            ->whereDate('expiration_date', '>=', now())
            ->get()
            ->map(function ($license) {
                return [
                    'type' => 'expiring',
                    'category' => 'Organization License',
                    'doctor' => 'Organization',
                    'item' => $license->issuing_authority ?? 'License',
                    'number' => $license->license_number,
                    'expires_at' => $license->expiration_date,
                    'days_until_expiry' => now()->diffInDays($license->expiration_date, false),
                ];
            });

        // Expiring Organization Certificates
        $expiringOrgCertificates = OrganizationCertificate::where('user_id', $orgId)
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<=', $threshold)
            ->whereDate('expiration_date', '>=', now())
            ->get()
            ->map(function ($cert) {
                return [
                    'type' => 'expiring',
                    'category' => 'Organization Certificate',
                    'doctor' => 'Organization',
                    'item' => $cert->issuing_organization ?? 'Certificate',
                    'number' => $cert->certificate_number,
                    'expires_at' => $cert->expiration_date,
                    'days_until_expiry' => now()->diffInDays($cert->expiration_date, false),
                ];
            });

        // Missing items - doctors without licenses
        $doctorsWithoutLicenses = User::whereIn('id', $organizationDoctorIds)
            ->where('is_active', true)
            ->whereDoesntHave('licenses')
            ->get()
            ->map(function ($doctor) {
                return [
                    'type' => 'missing',
                    'category' => 'License',
                    'doctor' => $doctor->name,
                    'item' => 'No license found',
                    'number' => null,
                    'expires_at' => null,
                    'days_until_expiry' => null,
                ];
            });

        return $items
            ->concat($expiringDoctorLicenses)
            ->concat($expiringDoctorCredentials)
            ->concat($expiringOrgLicenses)
            ->concat($expiringOrgCertificates)
            ->concat($doctorsWithoutLicenses)
            ->sortBy(function ($item) {
                if ($item['type'] === 'missing') {
                    return PHP_INT_MAX;
                }
                return $item['days_until_expiry'] ?? PHP_INT_MAX;
            })
            ->take(10)
            ->values();
    }

    private function getActivityFeed($organizationDoctorIds, $orgId)
    {
        $activities = collect();

        // Recent credential updates
        $recentCredentials = DoctorCredential::whereIn('user_id', $organizationDoctorIds)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($cred) {
                return [
                    'type' => 'credential',
                    'action' => 'updated',
                    'description' => 'Credential ' . ($cred->status ?? 'updated') . ' for ' . ($cred->user->name ?? 'Provider'),
                    'payer' => $cred->payer->name ?? null,
                    'created_at' => $cred->updated_at ?? $cred->created_at,
                ];
            });

        // Recent license updates
        $recentLicenses = DoctorLicense::whereIn('user_id', $organizationDoctorIds)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($license) {
                return [
                    'type' => 'license',
                    'action' => 'updated',
                    'description' => 'License ' . ($license->status->value ?? 'updated') . ' for ' . ($license->user->name ?? 'Provider'),
                    'payer' => null,
                    'created_at' => $license->updated_at ?? $license->created_at,
                ];
            });

        // Recent doctor additions
        $recentDoctors = User::whereIn('id', $organizationDoctorIds)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($doctor) {
                return [
                    'type' => 'provider',
                    'action' => 'added',
                    'description' => 'Provider ' . $doctor->name . ' added to organization',
                    'payer' => null,
                    'created_at' => $doctor->created_at,
                ];
            });

        return $activities
            ->concat($recentCredentials)
            ->concat($recentLicenses)
            ->concat($recentDoctors)
            ->sortByDesc('created_at')
            ->take(10)
            ->values();
    }

    private function getApplicationsSnapshot($organizationDoctorIds)
    {
        return DoctorCredential::with(['payer', 'state', 'user'])
            ->whereIn('user_id', $organizationDoctorIds)
            ->whereNotNull('payer_id')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($credential) {
        return [
                    'id' => $credential->id,
                    'provider_name' => $credential->user->name ?? 'N/A',
                    'payer_name' => $credential->payer->name ?? 'N/A',
                    'state_name' => $credential->state->name ?? 'N/A',
                    'request_type' => $credential->request_type ?? 'N/A',
                    'status' => $credential->status ?? 'N/A',
                    'submitted_at' => $credential->submitted_at ?? $credential->created_at,
                    'created_at' => $credential->created_at,
                ];
            });
    }

    private function calculateComplianceScore($organizationDoctorIds, $orgId)
    {
        $totalChecks = 0;
        $passedChecks = 0;

        // Check 1: Organization has NPI
        $totalChecks++;
        if (Auth::user()->npi_number) {
            $passedChecks++;
        }

        // Check 2: Organization has Tax ID
        $totalChecks++;
        if (Auth::user()->tax_id) {
            $passedChecks++;
        }

        // Check 3: Organization has at least one license
        $totalChecks++;
        if (OrganizationLicense::where('user_id', $orgId)->exists()) {
            $passedChecks++;
        }

        // Check 4: All active doctors have at least one license
        $activeDoctors = User::whereIn('id', $organizationDoctorIds)
            ->where('is_active', true)
            ->count();
        $totalChecks++;
        if ($activeDoctors > 0) {
            $doctorsWithLicenses = User::whereIn('id', $organizationDoctorIds)
                ->where('is_active', true)
                ->whereHas('licenses')
                ->count();
            if ($doctorsWithLicenses === $activeDoctors) {
                $passedChecks++;
            }
        } else {
            $passedChecks++; // No doctors, so this check passes
        }

        // Check 5: No expired licenses (within last 30 days)
        $totalChecks++;
        $recentlyExpired = DoctorLicense::whereIn('user_id', $organizationDoctorIds)
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<', now())
            ->whereDate('expiration_date', '>=', now()->subDays(30))
            ->count();
        if ($recentlyExpired === 0) {
            $passedChecks++;
        }

        if ($totalChecks === 0) {
            return 100;
        }

        return round(($passedChecks / $totalChecks) * 100);
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
