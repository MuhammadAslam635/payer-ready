<?php

namespace App\Livewire\Coordinator;

use App\Models\DoctorTask;
use App\Models\User;
use App\Models\TaskType;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Tasks')]
#[Layout('layouts.dashboard')]
class TasksComponent extends Component
{
    use WithPagination;

    public $activeTab = 'all';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $search = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'activeTab' => ['except' => 'all'],
        'perPage' => ['except' => 10]
    ];

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function getTaskCounts()
    {
        $orgAdminId = Auth::user()->org_id ?: Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $orgAdminId)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id');

        $query = DoctorTask::query()->whereIn('user_id', $doctorIds);

        return [
            'all' => (clone $query)->count(),
            'todo' => (clone $query)->where('status', 'pending')->count(),
            'in_progress' => (clone $query)->where('status', 'in_progress')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
        ];
    }

    public function getTasks()
    {
        $orgAdminId = Auth::user()->org_id ?: Auth::id();
        $doctorIds = User::query()
            ->where('org_id', $orgAdminId)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id');

        $query = DoctorTask::query()
            ->with(['user', 'taskType', 'createdBy'])
            ->whereIn('user_id', $doctorIds);

        // Filter by tab
        switch ($this->activeTab) {
            case 'todo':
                $query->where('status', 'pending');
                break;
            case 'in_progress':
                $query->where('status', 'in_progress');
                break;
            case 'completed':
                $query->where('status', 'completed');
                break;
            default:
                // all tasks
                break;
        }

        // Search functionality
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('notes', 'like', '%' . $this->search . '%')
                  ->orWhereHas('taskType', function ($tq) {
                      $tq->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('user', function ($uq) {
                      $uq->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        return $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.coordinator.tasks-component', [
            'tasks' => $this->getTasks(),
            'taskCounts' => $this->getTaskCounts(),
        ]);
    }
}


