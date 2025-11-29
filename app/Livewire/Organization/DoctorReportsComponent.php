<?php

namespace App\Livewire\Organization;

use App\Models\DoctorLicense;
use App\Models\Insurance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Provider Reports')]
#[Layout('layouts.dashboard')]
class DoctorReportsComponent extends Component
{
    public $startDate = null;
    public $endDate = null;

    public array $items = [];

    public function updated($property): void
    {
        if (in_array($property, ['startDate', 'endDate'])) {
            $this->loadData();
        }
    }

    public function mount(): void
    {
        $this->loadData();
    }

    private function loadData(): void
    {
        $adminId = Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $adminId)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id');

        // Get organization name
        $organization = User::find($adminId);
        $organizationName = $organization->name ?? 'Organization';

        $licensesQuery = DoctorLicense::query()
            ->whereIn('user_id', $doctorIds)
            ->with(['licenseType', 'state', 'user.specialties']);

        $insurancesQuery = Insurance::query()
            ->whereIn('user_id', $doctorIds)
            ->with(['user.specialties']);

        if ($this->startDate) {
            $licensesQuery->whereDate('created_at', '>=', $this->startDate);
            $insurancesQuery->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $licensesQuery->whereDate('created_at', '<=', $this->endDate);
            $insurancesQuery->whereDate('created_at', '<=', $this->endDate);
        }

        $licenses = $licensesQuery->get()->map(function ($license) {
            // Get provider name
            $providerName = $license->user->name ?? 'N/A';
            
            // Get specialty/type - primary specialty or first specialty
            $specialty = 'N/A';
            if ($license->user && $license->user->specialties) {
                $primarySpecialty = $license->user->specialties->where('pivot.is_primary', true)->first();
                if ($primarySpecialty) {
                    $specialty = $primarySpecialty->name;
                } elseif ($license->user->specialties->count() > 0) {
                    $specialty = $license->user->specialties->first()->name;
                }
            }
            
            return [
                'category' => 'License',
                'specialty_type' => $specialty,
                'provider_name' => $providerName,
                'license_number' => $license->license_number ?? '—',
                'created_at' => $license->created_at,
            ];
        });

        $insurances = $insurancesQuery->get()->map(function ($ins) {
            // Get provider name
            $providerName = $ins->user->name ?? 'N/A';
            
            // Get specialty/type - primary specialty or first specialty
            $specialty = 'N/A';
            if ($ins->user && $ins->user->specialties) {
                $primarySpecialty = $ins->user->specialties->where('pivot.is_primary', true)->first();
                if ($primarySpecialty) {
                    $specialty = $primarySpecialty->name;
                } elseif ($ins->user->specialties->count() > 0) {
                    $specialty = $ins->user->specialties->first()->name;
                }
            }
            
            return [
                'category' => 'Insurance',
                'specialty_type' => $specialty,
                'provider_name' => $providerName,
                'license_number' => '—', // Insurance doesn't have license number
                'created_at' => $ins->created_at,
            ];
        });

        $this->items = $licenses
            ->concat($insurances)
            ->sortBy(function ($item) {
                return is_null($item['created_at']) ? PHP_INT_MAX : $item['created_at']->timestamp;
            })
            ->values()
            ->all();
    }

    public function downloadReport()
    {
        $currentItems = $this->items;
        $currentStart = $this->startDate;
        $currentEnd = $this->endDate;

        // Clear inputs after triggering generation
        $this->startDate = null;
        $this->endDate = null;

        // Try to render PDF via Dompdf if installed, otherwise fallback to CSV
        if (class_exists(\Dompdf\Dompdf::class)) {
            $html = view('livewire.organization.partials.reports-pdf', [
                'items' => $currentItems,
                'startDate' => $currentStart,
                'endDate' => $currentEnd,
            ])->render();

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('a4', 'portrait');
            $dompdf->render();

            $output = $dompdf->output();

            return response()->streamDownload(function () use ($output) {
                echo $output;
            }, 'provider-report.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        }

        $csv = collect([
            ['Type', 'Specialty/Type', 'Provider Name', 'License Number', 'Created At'],
            ...array_map(function ($i) {
                return [
                    $i['category'],
                    $i['specialty_type'] ?? '',
                    $i['provider_name'] ?? '',
                    $i['license_number'] ?? '',
                    $i['created_at'] ? $i['created_at']->format('Y-m-d') : '',
                ];
            }, $currentItems)
        ])->map(fn($row) => implode(',', array_map(function ($v) { return '"' . str_replace('"', '""', (string)$v) . '"'; }, $row)))->implode("\r\n");

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'provider-report.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function render()
    {
        return view('livewire.organization.doctor-reports-component');
    }
}


