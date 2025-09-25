<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\DoctorProfile;
use App\Models\Specialty;
use Illuminate\Support\Facades\Auth;

#[Title('All Providers')]
#[Layout('layouts.dashboard')]
class InviteProvidersComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedProviders = [];

    public function mount()
    {
        // Initialize any required data
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleProviderSelection($providerId)
    {
        if (in_array($providerId, $this->selectedProviders)) {
            $this->selectedProviders = array_diff($this->selectedProviders, [$providerId]);
        } else {
            $this->selectedProviders[] = $providerId;
        }
    }

    public function selectAllProviders()
    {
        $providers = $this->getProviders();
        $this->selectedProviders = $providers->pluck('id')->toArray();
    }

    public function clearSelection()
    {
        $this->selectedProviders = [];
    }

    public function inviteSelectedProviders()
    {
        if (empty($this->selectedProviders)) {
            session()->flash('error', 'Please select at least one provider to invite.');
            return;
        }

        // Here you would implement the actual invitation logic
        // For now, we'll just show a success message
        session()->flash('success', 'Invitations sent to ' . count($this->selectedProviders) . ' provider(s).');
        $this->clearSelection();
    }

    private function getProviders()
    {
        $query = DoctorProfile::with(['user', 'primarySpecialty'])
            ->whereHas('user', function ($q) {
                $q->where('user_type', 'doctor');
            });

        // Search functionality
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($userQuery) {
                    $userQuery->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhere('npi_number', 'like', '%' . $this->search . '%');
            });
        }

        // Sorting
        if ($this->sortField === 'name') {
            $query->join('users', 'doctor_profiles.user_id', '=', 'users.id')
                  ->orderBy('users.name', $this->sortDirection)
                  ->select('doctor_profiles.*');
        } elseif ($this->sortField === 'status') {
            $query->orderBy('status', $this->sortDirection);
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        $providers = $this->getProviders();

        return view('livewire.doctor.invite-providers-component', [
            'providers' => $providers,
        ]);
    }
}
