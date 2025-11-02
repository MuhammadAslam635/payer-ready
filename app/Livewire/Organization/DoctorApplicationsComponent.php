<?php

namespace App\Livewire\Organization;

use App\Enums\LicenseStatus;
use App\Models\DoctorLicense;
use App\Models\LicenseType;
use App\Models\State;
use App\Models\User;
use App\Notifications\LicenseNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Title('Doctor Applications')]
#[Layout('layouts.dashboard')]
class DoctorApplicationsComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $activeTab = 'all';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $search = '';

    // Do NOT store paginators in public properties (Livewire limitation)
    public $doctors = [];
    public $licenseTypes = [];
    public $states = [];

    // Modal state
    public $showAddModal = false;
    public $showDeleteModal = false;
    public $deleteId = null;
    public $showRequestModal = false;
    public $showViewModal = false;
    public $showEditModal = false;
    public $selectedLicenseId = null;
    public $selectedLicenseData = [];

    // Add form
    public $addForm = [
        'user_id' => '',
        'license_type_id' => '',
        'license_number' => '',
        'state_id' => '',
        'issue_date' => '',
        'expiration_date' => '',
        'issuing_authority' => '',
        'notes' => '',
        'document' => null,
    ];

    // Request form
    public $requestForm = [
        'user_id' => '',
        'license_type_id' => '',
        'state_id' => '',
        'reason' => '',
        'urgent' => false,
    ];

    // Edit form
    public $editForm = [
        'license_type_id' => '',
        'state_id' => '',
        'license_number' => '',
        'issue_date' => '',
        'expiration_date' => '',
        'issuing_authority' => '',
        'notes' => '',
        'document' => null,
        'status' => '',
    ];

    public function mount()
    {
        $this->doctors = User::where('org_id', Auth::id())
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->orderBy('name')
            ->get(['id','name','email']);
        $this->licenseTypes = LicenseType::orderBy('name')->get(['id','name']);
        $this->states = State::orderBy('name')->get(['id','name']);
        // No eager load here; computed in render
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        // Re-compute in render
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        // Re-compute in render
    }

    public function updatedSearch()
    {
        $this->resetPage();
        $this->loadLicenses();
    }

    public function loadLicenses()
    {
        // Intentionally left without assigning to public properties
        // Licenses are computed in render() to avoid Livewire paginator serialization
    }

    public function openAddModal()
    {
        $this->resetValidation();
        $this->addForm = [
            'user_id' => '',
            'license_type_id' => '',
            'license_number' => '',
            'state_id' => '',
            'issue_date' => '',
            'expiration_date' => '',
            'issuing_authority' => '',
            'notes' => '',
            'document' => null,
        ];
        $this->showAddModal = true;
    }

    public function openRequestModal()
    {
        $this->resetValidation();
        $this->requestForm = [
            'user_id' => '',
            'license_type_id' => '',
            'state_id' => '',
            'reason' => '',
            'urgent' => false,
        ];
        $this->showRequestModal = true;
    }

    public function saveLicense()
    {
        $this->validate([
            'addForm.user_id' => 'required|exists:users,id',
            'addForm.license_type_id' => 'required|exists:license_types,id',
            'addForm.license_number' => 'required|string|max:255',
            'addForm.state_id' => 'required|exists:states,id',
            'addForm.issue_date' => 'required|date',
            'addForm.expiration_date' => 'required|date|after:addForm.issue_date',
            'addForm.document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:10240',
        ]);

        // Ensure doctor belongs to this org admin
        if (!$this->doctors->pluck('id')->contains((int)$this->addForm['user_id'])) {
            $this->addError('addForm.user_id', 'Invalid doctor selection.');
            return;
        }

        $documentPath = null;
        if ($this->addForm['document']) {
            $file = $this->addForm['document'];
            $filename = 'license_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $documentPath = $file->storeAs('doctor-documents', $filename, 'public');
        }

        $license = DoctorLicense::create([
            'user_id' => (int)$this->addForm['user_id'],
            'license_type_id' => (int)$this->addForm['license_type_id'],
            'license_number' => $this->addForm['license_number'],
            'state_id' => (int)$this->addForm['state_id'],
            'issue_date' => $this->addForm['issue_date'],
            'expiration_date' => $this->addForm['expiration_date'],
            'issuing_authority' => $this->addForm['issuing_authority'] ?: null,
            'notes' => $this->addForm['notes'] ?: null,
            'status' => LicenseStatus::ACTIVE,
            'is_verified' => false,
            'document' => $documentPath,
        ]);

        $this->notifyAboutLicense($license, 'added');
        $this->showAddModal = false;
        $this->loadLicenses();
    }

    public function submitRequest()
    {
        $this->validate([
            'requestForm.user_id' => 'required|exists:users,id',
            'requestForm.license_type_id' => 'required|exists:license_types,id',
            'requestForm.state_id' => 'required|exists:states,id',
        ]);

        if (!$this->doctors->pluck('id')->contains((int)$this->requestForm['user_id'])) {
            $this->addError('requestForm.user_id', 'Invalid doctor selection.');
            return;
        }

        $license = DoctorLicense::create([
            'user_id' => (int)$this->requestForm['user_id'],
            'license_type_id' => (int)$this->requestForm['license_type_id'],
            'state_id' => (int)$this->requestForm['state_id'],
            'status' => LicenseStatus::REQUESTED,
            'is_verified' => false,
            'notes' => $this->requestForm['reason'] ?: null,
        ]);

        $this->notifyAboutLicense($license, 'requested');
        $this->showRequestModal = false;
        $this->loadLicenses();
    }

    public function viewLicense($id)
    {
        $license = DoctorLicense::with(['licenseType','state','user'])->findOrFail($id);
        if (!$this->doctors->pluck('id')->contains($license->user_id)) {
            abort(403);
        }
        $this->selectedLicenseId = $license->id;
        $this->selectedLicenseData = [
            'doctor' => $license->user?->name,
            'license_type' => $license->licenseType?->name,
            'license_number' => $license->license_number,
            'state' => $license->state?->name,
            'issue_date' => optional($license->issue_date)?->format('Y-m-d'),
            'expiration_date' => optional($license->expiration_date)?->format('Y-m-d'),
            'status' => $license->status?->value,
            'issuing_authority' => $license->issuing_authority,
            'notes' => $license->notes,
            'document' => $license->document,
        ];
        $this->showViewModal = true;
    }

    public function editLicense($id)
    {
        $this->resetValidation();
        $license = DoctorLicense::with(['licenseType','state','user'])->findOrFail($id);
        if (!$this->doctors->pluck('id')->contains($license->user_id)) {
            abort(403);
        }
        // Block editing if requested status
        if ($license->status?->value === LicenseStatus::REQUESTED->value) {
            return; // view/delete only
        }
        $this->selectedLicenseId = $license->id;
        $this->editForm = [
            'license_type_id' => (string)$license->license_type_id,
            'state_id' => (string)$license->state_id,
            'license_number' => (string)($license->license_number ?? ''),
            'issue_date' => optional($license->issue_date)?->format('Y-m-d'),
            'expiration_date' => optional($license->expiration_date)?->format('Y-m-d'),
            'issuing_authority' => (string)($license->issuing_authority ?? ''),
            'notes' => (string)($license->notes ?? ''),
            'document' => null,
            'status' => $license->status?->value ?? LicenseStatus::ACTIVE->value,
        ];
        $this->showEditModal = true;
    }

    public function updateLicense()
    {
        $this->validate([
            'editForm.license_type_id' => 'required|exists:license_types,id',
            'editForm.state_id' => 'required|exists:states,id',
            'editForm.license_number' => 'nullable|string|max:255',
            'editForm.issue_date' => 'nullable|date',
            'editForm.expiration_date' => 'nullable|date|after_or_equal:editForm.issue_date',
            'editForm.issuing_authority' => 'nullable|string|max:255',
            'editForm.notes' => 'nullable|string',
            'editForm.document' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:10240',
            'editForm.status' => 'required|in:pending,requested,active,expired,suspended,revoked',
        ]);

        $license = DoctorLicense::findOrFail($this->selectedLicenseId);
        if (!$this->doctors->pluck('id')->contains($license->user_id)) {
            abort(403);
        }

        $documentPath = $license->document;
        if ($this->editForm['document']) {
            $file = $this->editForm['document'];
            $filename = 'license_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $documentPath = $file->storeAs('doctor-documents', $filename, 'public');
        }

        $license->update([
            'license_type_id' => (int)$this->editForm['license_type_id'],
            'state_id' => (int)$this->editForm['state_id'],
            'license_number' => $this->editForm['license_number'] ?: null,
            'issue_date' => $this->editForm['issue_date'] ?: null,
            'expiration_date' => $this->editForm['expiration_date'] ?: null,
            'issuing_authority' => $this->editForm['issuing_authority'] ?: null,
            'notes' => $this->editForm['notes'] ?: null,
            'status' => $this->editForm['status'],
            'document' => $documentPath,
        ]);

        $this->notifyAboutLicense($license, 'updated');
        $this->showEditModal = false;
        $this->selectedLicenseId = null;
        $this->loadLicenses();
    }

    public function delete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function confirmDelete()
    {
        $license = DoctorLicense::findOrFail($this->deleteId);
        // Guard: ensure belongs to this admin's doctor
        if (!$this->doctors->pluck('id')->contains($license->user_id)) {
            abort(403);
        }
        $license->delete();
        $this->notifyAboutLicense($license, 'deleted');
        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->loadLicenses();
    }

    private function notifyAboutLicense(DoctorLicense $license, string $action): void
    {
        try {
            $doctor = $license->user;
            $actionText = match ($action) {
                'added' => 'added a new license',
                'requested' => 'requested a new license',
                'updated' => 'updated a license',
                'deleted' => 'deleted a license',
                default => 'changed a license',
            };

            $notificationData = [
                'title' => 'License ' . ucfirst($action),
                'message' => "Organization Admin has {$actionText} for {$doctor->name}",
                'type' => in_array($action, ['added','updated']) ? 'success' : ($action === 'requested' ? 'info' : 'warning'),
                'license_id' => $license->id,
                'doctor_id' => $doctor->id,
                'action' => $action,
                'license_type' => $license->licenseType->name ?? 'Unknown',
                'license_number' => $license->license_number,
                'url' => '/organization-admin/doctor-licenses',
                'read' => null,
                'created_at' => Carbon::now(),
            ];

            // Notify super admin (first super admin found) and the doctor
            $admin = User::where('user_type', \App\Enums\UserType::SUPER_ADMIN)->first();
            if ($admin) {
                $admin->notify(new LicenseNotification($notificationData));
            }
            if ($doctor) {
                $doctor->notify(new LicenseNotification($notificationData));
            }

            // Optional: broadcast event
            $this->dispatch('notification-added', [
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => $notificationData['title'],
                'message' => $notificationData['message'],
                'type' => $notificationData['type'],
                'url' => $notificationData['url'],
                'read' => false,
                'created_at' => now()->diffForHumans(),
            ]);
        } catch (\Throwable $e) {
            // Silent fail for notifications
        }
    }

    public function render()
    {
        $counts = [
            'all' => DoctorLicense::whereIn('user_id', $this->doctors->pluck('id'))->count(),
            'active' => DoctorLicense::whereIn('user_id', $this->doctors->pluck('id'))->where('status', LicenseStatus::ACTIVE)->count(),
            'expired' => DoctorLicense::whereIn('user_id', $this->doctors->pluck('id'))->where('expiration_date', '<', now())->count(),
            'expiring' => DoctorLicense::whereIn('user_id', $this->doctors->pluck('id'))->where('expiration_date', '>', now())->where('expiration_date', '<=', now()->addDays(30))->count(),
            'pending' => DoctorLicense::whereIn('user_id', $this->doctors->pluck('id'))->where('status', LicenseStatus::PENDING)->count(),
        ];

        // Build paginated licenses here (computed at render time)
        $doctorIds = $this->doctors->pluck('id');
        $query = DoctorLicense::with(['licenseType','state','user'])
            ->whereIn('user_id', $doctorIds);

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
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('license_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('licenseType', function ($t) { $t->where('name', 'like', '%' . $this->search . '%'); })
                  ->orWhereHas('state', function ($s) { $s->where('name', 'like', '%' . $this->search . '%'); })
                  ->orWhereHas('user', function ($u) { $u->where('name', 'like', '%' . $this->search . '%'); });
            });
        }

        $licenses = $query->orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);

        return view('livewire.organization.doctor-applications-component', [
            'licenseCounts' => $counts,
            'licenses' => $licenses,
            'doctors' => $this->doctors,
            'licenseTypes' => $this->licenseTypes,
            'states' => $this->states,
        ]);
    }
}


