<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use App\Models\DoctorLicense;
use App\Models\LicenseType;
use App\Models\State;
use App\Enums\LicenseStatus;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasToast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

#[Title('Provider Licensing')]
#[Layout('layouts.dashboard')]
class ApplicationsComponent extends Component
{
    use WithPagination, HasToast;

    public $activeTab = 'all';
    public $licenses = [];
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $search = '';

    // Modal states
    public $showAddModal = false;
    public $showRequestModal = false;
    public $showViewModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    // Selected license for view/edit/delete
    public $selectedLicense = null;
    public $deleteId = null;

    // Add License Modal fields using addForm array
    public $addForm = [
        'license_type_id' => '',
        'license_number' => '',
        'state_id' => '',
        'issue_date' => '',
        'expiration_date' => '',
        'issuing_authority' => '',
        'notes' => '',
        'is_verified' => false,
    ];

    // Individual fields for backward compatibility
    public $selectedProvider = '';
    public $selectedLicenseType = '';
    public $licenseNumber = '';
    public $issueDate = '';
    public $expiryDate = '';

    // Request New License Modal fields using requestForm array
    public $requestForm = [
        'license_type_id' => '',
        'state_id' => '',
        'reason' => '',
        'urgent' => false,
    ];

    // Individual fields for backward compatibility
    public $requestProvider = '';
    public $requestLicenseType = '';

    // Edit License Modal fields using editForm array
    public $editForm = [
        'license_type_id' => '',
        'state_id' => '',
        'license_number' => '',
        'issue_date' => '',
        'expiration_date' => '',
        'issuing_authority' => '',
        'notes' => '',
        'is_verified' => false,
        'urgent' => false,
    ];

    public function mount()
    {
        $this->selectedProvider =Auth::user()->name;
        $this->loadLicenses();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->loadLicenses();
    }

    public function updatedActiveTab()
    {
        $this->resetPage();
        $this->loadLicenses();
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->loadLicenses();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->loadLicenses();
    }

    public function loadLicenses()
    {
        $user = Auth::user();
        $userId = $user->id;

        $query = DoctorLicense::with(['licenseType', 'state'])
            ->where('user_id', $userId);

        // Filter by status tab
        switch ($this->activeTab) {
            case 'active':
                $query->where('status', LicenseStatus::ACTIVE);
                break;
            case 'expired':
                $query->where('expiration_date', '<', now());
                break;
            case 'expiring':
                $query->where('expiration_date', '>', now())
                      ->where('expiration_date', '<=', now()->addDays(30));
                break;
            case 'pending':
                $query->where('status', LicenseStatus::PENDING);
                break;
            default:
                // 'all' - no additional filter
                break;
        }

        // Search functionality
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('license_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('licenseType', function ($typeQuery) {
                      $typeQuery->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('state', function ($stateQuery) {
                      $stateQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Sorting
        if ($this->sortField === 'license_type') {
            $query->join('license_types', 'doctor_licenses.license_type_id', '=', 'license_types.id')
                  ->orderBy('license_types.name', $this->sortDirection)
                  ->select('doctor_licenses.*');
        } elseif ($this->sortField === 'state') {
            $query->join('states', 'doctor_licenses.state_id', '=', 'states.id')
                  ->orderBy('states.name', $this->sortDirection)
                  ->select('doctor_licenses.*');
        } else {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        $this->licenses = $query->get();
    }

    // Modal methods
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
        $this->selectedProvider = Auth::user()->name;
        $this->addForm = [
            'license_type_id' => '',
            'license_number' => '',
            'state_id' => '',
            'issue_date' => '',
            'expiration_date' => '',
            'issuing_authority' => '',
            'notes' => '',
            'is_verified' => false,
        ];
        // Reset individual fields for backward compatibility
        $this->selectedLicenseType = '';
        $this->licenseNumber = '';
        $this->issueDate = '';
        $this->expiryDate = '';
    }

    public function openRequestModal()
    {
        $this->showRequestModal = true;
        $this->resetRequestForm();
    }

    public function closeRequestModal()
    {
        $this->showRequestModal = false;
        $this->resetRequestForm();
    }

    public function resetRequestForm()
    {
        $this->requestForm = [
            'license_type_id' => '',
            'state_id' => '',
            'reason' => '',
            'urgent' => false,
        ];
        
        // Keep backward compatibility
        $this->requestProvider = '';
        $this->requestLicenseType = '';
    }

    public function saveLicense()
    {
        $this->validate([
            'addForm.license_type_id' => 'required',
            'addForm.license_number' => 'required|string|max:255',
            'addForm.issue_date' => 'required|date',
            'addForm.expiration_date' => 'required|date|after:addForm.issue_date',
        ]);

        try {
            // Log the data being saved for debugging
            Log::info('Attempting to save license with data:', [
                'user_id' => Auth::id(),
                'license_type_id' => $this->addForm['license_type_id'],
                'license_number' => $this->addForm['license_number'],
                'issue_date' => $this->addForm['issue_date'],
                'expiration_date' => $this->addForm['expiration_date'],
                'issuing_authority' => $this->addForm['issuing_authority'] ?? null,
                'notes' => $this->addForm['notes'] ?? null,
                'status' => LicenseStatus::ACTIVE,
                'is_verified' => $this->addForm['is_verified'] ?? false,
            ]);

            $license = DoctorLicense::create([
                'user_id' => Auth::id(),
                'state_id' => $this->addForm['state_id'],
                'license_type_id' => $this->addForm['license_type_id'],
                'license_number' => $this->addForm['license_number'],
                'issue_date' => $this->addForm['issue_date'],
                'expiration_date' => $this->addForm['expiration_date'],
                'issuing_authority' => $this->addForm['issuing_authority'] ?? null,
                'notes' => $this->addForm['notes'] ?? null,
                'status' => LicenseStatus::ACTIVE,
                'is_verified' => $this->addForm['is_verified'] ?? false,
            ]);

            // Log successful creation
            Log::info('License created successfully with ID: ' . $license->id);

            $this->toastSuccess('License added successfully!');
            $this->closeAddModal();
            $this->loadLicenses();
        } catch (\Exception $e) {
            Log::error('Error saving license: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'form_data' => $this->addForm
            ]);
            $this->toastError('Error adding license: ' . $e->getMessage());
        }
    }

    public function submitRequest()
    {
        $this->validate([
            'requestForm.license_type_id' => 'required',
            'requestForm.state_id' => 'required',
        ]);

        try {
            // Create a pending license request with new fields
           $license= DoctorLicense::create([
                'user_id' => Auth::id(),
                'license_type_id' => $this->requestForm['license_type_id'],
                'state_id' => $this->requestForm['state_id'],
                'status' => LicenseStatus::REQUESTED,
                'is_verified' => false,
            ]);

            $this->toastSuccess('License request submitted successfully!');
            $this->closeRequestModal();
            $this->loadLicenses();
        } catch (\Exception $e) {
            Log::error('Error submitting license request: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'form_data' => $this->requestForm
            ]);
            $this->toastError('Error submitting request: ' . $e->getMessage());
        }
    }

    // View License Modal Methods
    public function viewLicense($licenseId)
    {
        $this->selectedLicense = DoctorLicense::with(['licenseType', 'state'])->find($licenseId);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedLicense = null;
    }

    // Edit License Modal Methods
    public function editLicense($licenseId)
    {
        $license = DoctorLicense::with(['licenseType', 'state'])->find($licenseId);
        
        if ($license) {
            $this->selectedLicense = $license;
            $this->editForm = [
                'license_type_id' => $license->license_type_id,
                'state_id' => $license->state_id,
                'license_number' => $license->license_number ?? '',
                'issue_date' => $license->issue_date ? $license->issue_date->format('Y-m-d') : '',
                'expiration_date' => $license->expiration_date ? $license->expiration_date->format('Y-m-d') : '',
                'issuing_authority' => $license->issuing_authority ?? '',
                'notes' => $license->notes ?? '',
                'is_verified' => $license->is_verified ?? false,
                'urgent' => $license->urgent ?? false,
            ];
            $this->showEditModal = true;
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->selectedLicense = null;
        $this->resetEditForm();
    }

    public function resetEditForm()
    {
        $this->editForm = [
            'license_type_id' => '',
            'state_id' => '',
            'license_number' => '',
            'issue_date' => '',
            'expiration_date' => '',
            'issuing_authority' => '',
            'notes' => '',
            'is_verified' => false,
            'urgent' => false,
        ];
    }

    public function updateLicense()
    {
        try {
            $this->validate([
                'editForm.license_type_id' => 'required|exists:license_types,id',
                'editForm.state_id' => 'required|exists:states,id',
                'editForm.license_number' => 'nullable|string|max:255',
                'editForm.issue_date' => 'nullable|date',
                'editForm.expiration_date' => 'nullable|date|after:editForm.issue_date',
                'editForm.issuing_authority' => 'nullable|string|max:255',
                'editForm.notes' => 'nullable|string',
                'editForm.is_verified' => 'boolean',
                'editForm.urgent' => 'boolean',
            ]);

            $this->selectedLicense->update([
                'license_type_id' => $this->editForm['license_type_id'],
                'state_id' => $this->editForm['state_id'],
                'license_number' => $this->editForm['license_number'],
                'issue_date' => $this->editForm['issue_date'] ? Carbon::parse($this->editForm['issue_date']) : null,
                'expiration_date' => $this->editForm['expiration_date'] ? Carbon::parse($this->editForm['expiration_date']) : null,
                'issuing_authority' => $this->editForm['issuing_authority'],
                'notes' => $this->editForm['notes'],
                'is_verified' => $this->editForm['is_verified'],
                'urgent' => $this->editForm['urgent'],
            ]);

            $this->toastSuccess('License updated successfully!');
            $this->closeEditModal();
            $this->loadLicenses();
        } catch (\Exception $e) {
            Log::error('Error updating license: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'license_id' => $this->selectedLicense->id,
                'form_data' => $this->editForm
            ]);
            $this->toastError('Error updating license: ' . $e->getMessage());
        }
    }

    // Delete License Methods
    public function delete($licenseId)
    {
        $this->deleteId = $licenseId;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        try {
            $license = DoctorLicense::findOrFail($this->deleteId);
            $license->delete();
            
            $this->toastSuccess('License deleted successfully!');
            $this->cancelDelete();
            $this->loadLicenses();
        } catch (\Exception $e) {
            Log::error('Error deleting license: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'license_id' => $this->deleteId
            ]);
            $this->toastError('Error deleting license: ' . $e->getMessage());
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $licenseCounts = $this->getLicenseCounts();
        $licenseTypes = LicenseType::all();
        $states = State::all();

        return view('livewire.doctor.applications-component', [
            'licenseCounts' => $licenseCounts,
            'licenseTypes' => $licenseTypes,
            'states' => $states,
        ]);
    }

    private function getLicenseCounts()
    {
        $user = Auth::user();
        $userId = $user->id;

        $allLicenses = DoctorLicense::where('user_id', $userId)->count();
        $activeLicenses = DoctorLicense::where('user_id', $userId)->where('status', LicenseStatus::ACTIVE)->count();
        $expiredLicenses = DoctorLicense::where('user_id', $userId)->where('expiration_date', '<', now())->count();
        $expiringLicenses = DoctorLicense::where('user_id', $userId)
            ->where('expiration_date', '>', now())
            ->where('expiration_date', '<=', now()->addDays(30))
            ->count();
        $pendingLicenses = DoctorLicense::where('user_id', $userId)->where('status', LicenseStatus::PENDING)->count();

        return [
            'all' => $allLicenses,
            'active' => $activeLicenses,
            'expired' => $expiredLicenses,
            'expiring' => $expiringLicenses,
            'pending' => $pendingLicenses,
        ];
    }
}
