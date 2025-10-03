<?php

namespace App\Livewire\SuperAdmin\Certificate;

use App\Models\DoctorCertificate;
use App\Models\CertificateType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class AllCertificateComponent extends Component
{
    use WithPagination;

    // Search and Filter Properties
    public $search = '';
    public $certificateTypeFilter = '';
    public $statusFilter = '';
    public $userFilter = '';

    // Sorting Properties
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Modal Properties
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $selectedCertificate = null;

    // Edit Form Properties
    public $editCertificateName = '';
    public $editCertificateNumber = '';
    public $editIssuingOrganization = '';
    public $editIssueDate = '';
    public $editExpirationDate = '';
    public $editIsCurrent = false;
    public $editNotes = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'certificateTypeFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'userFilter' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected $rules = [
        'editCertificateName' => 'required|string|max:255',
        'editCertificateNumber' => 'required|string|max:255',
        'editIssuingOrganization' => 'required|string|max:255',
        'editIssueDate' => 'required|date',
        'editExpirationDate' => 'nullable|date|after:editIssueDate',
        'editIsCurrent' => 'boolean',
        'editNotes' => 'nullable|string',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCertificateTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingUserFilter()
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
        $this->certificateTypeFilter = '';
        $this->statusFilter = '';
        $this->userFilter = '';
        $this->resetPage();
    }

    public function editCertificate($certificateId)
    {
        $this->selectedCertificate = DoctorCertificate::with(['user', 'certificateType'])->find($certificateId);
        
        if ($this->selectedCertificate) {
            $this->editCertificateName = $this->selectedCertificate->certificate_name;
            $this->editCertificateNumber = $this->selectedCertificate->certificate_number;
            $this->editIssuingOrganization = $this->selectedCertificate->issuing_organization;
            $this->editIssueDate = $this->selectedCertificate->issue_date?->format('Y-m-d');
            $this->editExpirationDate = $this->selectedCertificate->expiration_date?->format('Y-m-d');
            $this->editIsCurrent = $this->selectedCertificate->is_current;
            $this->editNotes = $this->selectedCertificate->notes;
            
            $this->showEditModal = true;
        }
    }

    public function updateCertificate()
    {
        $this->validate();

        $this->selectedCertificate->update([
            'certificate_name' => $this->editCertificateName,
            'certificate_number' => $this->editCertificateNumber,
            'issuing_organization' => $this->editIssuingOrganization,
            'issue_date' => $this->editIssueDate,
            'expiration_date' => $this->editExpirationDate,
            'is_current' => $this->editIsCurrent,
            'notes' => $this->editNotes,
        ]);

        $this->showEditModal = false;
        $this->selectedCertificate = null;

        session()->flash('message', 'Certificate updated successfully.');
    }

    public function confirmDelete($certificateId)
    {
        $this->selectedCertificate = DoctorCertificate::with(['user', 'certificateType'])->find($certificateId);
        $this->showDeleteModal = true;
    }

    public function deleteCertificate()
    {
        if ($this->selectedCertificate) {
            $this->selectedCertificate->delete();
            $this->showDeleteModal = false;
            $this->selectedCertificate = null;

            session()->flash('message', 'Certificate deleted successfully.');
        }
    }

    public function closeModal()
    {
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->selectedCertificate = null;
        $this->resetValidation();
    }

    public function render()
    {
        $certificates = DoctorCertificate::with(['user', 'certificateType'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhere('certificate_name', 'like', '%' . $this->search . '%')
                ->orWhere('certificate_number', 'like', '%' . $this->search . '%')
                ->orWhere('issuing_organization', 'like', '%' . $this->search . '%')
                ->orWhereHas('certificateType', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->certificateTypeFilter, function ($query) {
                $query->where('certificate_type_id', $this->certificateTypeFilter);
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'current') {
                    $query->where('is_current', true);
                } elseif ($this->statusFilter === 'expired') {
                    $query->where('is_current', false)
                          ->orWhere('expiration_date', '<', now());
                }
            })
            ->when($this->userFilter, function ($query) {
                $query->where('user_id', $this->userFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);

        $certificateTypes = CertificateType::where('is_active', true)->orderBy('name')->get();
        $users = User::whereHas('certificates')->orderBy('name')->get();

        return view('livewire.super-admin.certificate.all-certificate-component', [
            'certificates' => $certificates,
            'certificateTypes' => $certificateTypes,
            'users' => $users,
        ]);
    }
}
