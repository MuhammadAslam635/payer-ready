<?php

namespace App\Livewire\SuperAdmin\License;

use App\Models\DoctorLicense;
use App\Models\LicenseType;
use App\Models\State;
use App\Enums\LicenseStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class SuperAdminViewAllLicenseComponent extends Component
{
    use WithPagination;

    // Filter properties
    public $search = '';
    public $statusFilter = '';
    public $licenseTypeFilter = '';
    public $stateFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Modal properties
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $selectedLicense = null;

    // Edit form properties
    public $editLicenseNumber = '';
    public $editStatus = '';
    public $editIssueDate = '';
    public $editExpirationDate = '';
    public $editIssuingAuthority = '';
    public $editNotes = '';
    public $editVerificationNotes = '';
    public $editIsVerified = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'licenseTypeFilter' => ['except' => ''],
        'stateFilter' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingLicenseTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingStateFilter()
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
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->licenseTypeFilter = '';
        $this->stateFilter = '';
        $this->resetPage();
    }

    public function editLicense($licenseId)
    {
        $this->selectedLicense = DoctorLicense::with(['user', 'licenseType', 'state'])->find($licenseId);

        if ($this->selectedLicense) {
            $this->editLicenseNumber = $this->selectedLicense->license_number;
            $this->editStatus = $this->selectedLicense->status->value;
            $this->editIssueDate = $this->selectedLicense->issue_date?->format('Y-m-d');
            $this->editExpirationDate = $this->selectedLicense->expiration_date?->format('Y-m-d');
            $this->editIssuingAuthority = $this->selectedLicense->issuing_authority ?? '';
            $this->editNotes = $this->selectedLicense->notes ?? '';
            $this->editVerificationNotes = $this->selectedLicense->verification_notes ?? '';
            $this->editIsVerified = $this->selectedLicense->is_verified;

            $this->showEditModal = true;
        }
    }

    public function updateLicense()
    {
        $this->validate([
            'editLicenseNumber' => 'required|string|max:255',
            'editStatus' => 'required|in:' . implode(',', array_column(LicenseStatus::cases(), 'value')),
            'editIssueDate' => 'nullable|date',
            'editExpirationDate' => 'nullable|date|after:editIssueDate',
            'editIssuingAuthority' => 'nullable|string|max:255',
            'editNotes' => 'nullable|string',
            'editVerificationNotes' => 'nullable|string',
            'editIsVerified' => 'boolean',
        ]);

        $this->selectedLicense->update([
            'license_number' => $this->editLicenseNumber,
            'status' => LicenseStatus::from($this->editStatus),
            'issue_date' => $this->editIssueDate,
            'expiration_date' => $this->editExpirationDate,
            'issuing_authority' => $this->editIssuingAuthority,
            'notes' => $this->editNotes,
            'verification_notes' => $this->editVerificationNotes,
            'is_verified' => $this->editIsVerified,
            'verified_at' => $this->editIsVerified ? now() : null,
            'verified_by' => $this->editIsVerified ? Auth::user()->id : null,
        ]);

        $this->showEditModal = false;
        $this->selectedLicense = null;

        session()->flash('message', 'License updated successfully.');
    }

    public function confirmDelete($licenseId)
    {
        $this->selectedLicense = DoctorLicense::with(['user', 'licenseType', 'state'])->find($licenseId);
        $this->showDeleteModal = true;
    }

    public function deleteLicense()
    {
        if ($this->selectedLicense) {
            $this->selectedLicense->delete();
            $this->showDeleteModal = false;
            $this->selectedLicense = null;

            session()->flash('message', 'License deleted successfully.');
        }
    }

    public function closeModal()
    {
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->selectedLicense = null;
        $this->resetValidation();
    }

    public function render()
    {
        $licenses = DoctorLicense::with(['user', 'licenseType', 'state'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhere('license_number', 'like', '%' . $this->search . '%')
                ->orWhereHas('licenseType', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->licenseTypeFilter, function ($query) {
                $query->where('license_type_id', $this->licenseTypeFilter);
            })
            ->when($this->stateFilter, function ($query) {
                $query->where('state_id', $this->stateFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        $licenseTypes = LicenseType::orderBy('name')->get();
        $states = State::orderBy('name')->get();
        $licenseStatuses = LicenseStatus::options();

        return view('livewire.super-admin.license.super-admin-view-all-license-component', [
            'licenses' => $licenses,
            'licenseTypes' => $licenseTypes,
            'states' => $states,
            'licenseStatuses' => $licenseStatuses,
        ]);
    }
}
