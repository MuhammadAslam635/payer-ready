<?php

namespace App\Livewire\Doctor\Application;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Title('Payer Enrollments')]
#[Layout('layouts.dashboard')]
class PayerEnrollmentComponent extends Component
{
    public $activeTab = 'all';
    public $showRequestModal = false;
    public $selectedProvider = '';
    public $selectedPayer = '';
    public $selectedRequestType = '';
    
    public $enrollments = [];
    public $stats = [
        'all' => 0,
        'requested' => 0,
        'working' => 0,
        'pending_payer' => 0,
        'completed' => 0,
        'return_for_correction' => 0,
    ];

    public function mount()
    {
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
        $this->resetModalForm();
    }

    public function closeRequestModal()
    {
        $this->showRequestModal = false;
        $this->resetModalForm();
    }

    public function resetModalForm()
    {
        $this->selectedProvider = '';
        $this->selectedPayer = '';
        $this->selectedRequestType = '';
    }

    public function submitRequest()
    {
        // Validate the form
        $this->validate([
            'selectedProvider' => 'required',
            'selectedPayer' => 'required',
            'selectedRequestType' => 'required',
        ]);

        // Here you would typically save the request to the database
        // For demo purposes, we'll just close the modal and show a success message
        
        $this->closeRequestModal();
        
        // Add a flash message or dispatch an event
        session()->flash('message', 'Payer enrollment request submitted successfully!');
        
        // Refresh the enrollments list
        $this->loadEnrollments();
        $this->calculateStats();
    }

    private function loadEnrollments()
    {
        // For demo purposes, we'll use static data
        // In a real application, this would query the database
        $allEnrollments = [
            [
                'id' => 1,
                'payer' => 'Aetna',
                'state' => 'CA',
                'request_type' => 'Enrollment - New',
                'provider' => 'Dr. John Smith',
                'status' => 'Completed',
                'par_status' => 'Participating',
            ],
            [
                'id' => 2,
                'payer' => 'Blue Cross Blue Shield',
                'state' => 'NY',
                'request_type' => 'Re-credentialing',
                'provider' => 'Dr. Jane Doe',
                'status' => 'Working',
                'par_status' => 'Pending',
            ],
            [
                'id' => 3,
                'payer' => 'Cigna',
                'state' => 'TX',
                'request_type' => 'Enrollment - New',
                'provider' => 'Dr. John Smith',
                'status' => 'Requested',
                'par_status' => 'N/A',
            ],
        ];

        // Filter based on active tab
        if ($this->activeTab === 'all') {
            $this->enrollments = $allEnrollments;
        } else {
            $this->enrollments = array_filter($allEnrollments, function ($enrollment) {
                return strtolower(str_replace(' ', '_', $enrollment['status'])) === $this->activeTab;
            });
        }
    }

    private function calculateStats()
    {
        // For demo purposes, using static counts
        // In a real application, this would query the database
        $this->stats = [
            'all' => 3,
            'requested' => 1,
            'working' => 1,
            'pending_payer' => 0,
            'completed' => 1,
            'return_for_correction' => 0,
        ];
    }

    public function render()
    {
        return view('livewire.doctor.application.payer-enrollment-component');
    }
}
