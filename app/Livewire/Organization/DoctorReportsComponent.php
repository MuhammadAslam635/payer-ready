<?php

namespace App\Livewire\Organization;

use App\Models\DoctorLicense;
use App\Models\Insurance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Doctor Reports')]
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
            ->with(['licenseType', 'state']);

        $insurancesQuery = Insurance::query()
            ->whereIn('user_id', $doctorIds);

        if ($this->startDate) {
            $licensesQuery->whereDate('created_at', '>=', $this->startDate);
            $insurancesQuery->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $licensesQuery->whereDate('created_at', '<=', $this->endDate);
            $insurancesQuery->whereDate('created_at', '<=', $this->endDate);
        }

        $licenses = $licensesQuery->get()->map(function ($license) use ($organizationName) {
            return [
                'category' => 'License',
                'about' => trim(($license->licenseType->name ?? 'License') . ' ' . (isset($license->state) ? '(' . ($license->state->code ?? $license->state->name) . ')' : '')),
                'organization' => $organizationName,
                'group_npi' => $license->license_number ?? null,
                'created_at' => $license->created_at,
            ];
        });

        $insurances = $insurancesQuery->get()->map(function ($ins) use ($organizationName) {
            return [
                'category' => 'Insurance',
                'about' => trim(($ins->carrier ?? 'Insurance') . ' - Policy ' . ($ins->policy_number ?? '—')),
                'organization' => $organizationName,
                'group_npi' => $ins->policy_number ?? null,
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
            }, 'organization-report.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        }

        $csv = collect([
            ['Type', 'About', 'Business/Clinic/Organization', 'Group NPI', 'Created At'],
            ...array_map(function ($i) {
                return [
                    $i['category'],
                    $i['about'],
                    $i['organization'] ?? '',
                    $i['group_npi'] ?? '',
                    $i['created_at'] ? $i['created_at']->format('Y-m-d') : '',
                ];
            }, $currentItems)
        ])->map(fn($row) => implode(',', array_map(function ($v) { return '"' . str_replace('"', '""', (string)$v) . '"'; }, $row)))->implode("\r\n");

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'organization-report.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function render()
    {
        return view('livewire.organization.doctor-reports-component');
    }
}


