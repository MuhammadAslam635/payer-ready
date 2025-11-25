<?php

namespace App\Livewire\Doctor;

use App\Models\DoctorCredential;
use App\Models\DoctorLicense;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title('Expirables')]
#[Layout('layouts.dashboard')]
class ExpirablesComponent extends Component
{ 
    public $items = [];

    public function mount()
    { 
        $userId = Auth::id();

        $threshold = now()->addMonths(3);

        $licenses = DoctorLicense::query()
            ->where('user_id', $userId)
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<=', $threshold)
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
            ->where('user_id', $userId)
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<=', $threshold)
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
        return view('livewire.doctor.expirables-component');
    }
}


