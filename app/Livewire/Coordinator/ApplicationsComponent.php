<?php

namespace App\Livewire\Coordinator;

use App\Models\DoctorCredential;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Applications')]
#[Layout('layouts.dashboard')]
class ApplicationsComponent extends Component
{
    use WithPagination;

    public $activeTab = 'all';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $search = '';
    public $perPage = 10;
    public $showRequestModal = false;

    protected $queryString = [
        'activeTab' => ['except' => 'all'],
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc']
    ];

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }
    
    public function openRequestModal()
    {
        $this->showRequestModal = true;
    }
    
    public function closeRequestModal()
    {
        $this->showRequestModal = false;
    }
    
    public function submitRequest()
    {
        // This will be implemented based on business requirements
        $this->closeRequestModal();
    }

    public function getApplicationCounts()
    {
        $orgAdminId = Auth::user()->org_id ?: Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $orgAdminId)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id');

        $query = DoctorCredential::query()
            ->whereIn('user_id', $doctorIds);

        $all = (clone $query)->count();
        $requested = (clone $query)->where('status', 'requested')->count();
        $working = (clone $query)->where('status', 'working')->count();
        $pending = (clone $query)->where('status', 'pending')->count();
        $completed = (clone $query)->where('status', 'completed')->count();

        return [
            'all' => $all,
            'requested' => $requested,
            'working' => $working,
            'pending' => $pending,
            'completed' => $completed
        ];
    }

    public function getApplications()
    {
        $orgAdminId = Auth::user()->org_id ?: Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $orgAdminId)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id');

        return DoctorCredential::query()
            ->with(['payer','state','user'])
            ->whereIn('user_id', $doctorIds)
            ->when($this->activeTab !== 'all', function ($query) {
                return $query->where('status', $this->activeTab);
            })
            ->when($this->search, function ($q) {
                $q->where('credential_number', 'like', '%' . $this->search . '%')
                  ->orWhere('request_type', 'like', '%' . $this->search . '%')
                  ->orWhereHas('payer', function ($pq) {
                      $pq->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('user', function ($uq) {
                      $uq->where('name', 'like', '%' . $this->search . '%');
                  });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.coordinator.applications-component', [
            'applications' => $this->getApplications(),
            'applicationCounts' => $this->getApplicationCounts(),
        ]);
    }
}


