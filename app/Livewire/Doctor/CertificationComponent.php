<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\DoctorCertificate;
use App\Models\CertificateType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasToast;
use Livewire\WithPagination;

#[Title('Provider Certifications')]
#[Layout('layouts.dashboard')]
class CertificationComponent extends Component
{
    use WithPagination, HasToast;

    public $activeTab = 'all';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $search = '';

    // Modal states
    public $showAddModal = false;
    public $showEditModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;

    // Selected certificate for view/edit/delete
    public $selectedCertificate = null;
    public $deleteId = null;

    // Add Certificate Modal fields
    public $addForm = [
        'certificate_type_id' => '',
        'certificate_name' => '',
        'certificate_number' => '',
        'issuing_organization' => '',
        'issue_date' => '',
        'expiration_date' => '',
        'is_current' => true,
        'notes' => '',
    ];

    // Edit Certificate Modal fields
    public $editForm = [
        'certificate_type_id' => '',
        'certificate_name' => '',
        'certificate_number' => '',
        'issuing_organization' => '',
        'issue_date' => '',
        'expiration_date' => '',
        'is_current' => true,
        'notes' => '',
    ];

    public function mount()
    {
        // No need to load certificates here as we use a computed property
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
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

    public function getCertificatesProperty()
    {
        $user = Auth::user();
        $userId = $user->id;

        $query = DoctorCertificate::where('user_id', $userId)
            ->with(['certificateType']);

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('certificate_name', 'like', '%' . $this->search . '%')
                  ->orWhere('certificate_number', 'like', '%' . $this->search . '%')
                  ->orWhere('issuing_organization', 'like', '%' . $this->search . '%');
            });
        }

        // Apply tab filter
        switch ($this->activeTab) {
            case 'current':
                $query->where('is_current', true);
                break;
            case 'expired':
                $query->where('is_current', false)
                      ->where('expiration_date', '<', now());
                break;
            case 'expiring':
                $query->where('is_current', true)
                      ->where('expiration_date', '<=', now()->addDays(30))
                      ->where('expiration_date', '>', now());
                break;
            default:
                // 'all' - no additional filter
                break;
        }

        return $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function openAddModal()
    {
        $this->showAddModal = true;
        $this->resetAddForm();
    }

    public function closeAddModal()
    {
        $this->showAddModal = false;
        $this->resetAddForm();
    }

    public function resetAddForm()
    {
        $this->addForm = [
            'certificate_type_id' => '',
            'certificate_name' => '',
            'certificate_number' => '',
            'issuing_organization' => '',
            'issue_date' => '',
            'expiration_date' => '',
            'is_current' => true,
            'notes' => '',
        ];
    }

    public function saveCertificate()
    {
        $this->validate([
            'addForm.certificate_type_id' => 'required|exists:certificate_types,id',
            'addForm.certificate_name' => 'required|string|max:255',
            'addForm.certificate_number' => 'required|string|max:255',
            'addForm.issuing_organization' => 'required|string|max:255',
            'addForm.issue_date' => 'required|date',
            'addForm.expiration_date' => 'nullable|date|after:addForm.issue_date',
            'addForm.is_current' => 'boolean',
            'addForm.notes' => 'nullable|string',
        ]);

        try {
            DoctorCertificate::create([
                'user_id' => Auth::id(),
                'certificate_type_id' => $this->addForm['certificate_type_id'],
                'certificate_name' => $this->addForm['certificate_name'],
                'certificate_number' => $this->addForm['certificate_number'],
                'issuing_organization' => $this->addForm['issuing_organization'],
                'issue_date' => $this->addForm['issue_date'],
                'expiration_date' => $this->addForm['expiration_date'],
                'is_current' => $this->addForm['is_current'],
                'notes' => $this->addForm['notes'],
            ]);

            $this->toastSuccess('Certificate added successfully!');
            $this->closeAddModal();
        } catch (\Exception $e) {
            $this->toastError('Error adding certificate: ' . $e->getMessage());
        }
    }

    public function viewCertificate($certificateId)
    {
        $this->selectedCertificate = DoctorCertificate::with(['certificateType'])->find($certificateId);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedCertificate = null;
    }

    public function editCertificate($certificateId)
    {
        $certificate = DoctorCertificate::with(['certificateType'])->find($certificateId);

        if ($certificate) {
            $this->selectedCertificate = $certificate;
            $this->editForm = [
                'certificate_type_id' => $certificate->certificate_type_id,
                'certificate_name' => $certificate->certificate_name,
                'certificate_number' => $certificate->certificate_number,
                'issuing_organization' => $certificate->issuing_organization,
                'issue_date' => $certificate->issue_date ? $certificate->issue_date->format('Y-m-d') : '',
                'expiration_date' => $certificate->expiration_date ? $certificate->expiration_date->format('Y-m-d') : '',
                'is_current' => $certificate->is_current,
                'notes' => $certificate->notes,
            ];
            $this->showEditModal = true;
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->selectedCertificate = null;
        $this->resetEditForm();
    }

    public function resetEditForm()
    {
        $this->editForm = [
            'certificate_type_id' => '',
            'certificate_name' => '',
            'certificate_number' => '',
            'issuing_organization' => '',
            'issue_date' => '',
            'expiration_date' => '',
            'is_current' => true,
            'notes' => '',
        ];
    }

    public function updateCertificate()
    {
        $this->validate([
            'editForm.certificate_type_id' => 'required|exists:certificate_types,id',
            'editForm.certificate_name' => 'required|string|max:255',
            'editForm.certificate_number' => 'required|string|max:255',
            'editForm.issuing_organization' => 'required|string|max:255',
            'editForm.issue_date' => 'required|date',
            'editForm.expiration_date' => 'nullable|date|after:editForm.issue_date',
            'editForm.is_current' => 'boolean',
            'editForm.notes' => 'nullable|string',
        ]);

        try {
            $this->selectedCertificate->update([
                'certificate_type_id' => $this->editForm['certificate_type_id'],
                'certificate_name' => $this->editForm['certificate_name'],
                'certificate_number' => $this->editForm['certificate_number'],
                'issuing_organization' => $this->editForm['issuing_organization'],
                'issue_date' => $this->editForm['issue_date'],
                'expiration_date' => $this->editForm['expiration_date'],
                'is_current' => $this->editForm['is_current'],
                'notes' => $this->editForm['notes'],
            ]);

            $this->toastSuccess('Certificate updated successfully!');
            $this->closeEditModal();
        } catch (\Exception $e) {
            $this->toastError('Error updating certificate: ' . $e->getMessage());
        }
    }

    public function delete($certificateId)
    {
        $this->deleteId = $certificateId;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        try {
            $certificate = DoctorCertificate::findOrFail($this->deleteId);
            $certificate->delete();

            $this->toastSuccess('Certificate deleted successfully!');
            $this->cancelDelete();
        } catch (\Exception $e) {
            $this->toastError('Error deleting certificate: ' . $e->getMessage());
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function getCertificateCounts()
    {
        $userId = Auth::id();
        
        return [
            'all' => DoctorCertificate::where('user_id', $userId)->count(),
            'current' => DoctorCertificate::where('user_id', $userId)->where('is_current', true)->count(),
            'expired' => DoctorCertificate::where('user_id', $userId)->where('is_current', false)->where('expiration_date', '<', now())->count(),
            'expiring' => DoctorCertificate::where('user_id', $userId)->where('is_current', true)->where('expiration_date', '<=', now()->addDays(30))->where('expiration_date', '>', now())->count(),
        ];
    }

    public function render()
    {
        $certificateCounts = $this->getCertificateCounts();
        $certificateTypes = CertificateType::where('is_active', true)->orderBy('name')->get();

        return view('livewire.doctor.certification-component', [
            'certificateCounts' => $certificateCounts,
            'certificateTypes' => $certificateTypes,
        ]);
    }
}
