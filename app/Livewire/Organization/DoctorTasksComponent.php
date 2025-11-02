<?php

namespace App\Livewire\Organization;

use App\Models\DoctorTask;
use App\Models\TaskType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Doctor Tasks')]
#[Layout('layouts.dashboard')]
class DoctorTasksComponent extends Component
{
    use WithPagination;

    public $activeTab = 'all';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $search = '';

    public $showModal = false;
    public $editing = false;
    public $taskId = null;

    // Form
    public $form = [
        'user_id' => '',
        'task_type_id' => '',
        'status' => 'pending',
        'due_date' => '',
        'notes' => '',
    ];

    public $taskTypes = [];
    public $doctors = [];

    public function mount()
    {
        $this->taskTypes = TaskType::orderBy('name')->get(['id','name']);
        $this->doctors = User::where('org_id', Auth::id())
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->orderBy('name')
            ->get(['id','name','email']);
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function sortBy($field)
    {
        $this->sortField = $field;
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function create()
    {
        $this->resetValidation();
        $this->editing = false;
        $this->taskId = null;
        $this->form = [
            'user_id' => '',
            'task_type_id' => '',
            'status' => 'pending',
            'due_date' => '',
            'notes' => '',
        ];
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $task = DoctorTask::findOrFail($id);
        // Ensure this task belongs to a doctor under this admin
        if (!in_array($task->user_id, $this->doctors->pluck('id')->all())) {
            abort(403);
        }
        $this->editing = true;
        $this->taskId = $task->id;
        $this->form = [
            'user_id' => (string)$task->user_id,
            'task_type_id' => (string)$task->task_type_id,
            'status' => $task->status,
            'due_date' => optional($task->due_date)->format('Y-m-d'),
            'notes' => (string)($task->notes ?? ''),
        ];
        $this->showModal = true;
    }

    public function rules()
    {
        return [
            'form.user_id' => 'required|exists:users,id',
            'form.task_type_id' => 'required|exists:task_types,id',
            'form.status' => 'required|in:pending,in_progress,completed,cancelled',
            'form.due_date' => 'nullable|date',
            'form.notes' => 'nullable|string',
        ];
    }

    public function save()
    {
        $this->validate();

        // Ensure selected doctor belongs to this admin
        if (!in_array((int)$this->form['user_id'], $this->doctors->pluck('id')->all())) {
            $this->addError('form.user_id', 'Invalid doctor selection.');
            return;
        }

        $data = [
            'user_id' => (int)$this->form['user_id'],
            'task_type_id' => (int)$this->form['task_type_id'],
            'status' => $this->form['status'],
            'due_date' => $this->form['due_date'] ?: null,
            'notes' => $this->form['notes'] ?: null,
            'created_by' => Auth::id(),
        ];

        if ($this->editing) {
            $task = DoctorTask::findOrFail($this->taskId);
            $task->update($data);
        } else {
            DoctorTask::create($data);
        }

        $this->showModal = false;
        $this->dispatch('toast', type: 'success', message: 'Task saved successfully.');
    }

    public function delete($id)
    {
        $task = DoctorTask::findOrFail($id);
        if (!in_array($task->user_id, $this->doctors->pluck('id')->all())) {
            abort(403);
        }
        $task->delete();
        $this->dispatch('toast', type: 'success', message: 'Task deleted successfully.');
    }

    public function updateTaskStatus($taskId, $status)
    {
        try {
            $task = DoctorTask::findOrFail($taskId);
            if (!in_array($task->user_id, $this->doctors->pluck('id')->all())) {
                abort(403);
            }
            
            $task->update([
                'status' => $status,
                'completed_date' => $status === 'completed' ? now() : null,
            ]);

            $this->dispatch('toast', type: 'success', message: 'Task status updated successfully.');
        } catch (\Exception $e) {
            $this->dispatch('toast', type: 'error', message: 'Failed to update task status: ' . $e->getMessage());
        }
    }

    public function getTaskCounts()
    {
        $doctorIds = $this->doctors->pluck('id');
        return [
            'all' => DoctorTask::whereIn('user_id', $doctorIds)->count(),
            'todo' => DoctorTask::whereIn('user_id', $doctorIds)->where('status', 'pending')->count(),
            'in_progress' => DoctorTask::whereIn('user_id', $doctorIds)->where('status', 'in_progress')->count(),
            'completed' => DoctorTask::whereIn('user_id', $doctorIds)->where('status', 'completed')->count(),
            'mine' => DoctorTask::whereIn('user_id', $doctorIds)->where('created_by', Auth::id())->count(),
        ];
    }

    public function getTasksProperty()
    {
        $doctorIds = $this->doctors->pluck('id');
        $query = DoctorTask::with(['user', 'taskType', 'createdBy'])
            ->whereIn('user_id', $doctorIds);

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
            case 'mine':
                $query->where('created_by', Auth::id());
                break;
            default:
                // all
                break;
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('notes', 'like', '%' . $this->search . '%');
            });
        }

        return $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.organization.doctor-tasks-component', [
            'taskCounts' => $this->getTaskCounts(),
            'tasks' => $this->tasks,
            'taskTypes' => $this->taskTypes,
        ]);
    }
}


