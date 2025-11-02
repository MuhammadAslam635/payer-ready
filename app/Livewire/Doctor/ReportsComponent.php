<?php

namespace App\Livewire\Doctor;

use App\Enums\LicenseStatus;
use App\Models\DoctorCredential;
use App\Models\DoctorLicense;
use App\Models\Insurance;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Reports')]
#[Layout('layouts.dashboard')]
class ReportsComponent extends Component
{
    public $startDate = null;
    public $endDate = null;
    public $status = 'active'; // unused

    public $items = [];

    public function updated($property)
    {
        if (in_array($property, ['startDate', 'endDate', 'status'])) {
            // Filters are ignored; still reload to be explicit
            $this->loadData();
        }
    }

    public function mount()
    {
        $this->loadData();
    }

    private function loadData(): void
    {
        $userId = Auth::id();

        $licensesQuery = DoctorLicense::query()
            ->where('user_id', $userId)
            ->with(['licenseType', 'state']);

        $credentialsQuery = DoctorCredential::query()
            ->where('user_id', $userId)
            ->with(['state', 'payer']);

        $insurancesQuery = Insurance::query()
            ->where('user_id', $userId);

        // Apply created_at date filters if provided
        if ($this->startDate) {
            $licensesQuery->whereDate('created_at', '>=', $this->startDate);
            $insurancesQuery->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $licensesQuery->whereDate('created_at', '<=', $this->endDate);
            $insurancesQuery->whereDate('created_at', '<=', $this->endDate);
        }

        $licenses = $licensesQuery->get()->map(function ($license) {
            return [
                'category' => 'License',
                'about' => trim(($license->licenseType->name ?? 'License') . ' ' . (isset($license->state) ? '(' . ($license->state->code ?? $license->state->name) . ')' : '')),
                'business_name' => $license->user->business_name ?? $license->user->name ?? 'N/A',
                'group_npi' => $license->user->npi_number ?? 'N/A',
                'created_at' => $license->created_at,
            ];
        });
        // Credentials are excluded per latest requirement

        $insurances = $insurancesQuery->get()->map(function ($ins) {
            return [
                'category' => 'Insurance',
                'about' => trim(($ins->carrier ?? 'Insurance') . ' - Policy ' . ($ins->policy_number ?? '—')),
                'business_name' => $ins->user->business_name ?? $ins->user->name ?? 'N/A',
                'group_npi' => $ins->user->npi_number ?? 'N/A',
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
            $html = view('livewire.doctor.partials.reports-pdf', [
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
            }, 'doctor-report.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        }

        $csv = collect([
            ['Type', 'About', 'Business/Clinic/Organization Name', 'Group NPI', 'Created At'],
            ...array_map(function ($i) {
                return [
                    $i['category'],
                    $i['about'],
                    $i['business_name'] ?? '',
                    $i['group_npi'] ?? '',
                    $i['created_at'] ? $i['created_at']->format('Y-m-d') : '',
                ];
            }, $currentItems)
        ])->map(fn($row) => implode(',', array_map(function ($v) { return '"' . str_replace('"', '""', (string)$v) . '"'; }, $row)))->implode("\r\n");

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'doctor-report.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function viewReport()
    {
        $currentItems = $this->items;
        $currentStart = $this->startDate;
        $currentEnd = $this->endDate;

        // Clear inputs before viewing as requested
        $this->startDate = null;
        $this->endDate = null;

        if (class_exists(\Dompdf\Dompdf::class)) {
            $html = view('livewire.doctor.partials.reports-pdf', [
                'items' => $currentItems,
                'startDate' => $currentStart,
                'endDate' => $currentEnd,
            ])->render();

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('a4', 'portrait');
            $dompdf->render();

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="doctor-report.pdf"',
            ]);
        }

        // Fallback: render HTML view inline
        return response(
            view('livewire.doctor.partials.reports-pdf', [
                'items' => $currentItems,
                'startDate' => $currentStart,
                'endDate' => $currentEnd,
            ])->render(),
            200,
            ['Content-Type' => 'text/html']
        );
    }

    public function render()
    {
        return view('livewire.doctor.reports-component');
    }
}


