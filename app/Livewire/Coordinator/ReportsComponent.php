<?php

namespace App\Livewire\Coordinator;

use App\Models\DoctorLicense;
use App\Models\Insurance;
use App\Models\User;
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
        $orgAdminId = Auth::user()->org_id ?: Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $orgAdminId)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id');

        $licensesQuery = DoctorLicense::query()
            ->whereIn('user_id', $doctorIds)
            ->with(['licenseType', 'state', 'user']);

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

        $licenses = $licensesQuery->get()->map(function ($license) {
            return [
                'doctor' => $license->user->name ?? '—',
                'category' => 'License',
                'about' => trim(($license->licenseType->name ?? 'License') . ' ' . (isset($license->state) ? '(' . ($license->state->code ?? $license->state->name) . ')' : '')),
                'number' => $license->license_number ?? null,
                'created_at' => $license->created_at,
            ];
        });

        $insurances = $insurancesQuery->get()->map(function ($ins) {
            return [
                'doctor' => $ins->user->name ?? '—',
                'category' => 'Insurance',
                'about' => trim(($ins->carrier ?? 'Insurance') . ' - Policy ' . ($ins->policy_number ?? '—')),
                'number' => $ins->policy_number ?? null,
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

    public function render()
    {
        return view('livewire.coordinator.reports-component');
    }
}


