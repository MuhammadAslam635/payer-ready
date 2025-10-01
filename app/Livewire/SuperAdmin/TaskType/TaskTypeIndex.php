<?php

namespace App\Livewire\SuperAdmin\TaskType;

use App\Models\DoctorTask;
use App\Models\TaskType;
use App\Models\User;
use App\Enums\UserType;
use App\Notifications\TaskNotification;
use App\Traits\Admin\CrudTrait;
use App\Traits\HasToast;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout as AttributesLayout;

#[AttributesLayout('layouts.dashboard')]
class TaskTypeIndex extends Component
{
    use HasToast;
    use CrudTrait;
    
    public $showAssignTaskModal = false;
    public $provider_id;
    public $task_id;
    public $assignTask;
    public $notes;

    protected function getModelClass(): string
    {
        return TaskType::class;
    }

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

    protected function getFormFields(): array
    {
        return [
            'name' => '',
            'code' => '',
            'description' => '',
            'default_priority' => 2, // 2 = medium
            'estimated_days' => 1,
            'is_active' => true,
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'default_priority' => 'Default Priority',
            'estimated_days' => 'Estimated Days',
            'assignments_count' => 'Assigned Users',
            'is_active' => 'Status',
        ];
    }

    protected function getSearchableFields(): array
    {
        return ['code', 'name', 'description'];
    }

    protected function rules(): array
    {
        $modelId = $this->modelId ?: 'NULL';

        return [
            'formData.name' => 'required|string|max:255',
            'formData.code' => 'required|string|max:20|unique:task_types,code,' . $modelId,
            'formData.description' => 'nullable|string|max:1000',
            'formData.default_priority' => 'required|integer|in:1,2,3,4',
            'formData.estimated_days' => 'required|integer|min:1|max:365',
            'formData.is_active' => 'boolean',
        ];
    }

    protected function messages(): array
    {
        return [
            'formData.name.required' => 'The name field is required.',
            'formData.code.required' => 'The code field is required.',
            'formData.code.unique' => 'The code has already been taken.',
            'formData.default_priority.required' => 'The default priority field is required.',
            'formData.estimated_days.required' => 'The estimated days field is required.',
            'formData.estimated_days.min' => 'The estimated days must be at least 1.',
            'provider_id.required' => 'Please select a provider.',
            'provider_id.exists' => 'Selected provider does not exist.',
            'task_id.required' => 'Please select a task.',
            'task_id.exists' => 'Selected task does not exist.',
        ];
    }

    public function render()
    {
        // Get paginated results and add assignment counts
        $taskTypes = $this->results;
        
        // Add assignment counts to each task type
        $taskTypes->getCollection()->transform(function ($taskType) {
            $taskType->assignments_count = $taskType->tasks()->count();
            return $taskType;
        });

        return view('livewire.super-admin.task-type.task-type-index', [
            'taskTypes' => $taskTypes,
            'columns' => $this->getTableColumns(),
            'providers' => $this->providers,
            'tasks' => $this->tasks,
        ]);
    }
}
