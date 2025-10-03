<?php

namespace App\Livewire\SuperAdmin\Tasks;

use App\Enums\UserType;
use App\Models\DoctorTask;
use App\Models\TaskType;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class AllTaskComponent extends Component
{
    use WithPagination;

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
    public $selectedTask = null;

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

    public function render()
    {
        $tasks = DoctorTask::with(['user', 'taskType', 'createdBy'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
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
        $users = User::where('user_type', UserType::DOCTOR)->get();
        $taskStatuses = ['pending', 'in_progress', 'completed', 'cancelled'];

        return view('livewire.super-admin.tasks.all-task-component', [
            'tasks' => $tasks,
            'taskTypes' => $taskTypes,
            'users' => $users,
            'taskStatuses' => $taskStatuses,
        ]);
    }
}
