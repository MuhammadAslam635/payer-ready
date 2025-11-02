<?php

namespace App\Livewire\Organization;

use App\Models\DoctorCredential;
use App\Models\DoctorLicense;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Doctor Expirables')]
#[Layout('layouts.dashboard')]
class DoctorExpirablesComponent extends Component
{
    public array $items = [];

    public function mount(): void
    {
        $adminId = Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $adminId)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id');

        $licenses = DoctorLicense::query()
            ->whereIn('user_id', $doctorIds)
            ->whereNotNull('expiration_date')
            ->where('expiration_date', '<', now())
            ->with(['licenseType', 'state'])
            ->get()
            ->map(function ($license) {
                return [
                    'category' => 'License',
                    'about' => trim(($license->licenseType->name ?? 'License') . ' ' . (isset($license->state) ? '(' . ($license->state->code ?? $license->state->name) . ')' : '')),
                    'number' => $license->license_number ?? null,
                    'expires_at' => $license->expiration_date,
                ];
            });

        $credentials = DoctorCredential::query()
            ->whereIn('user_id', $doctorIds)
            ->whereNotNull('expiration_date')
            ->where('expiration_date', '<', now())
            ->with(['state', 'payer'])
            ->get()
            ->map(function ($cred) {
                return [
                    'category' => 'Payer',
                    'about' => trim(($cred->payer->name ?? 'Payer') . ' - ' . ($cred->credential_name ?? 'Credential')),
                    'number' => $cred->credential_number ?? null,
                    'expires_at' => $cred->expiration_date,
                ];
            });

        $this->items = $licenses
            ->concat($credentials)
            ->sortBy(function ($item) {
                return is_null($item['expires_at']) ? PHP_INT_MAX : $item['expires_at']->timestamp;
            })
            ->values()
            ->all();
    }

    public function render()
    {
        return view('livewire.organization.doctor-expirables-component');
    }
}


