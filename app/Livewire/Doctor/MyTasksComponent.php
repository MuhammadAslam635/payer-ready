<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\DoctorTask;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskType;
use Livewire\WithPagination;

#[Title('My Tasks')]
#[Layout('layouts.dashboard')]
class MyTasksComponent extends Component
{
    use WithPagination;
    public $activeTab = 'all';
    public $tasks = [];
    public $taskTypes = [];
    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public function mount()
    {
        $this->loadTasks();
        $this->taskTypes = TaskType::all();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->loadTasks();
    }

    public function sortBy($field)
    {
        $this->sortField = $field;
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function loadTasks()
    {
        $user = Auth::user();

        $query = DoctorTask::where('user_id', Auth::user()->id);

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
                // 'all' - no additional filter
                break;
        }

        $this->tasks = $query->orderBy($this->sortField, $this->sortDirection)->get();
    }

    public function updateTaskStatus($taskId, $status)
    {
        try {
            $task = DoctorTask::where('id', $taskId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$task) {
                session()->flash('error', 'Task not found or you do not have permission to update it.');
                return;
            }

            $task->update([
                'status' => $status,
                'completed_date' => $status === 'completed' ? now() : null,
            ]);

            // Reload tasks to reflect the change
            $this->loadTasks();

            session()->flash('success', 'Task status updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update task status: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $taskCounts = $this->getTaskCounts();

        return view('livewire.doctor.my-tasks-component', [
            'taskCounts' => $taskCounts,
            'tasks' => $this->tasks,
            'taskTypes' => $this->taskTypes,
            'search' => $this->search,
            'perPage' => $this->perPage,
            'sortField' => $this->sortField,
            'sortDirection' => $this->sortDirection,
        ]);
    }

    private function getTaskCounts()
    {
        $user = Auth::user();
        $userId = $user->id;

        $allTasks = DoctorTask::where('user_id', $userId)->count();
        $todoTasks = DoctorTask::where('user_id', $userId)->where('status', 'pending')->count();
        $inProgressTasks = DoctorTask::where('user_id', $userId)->where('status', 'in_progress')->count();
        $completedTasks = DoctorTask::where('user_id', $userId)->where('status', 'completed')->count();

        return [
            'all' => $allTasks,
            'todo' => $todoTasks,
            'in_progress' => $inProgressTasks,
            'completed' => $completedTasks,
        ];
    }
}
