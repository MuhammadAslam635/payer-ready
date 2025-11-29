<?php

namespace App\Livewire\Organization;

use App\Enums\CredentialStatus;
use App\Enums\UserType;
use App\Models\DoctorCredential;
use App\Models\Payer;
use App\Models\State;
use App\Models\User;
use App\Notifications\InsuranceNotification;
use App\Traits\HasToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Doctor Payer Enrollments')]
#[Layout('layouts.dashboard')]
class DoctorPayerEnrollmentComponent extends Component
{
    use HasToast;

    public $activeTab = 'all';
    public $showRequestModal = false;
    public $providerType = ''; // 'provider' or 'organization'
    public $selectedProvider = '';
    public $selectedPayer = '';
    public $selectedRequestType = '';
    public $selectedState = '';

    public $enrollments;
    public $payers = [];
    public $states = [];
    public $providers = [];
    public $stats = [
        'all' => 0,
        'requested' => 0,
        'working' => 0,
        'pending' => 0,
        'completed' => 0,
        'return_for_correction' => 0,
    ];

    public function mount()
    {
        $this->loadPayers();
        $this->loadStates();
        $this->loadProviders();
        $this->selectedProvider = '';
        $this->loadEnrollments();
        $this->calculateStats();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadEnrollments();
    }

    public function openRequestModal()
    {
        $this->showRequestModal = true;
    }

    public function closeRequestModal()
    {
        $this->showRequestModal = false;
        $this->resetModalForm();
    }

    public function resetModalForm()
    {
        $this->providerType = '';
        $this->selectedProvider = '';
        $this->selectedPayer = '';
        $this->selectedRequestType = '';
        $this->selectedState = '';
    }

    public function updatedProviderType($value)
    {
        // When organization is selected, automatically set selectedProvider to organization admin ID
        if ($value === 'organization') {
            $this->selectedProvider = Auth::id();
        } else {
            // Reset selectedProvider when switching to provider type
            $this->selectedProvider = '';
        }
    }

    public function submitRequest()
    {
        $this->validate([
            'providerType' => 'required|in:provider,organization',
            'selectedProvider' => 'required|exists:users,id',
            'selectedPayer' => 'required|exists:payers,id',
            'selectedRequestType' => 'required|string',
            'selectedState' => 'required|exists:states,id',
        ]);

        // If organization is selected, set selectedProvider to organization admin ID
        if ($this->providerType === 'organization') {
            $this->selectedProvider = Auth::id();
        }

        // Ensure selected provider belongs to this organization admin
        $validProviderIds = $this->getOrgProviderIds();
        if (!in_array((int)$this->selectedProvider, $validProviderIds)) {
            $this->addError('selectedProvider', 'Invalid provider selection.');
            return;
        }

        try {
            DB::beginTransaction();

            $provider = User::find($this->selectedProvider);
            $payer = Payer::find($this->selectedPayer);
            $state = State::find($this->selectedState);

            $credential = DoctorCredential::create([
                'user_id' => $provider->id,
                'payer_id' => $payer->id,
                'state_id' => $state->id,
                'request_type' => $this->selectedRequestType,
                'credential_number' => Str::random(10),
                'status' => CredentialStatus::REQUESTED,
                'submitted_at' => now(),
            ]);

            $notificationData = [
                'type' => 'payer_enrollment_request',
                'provider_name' => $provider->name,
                'payer_name' => $payer->name,
                'state_name' => $state->name,
                'request_type' => $this->selectedRequestType,
                'default_amount' => $payer->default_amount ?? 0,
                'credential_id' => $credential->id,
            ];

            // Notify super admin and org admin (self)
            $adminUsers = User::whereIn('user_type', [UserType::SUPER_ADMIN, UserType::ORGANIZATION_ADMIN])
                ->where('is_active', true)
                ->get();
            foreach ($adminUsers as $admin) {
                $admin->notify(new InsuranceNotification($notificationData));
            }
            $provider->notify(new InsuranceNotification(array_merge($notificationData, [
                'type' => 'payer_enrollment_confirmation'
            ])));

            DB::commit();

            $this->dispatch('notification-added', [
                'title' => 'New Payer Enrollment Request',
                'message' => "Org Admin requested payer {$payer->name} for {$provider->name}",
                'type' => 'info'
            ]);

            $this->closeRequestModal();
            $this->toastSuccess('Enrollment request submitted successfully.');
            $this->loadEnrollments();
            $this->calculateStats();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->toastError('Failed to submit request: ' . $e->getMessage());
        }
    }

    private function loadEnrollments(): void
    {
        $providerIds = $this->getOrgProviderIds();
        $all = DoctorCredential::with(['payer','state','user'])
            ->whereIn('user_id', $providerIds)
            ->get();

        if ($this->activeTab === 'all') {
            $this->enrollments = $all;
        } else {
            $this->enrollments = $all->filter(fn($row) => strtolower(str_replace(' ', '_', (string)$row->status)) === $this->activeTab);
        }
    }

    private function calculateStats(): void
    {
        $providerIds = $this->getOrgProviderIds();
        $this->stats = [
            'all' => DoctorCredential::whereIn('user_id', $providerIds)->count(),
            'requested' => DoctorCredential::whereIn('user_id', $providerIds)->where('status', CredentialStatus::REQUESTED)->count(),
            'working' => DoctorCredential::whereIn('user_id', $providerIds)->where('status', CredentialStatus::WORKING)->count(),
            'pending' => DoctorCredential::whereIn('user_id', $providerIds)->where('status', CredentialStatus::PENDING)->count(),
            'completed' => DoctorCredential::whereIn('user_id', $providerIds)->where('status', CredentialStatus::COMPLETED)->count(),
            'return_for_correction' => DoctorCredential::whereIn('user_id', $providerIds)->where('status', CredentialStatus::REVOKED)->count(),
        ];
    }

    private function loadPayers(): void
    {
        $this->payers = Payer::where('is_active', true)->get();
    }

    private function loadStates(): void
    {
        $this->states = State::where('is_active', true)->orderBy('name')->get();
    }

    private function loadProviders(): void
    {
        // Get individual providers (doctors)
        $doctors = User::where('org_id', Auth::id())
            ->where('user_type', UserType::DOCTOR)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // Get organization provider (the organization admin itself)
        $organization = User::where('id', Auth::id())
            ->where('user_type', UserType::ORGANIZATION_ADMIN)
            ->where('is_active', true)
            ->first();

        // Combine both types
        $this->providers = collect();
        
        if ($organization) {
            $this->providers->push($organization);
        }
        
        $this->providers = $this->providers->concat($doctors)->sortBy('name')->values();
    }

    public function getIndividualProvidersProperty()
    {
        return User::where('org_id', Auth::id())
            ->where('user_type', UserType::DOCTOR)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    private function getOrgDoctorIds(): array
    {
        return User::where('org_id', Auth::id())
            ->where('user_type', UserType::DOCTOR)
            ->pluck('id')
            ->all();
    }

    private function getOrgProviderIds(): array
    {
        // Include organization admin itself
        $orgAdminId = [Auth::id()];
        
        // Include all doctors under this organization
        $doctorIds = $this->getOrgDoctorIds();
        
        // Combine and return
        return array_merge($orgAdminId, $doctorIds);
    }

    public function updateEnrollmentStatus($enrollmentId, $newStatus)
    {
        try {
            $enrollment = DoctorCredential::findOrFail($enrollmentId);
            
            // Check if enrollment belongs to org's provider (doctor or organization)
            $providerIds = $this->getOrgProviderIds();
            if (!in_array($enrollment->user_id, $providerIds)) {
                $this->toastError('Unauthorized access');
                return;
            }

            $enrollment->update([
                'status' => $newStatus,
            ]);

            $this->toastSuccess('Enrollment status updated successfully');
            $this->loadEnrollments();
            $this->calculateStats();
        } catch (\Exception $e) {
            $this->toastError('Failed to update status: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.organization.doctor-payer-enrollment-component', get_defined_vars());
    }
}


