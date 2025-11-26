<?php
namespace App\Livewire\Doctor;

use App\Enums\LicenseStatus;
use App\Enums\UserType;
use App\Models\DoctorLicense;
use App\Models\LicenseType;
use App\Models\State;
use App\Models\User;
use App\Notifications\LicenseNotification;
use App\Traits\HasToast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use PharIo\Manifest\License;

#[Title('Provider Licensing')]
#[Layout('layouts.dashboard')]
class ApplicationsComponent extends Component
{
    use WithPagination, HasToast, WithFileUploads;

    public $activeTab     = 'all';
    // Don't store licenses as public property to avoid serialization issues
    // Will be loaded in render() method instead
    public $perPage       = 10;
    public $sortField     = 'created_at';
    public $sortDirection = 'desc';
    public $search        = '';

    // Modal states
    public $showAddModal     = false;
    public $showRequestModal = false;
    public $showViewModal    = false;
    public $showEditModal    = false;
    public $showDeleteModal  = false;

    // Loading states for modals
    public $loadingAddModal     = false;
    public $loadingRequestModal = false;

    // Cached data
    protected $cachedLicenseTypes = null;
    protected $cachedStates       = null;

    // Selected license for view/edit/delete - store only ID to avoid serialization issues
    public $selectedLicenseId = null;
    public $deleteId        = null;

    // Add License Modal fields using addForm array
    public $addForm = [
        'license_type_id'   => '',
        'license_number'    => '',
        'state_id'          => '',
        'issue_date'        => '',
        'expiration_date'   => '',
        'issuing_authority' => '',
        'notes'             => '',
        'is_verified'       => false,
        'document'          => null,
    ];

    // Individual fields for backward compatibility
    public $selectedProvider    = '';
    public $selectedLicenseType = '';
    public $licenseNumber       = '';
    public $issueDate           = '';
    public $expiryDate          = '';

    // Request New License Modal fields using requestForm array
    public $requestForm = [
        'license_type_id' => '',
        'state_id'        => '',
        'reason'          => '',
        'urgent'          => false,
    ];

    // Individual fields for backward compatibility
    public $requestProvider    = '';
    public $requestLicenseType = '';

    // Edit License Modal fields using editForm array
    public $editForm = [
        'license_type_id'   => '',
        'state_id'          => '',
        'license_number'    => '',
        'issue_date'        => '',
        'expiration_date'   => '',
        'issuing_authority' => '',
        'notes'             => '',
        'is_verified'       => false,
        'urgent'            => false,
        'document'          => null,
    ];

    public function mount()
    {
        $this->selectedProvider = Auth::user()->name;
        // Don't load licenses here - will be loaded in render() to avoid serialization issues
    }

    public function dehydrate()
    {
        // CRITICAL: Clear ALL Collections before Livewire serializes to prevent method_exists() errors
        // This must happen before Livewire tries to serialize the component
        
        // Clear cached Collections (they will be reloaded when needed)
        if ($this->cachedLicenseTypes instanceof \Illuminate\Database\Eloquent\Collection) {
            $this->cachedLicenseTypes = null;
        }
        if ($this->cachedStates instanceof \Illuminate\Database\Eloquent\Collection) {
            $this->cachedStates = null;
        }
        
        // Ensure form arrays are always arrays (not Collections or objects)
        if (isset($this->addForm) && !is_array($this->addForm)) {
            $this->addForm = is_object($this->addForm) && method_exists($this->addForm, 'toArray') 
                ? $this->addForm->toArray() 
                : (array) $this->addForm;
        }
        
        if (isset($this->requestForm) && !is_array($this->requestForm)) {
            $this->requestForm = is_object($this->requestForm) && method_exists($this->requestForm, 'toArray') 
                ? $this->requestForm->toArray() 
                : (array) $this->requestForm;
        }
        
        if (isset($this->editForm) && !is_array($this->editForm)) {
            $this->editForm = is_object($this->editForm) && method_exists($this->editForm, 'toArray') 
                ? $this->editForm->toArray() 
                : (array) $this->editForm;
        }
    }

    public function hydrate()
    {
        // Ensure form arrays are always arrays (not Collections or objects)
        if (isset($this->addForm) && !is_array($this->addForm)) {
            $this->addForm = is_object($this->addForm) && method_exists($this->addForm, 'toArray') 
                ? $this->addForm->toArray() 
                : (array) $this->addForm;
        }
        
        if (isset($this->requestForm) && !is_array($this->requestForm)) {
            $this->requestForm = is_object($this->requestForm) && method_exists($this->requestForm, 'toArray') 
                ? $this->requestForm->toArray() 
                : (array) $this->requestForm;
        }
        
        if (isset($this->editForm) && !is_array($this->editForm)) {
            $this->editForm = is_object($this->editForm) && method_exists($this->editForm, 'toArray') 
                ? $this->editForm->toArray() 
                : (array) $this->editForm;
        }
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatedActiveTab()
    {
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
            $this->sortField     = $field;
            $this->sortDirection = 'asc';
        }
    }

    protected function getLicenses()
    {
        $user   = Auth::user();
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
        if (! empty($this->search)) {
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

        // Return Collection - will be used only in render(), not stored as property
        return $query->get();
    }

    public function exportCsv()
    {
        $user   = Auth::user();
        $userId = $user->id;

        $query = DoctorLicense::with(['licenseType', 'state'])
            ->where('user_id', $userId);

        // Filter by status tab (same as loadLicenses)
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
        if (! empty($this->search)) {
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

        // Get all licenses (no pagination for export)
        $licenses = $query->orderBy('created_at', 'desc')->get();

        // Generate CSV
        $csv = collect([
            ['License Number', 'License Type', 'State', 'Issue Date', 'Expiration Date', 'Status', 'Issuing Authority', 'Notes', 'Created At'],
            ...$licenses->map(function ($license) {
                return [
                    $license->license_number ?? '',
                    $license->licenseType->name ?? 'N/A',
                    $license->state->name ?? 'N/A',
                    $license->issue_date ? $license->issue_date->format('Y-m-d') : '',
                    $license->expiration_date ? $license->expiration_date->format('Y-m-d') : '',
                    $license->status ? ($license->status instanceof \App\Enums\LicenseStatus ? $license->status->label() : (string)$license->status) : 'N/A',
                    $license->issuing_authority ?? '',
                    $license->notes ?? '',
                    $license->created_at ? $license->created_at->format('Y-m-d H:i:s') : '',
                ];
            })
        ])->map(function ($row) {
            return implode(',', array_map(function ($v) {
                return '"' . str_replace('"', '""', (string)$v) . '"';
            }, $row));
        })->implode("\r\n");

        $filename = 'licenses_' . strtolower($this->activeTab) . '_' . now()->format('Y-m-d_H-i-s') . '.csv';

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    // Modal methods
    public function openAddModal()
    {
        $this->loadingAddModal = true;
        $this->showAddModal    = true;
        $this->resetAddForm();

        // Simulate loading delay for better UX
        $this->loadingAddModal = false;
    }

    public function closeAddModal()
    {
        $this->showAddModal = false;
        $this->resetAddForm();
    }

    public function resetAddForm()
    {
        $this->selectedProvider = Auth::user()->name;
        $this->addForm          = [
            'license_type_id'   => '',
            'license_number'    => '',
            'state_id'          => '',
            'issue_date'        => '',
            'expiration_date'   => '',
            'issuing_authority' => '',
            'notes'             => '',
            'is_verified'       => false,
            'document'          => null,
        ];
        // Reset individual fields for backward compatibility
        $this->selectedLicenseType = '';
        $this->licenseNumber       = '';
        $this->issueDate           = '';
        $this->expiryDate          = '';
    }

    public function openRequestModal()
    {
        $this->loadingRequestModal = true;
        $this->showRequestModal    = true;
        $this->resetRequestForm();

        // Simulate loading delay for better UX
        $this->loadingRequestModal = false;
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
            'state_id'        => '',
            'reason'          => '',
            'urgent'          => false,
        ];

        // Keep backward compatibility
        $this->requestProvider    = '';
        $this->requestLicenseType = '';
    }

    public function saveLicense()
    {
        $this->validate([
            'addForm.license_type_id' => 'required',
            'addForm.license_number'  => 'required|string|max:255',
            'addForm.issue_date'      => 'required|date',
            'addForm.expiration_date' => 'required|date|after:addForm.issue_date',
            'addForm.document'        => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:10240', // 10MB max
        ]);

        try {
            // Log the data being saved for debugging
            Log::info('Attempting to save license with data:', [
                'user_id'           => Auth::id(),
                'license_type_id'   => $this->addForm['license_type_id'],
                'license_number'    => $this->addForm['license_number'],
                'issue_date'        => $this->addForm['issue_date'],
                'expiration_date'   => $this->addForm['expiration_date'],
                'issuing_authority' => $this->addForm['issuing_authority'] ?? null,
                'notes'             => $this->addForm['notes'] ?? null,
                'status'            => LicenseStatus::ACTIVE,
                'is_verified'       => $this->addForm['is_verified'] ?? false,
                'has_document'      => $this->addForm['document'] ? true : false,
            ]);

            // Handle document upload first to get the file path
            $documentPath = null;
            if ($this->addForm['document']) {
                $documentPath = $this->handleDocumentUpload('add');
            }

            $license = DoctorLicense::create([
                'user_id'           => Auth::id(),
                'state_id'          => $this->addForm['state_id'],
                'license_type_id'   => $this->addForm['license_type_id'],
                'license_number'    => $this->addForm['license_number'],
                'issue_date'        => $this->addForm['issue_date'],
                'expiration_date'   => $this->addForm['expiration_date'],
                'issuing_authority' => $this->addForm['issuing_authority'] ?? null,
                'notes'             => $this->addForm['notes'] ?? null,
                'status'            => LicenseStatus::ACTIVE,
                'is_verified'       => $this->addForm['is_verified'] ?? false,
                'document'           => $documentPath,
            ]);

            // Log successful creation
            Log::info('License created successfully with ID: ' . $license->id);

            // Send notification to admins
            $this->notifyAdminsAboutLicense($license, 'added');

            $this->toastSuccess('License added successfully!');
            $this->closeAddModal();
        } catch (\Exception $e) {
            Log::error('Error saving license: ' . $e->getMessage(), [
                'trace'     => $e->getTraceAsString(),
                'form_data' => $this->addForm,
            ]);
            $this->toastError('Error adding license: ' . $e->getMessage());
        }
    }

    public function submitRequest()
    {
        $this->validate([
            'requestForm.license_type_id' => 'required',
            'requestForm.state_id'        => 'required',
        ]);

        try {
            // Create a pending license request with new fields
            $license = DoctorLicense::create([
                'user_id'         => Auth::id(),
                'license_type_id' => $this->requestForm['license_type_id'],
                'state_id'        => $this->requestForm['state_id'],
                'status'          => LicenseStatus::REQUESTED,
                'is_verified'     => false,
            ]);

            // Send notification to admins
            $this->notifyAdminsAboutLicense($license, 'requested');

            $this->toastSuccess('License request submitted successfully!');
            $this->closeRequestModal();
        } catch (\Exception $e) {
            Log::error('Error submitting license request: ' . $e->getMessage(), [
                'trace'     => $e->getTraceAsString(),
                'form_data' => $this->requestForm,
            ]);
            $this->toastError('Error submitting request: ' . $e->getMessage());
        }
    }

    /**
     * Handle document upload for license
     */
    private function handleDocumentUpload($formType = 'add')
    {
        try {
            $file = $formType === 'add' ? $this->addForm['document'] : $this->editForm['document'];
            
            // Generate unique filename
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = 'license_' . time() . '_' . uniqid() . '.' . $extension;
            
            // Store file in doctor-documents directory
            $path = $file->storeAs('doctor-documents', $filename, 'public');
            
            Log::info('Document uploaded successfully', [
                'original_name' => $originalName,
                'stored_path' => $path,
                'file_size' => $file->getSize(),
                'form_type' => $formType,
            ]);
            
            return $path;
            
        } catch (\Exception $e) {
            Log::error('Error uploading document: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'form_type' => $formType,
            ]);
            throw $e;
        }
    }
    

    /**
     * Notify admins about license actions
     */
    private function notifyAdminsAboutLicense($license, $action)
    {
        try {
            $doctor = Auth::user();

            // Prepare notification data
            $actionText = $action === 'added' ? 'added a new license' : 'requested a new license';
            $notificationData = [
                'title' => 'New License ' . ucfirst($action),
                'message' => "Dr. {$doctor->name} has {$actionText}",
                'type' => $action === 'added' ? 'success' : 'info',
                'license_id' => $license->id,
                'doctor_id' => $doctor->id,
                'action' => $action,
                'license_type' => $license->licenseType->name ?? 'Unknown',
                'license_number' => $license->license_number,
                'url' => '/admin/licenses/' . $license->id,
                'read' => null,
                'created_at' => Carbon::now(),
            ];

            // Create notification using the LicenseNotification class
            $admin = User::where('user_type',UserType::SUPER_ADMIN)->first();// Get admin user
            $admin->notify(new LicenseNotification($notificationData));
            $doctor->notify(new LicenseNotification($notificationData));
            // Dispatch real-time notification event
            $this->dispatch('notification-added', [
                'id'      => \Illuminate\Support\Str::uuid(),
                'title'   => 'New License ' . ucfirst($action),
                'message' => "Dr. {$doctor->name} has " . ($action === 'added' ? 'added a new license' : 'requested a new license'),
                'type'    => $action === 'added' ? 'success' : 'info',
                'url'     => '/admin/licenses/' . $license->id,
                'read'    => false,
                'created_at' => now()->diffForHumans(),
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending license notification: ' . $e->getMessage());
        }
    }

    // View License Modal Methods
    public function viewLicense($licenseId)
    {
        $this->selectedLicenseId = $licenseId;
        $this->showViewModal   = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal   = false;
        $this->selectedLicenseId = null;
    }

    // Edit License Modal Methods
    public function editLicense($licenseId)
    {
        $license = DoctorLicense::with(['licenseType', 'state'])->find($licenseId);

        if ($license) {
            $this->selectedLicenseId = $licenseId;
            $this->editForm        = [
                'license_type_id'   => $license->license_type_id,
                'state_id'          => $license->state_id,
                'license_number'    => $license->license_number ?? '',
                'issue_date'        => $license->issue_date ? $license->issue_date->format('Y-m-d') : '',
                'expiration_date'   => $license->expiration_date ? $license->expiration_date->format('Y-m-d') : '',
                'issuing_authority' => $license->issuing_authority ?? '',
                'notes'             => $license->notes ?? '',
                'is_verified'       => $license->is_verified ?? false,
                'urgent'            => $license->urgent ?? false,
            ];
            $this->showEditModal = true;
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal   = false;
        $this->selectedLicenseId = null;
        $this->resetEditForm();
    }

    public function resetEditForm()
    {
        $this->editForm = [
            'license_type_id'   => '',
            'state_id'          => '',
            'license_number'    => '',
            'issue_date'        => '',
            'expiration_date'   => '',
            'issuing_authority' => '',
            'notes'             => '',
            'is_verified'       => false,
            'urgent'            => false,
            'document'          => null,
        ];
    }

    public function updateLicense()
    {
        try {
            $this->validate([
                'editForm.license_type_id'   => 'required|exists:license_types,id',
                'editForm.state_id'          => 'required|exists:states,id',
                'editForm.license_number'    => 'nullable|string|max:255',
                'editForm.issue_date'        => 'nullable|date',
                'editForm.expiration_date'   => 'nullable|date|after:editForm.issue_date',
                'editForm.issuing_authority' => 'nullable|string|max:255',
                'editForm.notes'             => 'nullable|string',
                'editForm.is_verified'       => 'boolean',
                'editForm.urgent'            => 'boolean',
                'editForm.document'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:10240', // 10MB max
            ]);

            // Load license by ID
            $license = DoctorLicense::findOrFail($this->selectedLicenseId);
            
            // Handle document upload if provided
            $documentPath = $license->document; // Keep current document by default
            if ($this->editForm['document']) {
                // Delete old document if it exists
                if ($license->document && \Illuminate\Support\Facades\Storage::disk('public')->exists($license->document)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($license->document);
                }
                
                // Upload new document
                $documentPath = $this->handleDocumentUpload('edit');
            }

            $license->update([
                'license_type_id'   => $this->editForm['license_type_id'],
                'state_id'          => $this->editForm['state_id'],
                'license_number'    => $this->editForm['license_number'],
                'issue_date'        => $this->editForm['issue_date'] ? Carbon::parse($this->editForm['issue_date']) : null,
                'expiration_date'   => $this->editForm['expiration_date'] ? Carbon::parse($this->editForm['expiration_date']) : null,
                'issuing_authority' => $this->editForm['issuing_authority'],
                'notes'             => $this->editForm['notes'],
                'is_verified'       => $this->editForm['is_verified'],
                'urgent'            => $this->editForm['urgent'],
                'document'          => $documentPath,
            ]);

            $this->toastSuccess('License updated successfully!');
            $this->closeEditModal();
        } catch (\Exception $e) {
            Log::error('Error updating license: ' . $e->getMessage(), [
                'trace'      => $e->getTraceAsString(),
                'license_id' => $this->selectedLicenseId,
                'form_data'  => $this->editForm,
            ]);
            $this->toastError('Error updating license: ' . $e->getMessage());
        }
    }

    // Delete License Methods
    public function delete($licenseId)
    {
        $this->deleteId        = $licenseId;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        try {
            $license = DoctorLicense::findOrFail($this->deleteId);
            $license->delete();

            $this->toastSuccess('License deleted successfully!');
            $this->cancelDelete();
        } catch (\Exception $e) {
            Log::error('Error deleting license: ' . $e->getMessage(), [
                'trace'      => $e->getTraceAsString(),
                'license_id' => $this->deleteId,
            ]);
            $this->toastError('Error deleting license: ' . $e->getMessage());
        }
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->deleteId        = null;
    }

    protected function getLicenseTypes()
    {
        if ($this->cachedLicenseTypes === null) {
            $this->cachedLicenseTypes = LicenseType::all();
        }
        return $this->cachedLicenseTypes;
    }

    protected function getStates()
    {
        if ($this->cachedStates === null) {
            $this->cachedStates = State::all();
        }
        return $this->cachedStates;
    }

    public function render()
    {
        $licenseCounts = $this->getLicenseCounts();

        // Only load license types and states when needed (not on initial page load)
        $licenseTypes = collect();
        $states       = collect();

        // Load data if modals are open
        if ($this->showAddModal || $this->showRequestModal || $this->showEditModal) {
            $licenseTypes = $this->getLicenseTypes();
            $states       = $this->getStates();
        }

        // Load licenses in render() - never store as property to avoid serialization issues
        $licenses = $this->getLicenses();

        // Load selected license if needed (for modals) - don't store as property
        $selectedLicense = null;
        if ($this->selectedLicenseId) {
            $selectedLicense = DoctorLicense::with(['licenseType', 'state'])->find($this->selectedLicenseId);
        }

        return view('livewire.doctor.applications-component', [
            'licenseCounts' => $licenseCounts,
            'licenseTypes'  => $licenseTypes,
            'states'        => $states,
            'licenses'      => $licenses,
            'selectedLicense' => $selectedLicense,
        ]);
    }

    private function getLicenseCounts()
    {
        $user   = Auth::user();
        $userId = $user->id;

        $allLicenses      = DoctorLicense::where('user_id', $userId)->count();
        $activeLicenses   = DoctorLicense::where('user_id', $userId)->where('status', LicenseStatus::ACTIVE)->count();
        $expiredLicenses  = DoctorLicense::where('user_id', $userId)->where('expiration_date', '<', now())->count();
        $expiringLicenses = DoctorLicense::where('user_id', $userId)
            ->where('expiration_date', '>', now())
            ->where('expiration_date', '<=', now()->addDays(30))
            ->count();
        $pendingLicenses = DoctorLicense::where('user_id', $userId)->where('status', LicenseStatus::PENDING)->count();

        return [
            'all'      => $allLicenses,
            'active'   => $activeLicenses,
            'expired'  => $expiredLicenses,
            'expiring' => $expiringLicenses,
            'pending'  => $pendingLicenses,
        ];
    }
}
