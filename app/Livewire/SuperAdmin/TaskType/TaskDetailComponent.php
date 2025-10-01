<?php

namespace App\Livewire\SuperAdmin\TaskType;

use App\Models\DoctorTask;
use App\Models\TaskType;
use App\Models\User;
use App\Enums\UserType;
use App\Notifications\TaskNotification;
use App\Traits\HasToast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout as AttributesLayout;

#[AttributesLayout('layouts.dashboard')]
class TaskDetailComponent extends Component
{
    use HasToast, WithPagination;

    public TaskType $taskType;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    // Edit assignment modal
    public $showEditModal = false;
    public $editingAssignment = null;
    public $editProvider = null;
    public $editNotes = '';
    public $editDueDate = '';
    public $editStatus = 'pending';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount(TaskType $taskType)
    {
        $this->taskType = $taskType;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
        $this->resetPage();
    }

    public function editAssignment($assignmentId)
    {
        $this->editingAssignment = DoctorTask::with(['user', 'taskType'])->find($assignmentId);
        
        if ($this->editingAssignment) {
            $this->editProvider = $this->editingAssignment->user_id;
            $this->editNotes = $this->editingAssignment->notes;
            $this->editDueDate = $this->editingAssignment->due_date?->format('Y-m-d');
            $this->editStatus = $this->editingAssignment->status;
            $this->showEditModal = true;
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['editingAssignment', 'editProvider', 'editNotes', 'editDueDate', 'editStatus']);
    }

    public function updateAssignment()
    {
        $this->validate([
            'editProvider' => 'required|exists:users,id',
            'editNotes' => 'nullable|string|max:1000',
            'editDueDate' => 'required|date',
            'editStatus' => 'required|in:pending,in_progress,completed',
        ]);

        try {
            $oldProvider = $this->editingAssignment->user;
            $newProvider = User::find($this->editProvider);

            // Update the assignment
            $this->editingAssignment->update([
                'user_id' => $this->editProvider,
                'notes' => $this->editNotes,
                'due_date' => $this->editDueDate,
                'status' => $this->editStatus,
            ]);

            // If provider changed, send notifications
            if ($oldProvider->id !== $newProvider->id) {
                // Notify new provider
                $newProvider->notify(new TaskNotification(
                    $this->editingAssignment, 
                    $this->taskType, 
                    Auth::user(), 
                    'reassigned'
                ));

                // Optionally notify old provider about removal
                $oldProvider->notify(new TaskNotification(
                    $this->editingAssignment, 
                    $this->taskType, 
                    Auth::user(), 
                    'removed'
                ));
            }

            // Emit event to refresh notifications
            $this->dispatch('refresh-notifications');

            $this->toastSuccess('Assignment updated successfully');
            $this->closeEditModal();
        } catch (\Exception $e) {
            $this->toastError('Error updating assignment: ' . $e->getMessage());
        }
    }

    public function deleteAssignment($assignmentId)
    {
        try {
            $assignment = DoctorTask::find($assignmentId);
            if ($assignment) {
                // Notify user about task removal
                $assignment->user->notify(new TaskNotification(
                    $assignment, 
                    $this->taskType, 
                    Auth::user(), 
                    'removed'
                ));

                $assignment->delete();
                
                // Emit event to refresh notifications
                $this->dispatch('refresh-notifications');
                
                $this->toastSuccess('Assignment deleted successfully');
            }
        } catch (\Exception $e) {
            $this->toastError('Error deleting assignment: ' . $e->getMessage());
        }
    }

    public function getAssignmentsProperty()
    {
        $query = DoctorTask::with(['user', 'creator'])
            ->where('task_type_id', $this->taskType->id);

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        return $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function getProvidersProperty()
    {
        return User::whereIn('user_type', [UserType::DOCTOR, UserType::ORGANIZATION_ADMIN])
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.super-admin.task-type.task-detail-component', [
            'assignments' => $this->assignments,
            'providers' => $this->providers,
        ]);
    }
}
