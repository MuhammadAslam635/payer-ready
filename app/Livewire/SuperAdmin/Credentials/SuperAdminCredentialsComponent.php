<?php

namespace App\Livewire\SuperAdmin\Credentials;

use App\Enums\CredentialStatus;
use App\Models\DoctorCredential;
use App\Models\State;
use App\Models\Payer;
use App\Traits\HasToast;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class SuperAdminCredentialsComponent extends Component
{
    use WithPagination, HasToast;

    // Search and Filter Properties
    public $search = '';
    public $statusFilter = '';
    public $stateFilter = '';
    public $payerFilter = '';
    public $verificationFilter = '';
    public $startDate = '';
    public $endDate = '';

    // Sorting Properties
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Modal Properties
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $selectedCredential = null;

    // Edit Form Properties
    public $editStatus = '';
    public $editEffectiveDate = '';
    public $editDescription = '';
    public $editIsVerified = false;
    public $editVerificationNotes = '';

    protected $rules = [
        'editStatus' => 'required|string',
        'editEffectiveDate' => 'nullable|date',
        'editDescription' => 'nullable|string',
        'editIsVerified' => 'boolean',
        'editVerificationNotes' => 'nullable|string',
    ];

    protected $listeners = ['refreshCredentials' => '$refresh'];

    public function mount()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingStateFilter()
    {
        $this->resetPage();
    }

    public function updatingPayerFilter()
    {
        $this->resetPage();
    }

    public function updatingVerificationFilter()
    {
        $this->resetPage();
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->stateFilter = '';
        $this->payerFilter = '';
        $this->verificationFilter = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->resetPage();
    }

    public function editCredential($credentialId)
    {
        $this->selectedCredential = DoctorCredential::with(['user', 'state', 'payer'])->find($credentialId);
        
        if ($this->selectedCredential) {
            $this->editStatus = $this->selectedCredential->status;
            $this->editEffectiveDate = $this->selectedCredential->effective_date?->format('Y-m-d') ?? '';
            $this->editDescription = $this->selectedCredential->description ?? '';
            $this->editIsVerified = $this->selectedCredential->is_verified;
            $this->editVerificationNotes = $this->selectedCredential->verification_notes ?? '';
            
            $this->showEditModal = true;
        }
    }

    public function updateCredential()
    {
        $this->validate();

        try {
            $this->selectedCredential->update([
                'status' => $this->editStatus,
                'effective_date' => $this->editEffectiveDate ?: null,
                'description' => $this->editDescription,
                'is_verified' => $this->editIsVerified,
                'verification_notes' => $this->editVerificationNotes,
                'verified_at' => $this->editIsVerified ? now() : null,
                'verified_by' => $this->editIsVerified ? Auth::user()->id : null,
            ]);

            $this->toastSuccess('Application updated successfully!');
            $this->closeModal();
            $this->dispatch('refreshCredentials');
        } catch (\Exception $e) {
            $this->toastError('Error updating application: ' . $e->getMessage());
        }
    }

    public function confirmDelete($credentialId)
    {
        $this->selectedCredential = DoctorCredential::with(['user', 'state', 'payer'])->find($credentialId);
        $this->showDeleteModal = true;
    }

    public function deleteCredential()
    {
        try {
            $this->selectedCredential->delete();
            $this->toastSuccess('Application deleted successfully!');
            $this->closeModal();
            $this->dispatch('refreshCredentials');
        } catch (\Exception $e) {
            $this->toastError('Error deleting credential: ' . $e->getMessage());
        }
    }

    public function closeModal()
    {
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->selectedCredential = null;
        $this->resetValidation();
        $this->resetEditForm();
    }

    private function resetEditForm()
    {
        $this->editStatus = '';
        $this->editEffectiveDate = '';
        $this->editDescription = '';
        $this->editIsVerified = false;
        $this->editVerificationNotes = '';
    }

    public function getCredentialsProperty()
    {
        return DoctorCredential::query()
            ->with(['user', 'state', 'payer', 'verifier'])
            ->when($this->search, function (Builder $query) {
                $query->where(function (Builder $subQuery) {
                    $subQuery->whereHas('user', function (Builder $userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('email', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('payer', function (Builder $payerQuery) {
                            $payerQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->statusFilter, function (Builder $query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->stateFilter, function (Builder $query) {
                $query->where('state_id', $this->stateFilter);
            })
            ->when($this->payerFilter, function (Builder $query) {
                $query->where('payer_id', $this->payerFilter);
            })
            ->when($this->verificationFilter !== '', function (Builder $query) {
                if ($this->verificationFilter === '1') {
                    $query->where('is_verified', true);
                } else {
                    $query->where('is_verified', false);
                }
            })
            ->when($this->startDate, function (Builder $query) {
                $query->whereDate('created_at', '>=', $this->startDate);
            })
            ->when($this->endDate, function (Builder $query) {
                $query->whereDate('created_at', '<=', $this->endDate);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);
    }

    public function getCredentialStatusesProperty()
    {
        return CredentialStatus::options();
    }

    public function getStatesProperty()
    {
        return State::orderBy('name')->get();
    }

    public function getPayersProperty()
    {
        return Payer::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.super-admin.credentials.super-admin-credentials-component', [
            'credentials' => $this->credentials,
            'credentialStatuses' => $this->credentialStatuses,
            'states' => $this->states,
            'payers' => $this->payers,
        ]);
    }
}
