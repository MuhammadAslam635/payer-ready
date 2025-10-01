<?php

namespace App\Livewire\Doctor\Application;

use App\Enums\CredentialStatus;
use App\Enums\UserType;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Payer;
use App\Models\State;
use App\Models\User;
use App\Models\DoctorCredential;
use App\Notifications\InsuranceNotification;
use App\Traits\HasToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

#[Title('Payer Enrollments')]
#[Layout('layouts.dashboard')]
class PayerEnrollmentComponent extends Component
{
    use HasToast;
    public $activeTab = 'all';
    public $showRequestModal = false;
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
        $this->loadEnrollments();
        $this->calculateStats();
        $this->loadPayers();
        $this->loadStates();
        $this->loadProviders();

        // Default select current user as provider
        $this->selectedProvider = Auth::id();
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
        $this->selectedProvider = Auth::id(); // Default to current user
        $this->selectedPayer = '';
        $this->selectedRequestType = '';
        $this->selectedState = '';
    }

    public function submitRequest()
    {
        $this->validate([
            'selectedProvider' => 'required',
            'selectedPayer' => 'required',
            'selectedRequestType' => 'required',
            'selectedState' => 'required',
        ]);
        // dd($this->all());

        try {
            // Get the selected models
            $provider = User::find($this->selectedProvider);
            $payer = Payer::find($this->selectedPayer);
            $state = State::find($this->selectedState);

            // Create DoctorCredential record
            $credential = DoctorCredential::create([
                'user_id' => $this->selectedProvider,
                'payer_id' => $this->selectedPayer,
                'state_id' => $this->selectedState,
                'request_type' => $this->selectedRequestType,
                'credential_number'=>Str::random(10),
                'status' => 'pending',
                'submitted_at' => now(),
            ]);

            // Prepare notification data
            $notificationData = [
                'type' => 'payer_enrollment_request',
                'provider_name' => $provider->name,
                'payer_name' => $payer->name,
                'state_name' => $state->name,
                'request_type' => $this->selectedRequestType,
                'default_amount' => $payer->default_amount ?? 0,
                'credential_id' => $credential->id,
            ];

            // Send notification to admins
            $adminUsers = User::whereIn('user_type', [
                UserType::SUPER_ADMIN,
                UserType::ORGANIZATION_ADMIN
            ])->where('is_active', true)->get();

            foreach ($adminUsers as $admin) {
                $admin->notify(new InsuranceNotification($notificationData));
            }

            // Dispatch real-time notification event
            $this->dispatch('notification-added', [
                'title' => 'New Certificate Request',
                'message' => "Dr. {$provider->name} has requested a new certificate for {$payer->name}",
                'type' => 'info'
            ]);

            // Send confirmation notification to provider
            $confirmationData = array_merge($notificationData, [
                'type' => 'payer_enrollment_confirmation'
            ]);

            $provider->notify(new InsuranceNotification($confirmationData));

            $this->closeRequestModal();

            // Add a flash message
            $this->toastSuccess('Payer enrollment request submitted successfully!');

            // Refresh the enrollments list
            $this->loadEnrollments();
            $this->calculateStats();

        } catch (\Exception $e) {
            $this->toastError('Failed to submit payer enrollment request. Please try again.',$e->getMessage());
        }
    }

    private function loadEnrollments()
    {
        $allEnrollments = DoctorCredential::where('user_id',Auth::user()->id)->get();
        // dd($allEnrollments);

        // Filter based on active tab
        if ($this->activeTab === 'all') {
            $this->enrollments = $allEnrollments;
        } else {
            $this->enrollments = $allEnrollments->filter(function ($enrollment) {
                return strtolower(str_replace(' ', '_', $enrollment->status)) === $this->activeTab;
            });
        }
    }

    private function calculateStats()
    {
        // For demo purposes, using static counts
        // In a real application, this would query the database
        $all = DoctorCredential::where('user_id',Auth::user()->id)->count();
        $requested = DoctorCredential::where('user_id',Auth::user()->id)->where('status',CredentialStatus::REQUESTED)->count();
        $working = DoctorCredential::where('user_id',Auth::user()->id)->where('status',CredentialStatus::WORKING)->count();
        $pending = DoctorCredential::where('user_id',Auth::user()->id)->where('status',CredentialStatus::PENDING)->count();
        $completed = DoctorCredential::where('user_id',Auth::user()->id)->where('status',CredentialStatus::COMPLETED)->count();
        $revoked = DoctorCredential::where('user_id',Auth::user()->id)->where('status',CredentialStatus::REVOKED)->count();
        $this->stats = [
            'all' => $all,
            'requested' => $requested,
            'working' => $working,
            'pending' => $pending,
            'completed' => $completed,
            'return_for_correction' => $revoked,
        ];
    }

    private function loadPayers()
    {
        $this->payers = Payer::where('is_active', true)->get();
    }

    private function loadStates()
    {
        $this->states = State::where('is_active', true)->orderBy('name')->get();
    }

    private function loadProviders()
    {
        // Load all users with doctor role or just current user for now
        $this->providers = User::where('user_type',UserType::DOCTOR)->get();
    }

    public function render()
    {
        // $enrollments = DoctorCredential::where('id',Auth::user()->id)->get();
        return view('livewire.doctor.application.payer-enrollment-component',get_defined_vars());
    }
}
