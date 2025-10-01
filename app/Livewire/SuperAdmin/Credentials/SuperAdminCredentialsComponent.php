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

    // Sorting Properties
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Modal Properties
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $selectedCredential = null;

    // Edit Form Properties
    public $editCredentialName = '';
    public $editIssuingOrganization = '';
    public $editCredentialNumber = '';
    public $editIssueDate = '';
    public $editExpirationDate = '';
    public $editStatus = '';
    public $editDescription = '';
    public $editIsVerified = false;
    public $editVerificationNotes = '';

    protected $rules = [
        'editCredentialName' => 'required|string|max:255',
        'editIssuingOrganization' => 'required|string|max:255',
        'editCredentialNumber' => 'required|string|max:255',
        'editIssueDate' => 'nullable|date',
        'editExpirationDate' => 'nullable|date|after:editIssueDate',
        'editStatus' => 'required|string',
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
        $this->resetPage();
    }

    public function editCredential($credentialId)
    {
        $this->selectedCredential = DoctorCredential::with(['user', 'state', 'payer'])->find($credentialId);
        
        if ($this->selectedCredential) {
            $this->editCredentialName = $this->selectedCredential->credential_name;
            $this->editIssuingOrganization = $this->selectedCredential->issuing_organization;
            $this->editCredentialNumber = $this->selectedCredential->credential_number;
            $this->editIssueDate = $this->selectedCredential->issue_date?->format('Y-m-d') ?? '';
            $this->editExpirationDate = $this->selectedCredential->expiration_date?->format('Y-m-d') ?? '';
            $this->editStatus = $this->selectedCredential->status;
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
                'credential_name' => $this->editCredentialName,
                'issuing_organization' => $this->editIssuingOrganization,
                'credential_number' => $this->editCredentialNumber,
                'issue_date' => $this->editIssueDate ?: null,
                'expiration_date' => $this->editExpirationDate ?: null,
                'status' => $this->editStatus,
                'description' => $this->editDescription,
                'is_verified' => $this->editIsVerified,
                'verification_notes' => $this->editVerificationNotes,
                'verified_at' => $this->editIsVerified ? now() : null,
                'verified_by' => $this->editIsVerified ? Auth::user()->id : null,
            ]);

            $this->toastSuccess('Credential updated successfully!');
            $this->closeModal();
            $this->dispatch('refreshCredentials');
        } catch (\Exception $e) {
            $this->toastError('Error updating credential: ' . $e->getMessage());
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
            $this->toastSuccess('Credential deleted successfully!');
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
        $this->editCredentialName = '';
        $this->editIssuingOrganization = '';
        $this->editCredentialNumber = '';
        $this->editIssueDate = '';
        $this->editExpirationDate = '';
        $this->editStatus = '';
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
                    $subQuery->where('credential_name', 'like', '%' . $this->search . '%')
                        ->orWhere('credential_number', 'like', '%' . $this->search . '%')
                        ->orWhere('issuing_organization', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function (Builder $userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%')
                                ->orWhere('email', 'like', '%' . $this->search . '%');
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
