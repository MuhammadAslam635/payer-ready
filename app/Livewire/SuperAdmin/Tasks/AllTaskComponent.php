<?php

namespace App\Livewire\SuperAdmin\Tasks;

use App\Enums\UserType;
use App\Models\DoctorTask;
use App\Models\TaskType;
use App\Models\User;
use App\Notifications\TaskNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Traits\HasToast;

#[Layout('layouts.dashboard')]
class AllTaskComponent extends Component
{
    use WithPagination, HasToast;

    // Search and filter properties
    public $search = '';
    public $statusFilter = '';
    public $taskTypeFilter = '';
    public $userFilter = '';

    // Sorting properties
    public $sortBy = 'id';
    public $sortDirection = 'desc';

    // Modal properties
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showAssignTaskModal = false;
    public $selectedTask = null;
    
    // Assign Task properties
    public $provider_id;
    public $task_id;
    public $assignTask;
    public $notes;

    // Edit form properties
    public $editStatus = '';
    public $editDueDate = '';
    public $editCompletedDate = '';
    public $editNotes = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'taskTypeFilter' => ['except' => ''],
        'userFilter' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected $rules = [
        'editStatus' => 'required|in:pending,in_progress,completed,cancelled',
        'editDueDate' => 'nullable|date',
        'editCompletedDate' => 'nullable|date',
        'editNotes' => 'nullable|string|max:1000',
    ];

    // Reset pagination when search/filter changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingTaskTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingUserFilter()
    {
        $this->resetPage();
    }

    // Sorting functionality
    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Clear all filters
    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->taskTypeFilter = '';
        $this->userFilter = '';
        $this->resetPage();
    }

    // Edit task functionality
    public function editTask($taskId)
    {
        $this->selectedTask = DoctorTask::findOrFail($taskId);
        $this->editStatus = $this->selectedTask->status;
        $this->editDueDate = $this->selectedTask->due_date ? $this->selectedTask->due_date->format('Y-m-d') : '';
        $this->editCompletedDate = $this->selectedTask->completed_date ? $this->selectedTask->completed_date->format('Y-m-d') : '';
        $this->editNotes = $this->selectedTask->notes;
        $this->showEditModal = true;
    }

    // Update task
    public function updateTask()
    {
        $this->validate();

        $this->selectedTask->update([
            'status' => $this->editStatus,
            'due_date' => $this->editDueDate ?: null,
            'completed_date' => $this->editCompletedDate ?: null,
            'notes' => $this->editNotes,
        ]);

        session()->flash('message', 'Task updated successfully.');
        $this->closeModal();
    }

    // Confirm delete
    public function confirmDelete($taskId)
    {
        $this->selectedTask = DoctorTask::findOrFail($taskId);
        $this->showDeleteModal = true;
    }

    // Delete task
    public function deleteTask()
    {
        $this->selectedTask->delete();
        session()->flash('message', 'Task deleted successfully.');
        $this->closeModal();
    }

    // Close modal and reset validation
    public function closeModal()
    {
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->selectedTask = null;
        $this->resetValidation();
        $this->reset(['editStatus', 'editDueDate', 'editCompletedDate', 'editNotes']);
    }

    // Assign Task Modal Methods
    public function openAssignModal()
    {
        $this->showAssignTaskModal = true;
    }

    public function closeAssignModal()
    {
        $this->showAssignTaskModal = false;
        $this->reset(["provider_id", "task_id", "assignTask", "notes"]);
    }

    public function saveAssignTask()
    {
        $this->validate([
            'provider_id' => "required|exists:users,id",
            'task_id' => 'required|exists:task_types,id'
        ]);

        $this->assignTask = TaskType::find($this->task_id);
        if (!$this->assignTask) {
            $this->toastError("Selected task does not exist");
            return;
        }

        try {
            $provider = User::find($this->provider_id);
            
            // Create task for the selected provider
            $doctorTask = DoctorTask::create([
                'user_id' => $this->provider_id,
                'task_type_id' => $this->task_id,
                'created_by' => Auth::user()->id,
                'due_date' => Carbon::today()->addDays($this->assignTask->estimated_days),
                'notes' => $this->notes
            ]);

            // Send notification to the assigned user
            $provider->notify(new TaskNotification($doctorTask, $this->assignTask, Auth::user(), 'assigned'));

            // If provider is organization_admin, also assign to sub-users (doctors)
            if ($provider->user_type === UserType::ORGANIZATION_ADMIN) {
                $subUsers = User::where('org_id', $this->provider_id)
                    ->where('user_type', UserType::DOCTOR)
                    ->get();

                foreach ($subUsers as $subUser) {
                    $subDoctorTask = DoctorTask::create([
                        'user_id' => $subUser->id,
                        'task_type_id' => $this->task_id,
                        'created_by' => Auth::user()->id,
                        'due_date' => Carbon::today()->addDays($this->assignTask->estimated_days),
                        'notes' => $this->notes
                    ]);

                    // Send notification to sub-user
                    $subUser->notify(new TaskNotification($subDoctorTask, $this->assignTask, Auth::user(), 'assigned'));
                }
            }

            // Emit event to refresh notifications
            $this->dispatch('refresh-notifications');

            $this->toastSuccess("Task has been assigned successfully");
            $this->closeAssignModal();
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    /**
     * Get providers (doctors and organization admins)
     */
    public function getProvidersProperty()
    {
        return User::whereIn('user_type', [UserType::DOCTOR, UserType::ORGANIZATION_ADMIN])
            ->orderBy('name')
            ->get();
    }

    /**
     * Get active task types
     */
    public function getTasksProperty()
    {
        return TaskType::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        $tasks = DoctorTask::with(['user', 'taskType', 'createdBy'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })->orWhereHas('taskType', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('notes', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->taskTypeFilter, function ($query) {
                $query->where('task_type_id', $this->taskTypeFilter);
            })
            ->when($this->userFilter, function ($query) {
                $query->where('user_id', $this->userFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        $taskTypes = TaskType::where('is_active', true)->get();
        $users = User::whereIn('user_type', [UserType::DOCTOR, UserType::ORGANIZATION_ADMIN])->orderBy('name')->get();
        $taskStatuses = ['pending', 'in_progress', 'completed', 'cancelled'];

        return view('livewire.super-admin.tasks.all-task-component', [
            'tasks' => $tasks,
            'taskTypes' => $taskTypes,
            'users' => $users,
            'taskStatuses' => $taskStatuses,
        ]);
    }
}
