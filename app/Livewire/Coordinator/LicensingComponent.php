<?php

namespace App\Livewire\Coordinator;

use App\Models\DoctorLicense;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Licensing')]
#[Layout('layouts.dashboard')]
class LicensingComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $queryString = ['search'];

    public function getLicenses()
    {
        $orgAdminId = Auth::user()->org_id ?: Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $orgAdminId)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id');

        return DoctorLicense::query()
            ->with(['licenseType','state','user'])
            ->whereIn('user_id', $doctorIds)
            ->when($this->search, function ($q) {
                $q->where('license_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('licenseType', function ($tq) {
                      $tq->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('state', function ($sq) {
                      $sq->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('user', function ($uq) {
                      $uq->where('name', 'like', '%' . $this->search . '%');
                  });
            })
            ->orderByDesc('created_at')
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.coordinator.licensing-component', [
            'licenses' => $this->getLicenses(),
        ]);
    }
}


