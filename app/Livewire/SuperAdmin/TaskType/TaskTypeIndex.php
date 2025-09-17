<?php

namespace App\Livewire\SuperAdmin\TaskType;

use App\Models\TaskType;
use App\Traits\Admin\CrudTrait;
use Livewire\Component;

class TaskTypeIndex extends Component
{
    use CrudTrait;

    protected function getModelClass(): string
    {
        return TaskType::class;
    }

    protected function getFormFields(): array
    {
        return [
            'name' => '',
            'code' => '',
            'description' => '',
            'default_priority' => 'medium',
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
            'is_active' => 'Status',
        ];
    }

    protected function getSearchableFields(): array
    {
        return ['code', 'name', 'description'];
    }

    protected function rules(): array
    {
        return [
            'formData.name' => 'required|string|max:255',
            'formData.code' => 'required|string|max:20|unique:task_types,code,' . $this->modelId,
            'formData.description' => 'nullable|string|max:1000',
            'formData.default_priority' => 'required|in:low,medium,high,urgent',
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
        ];
    }

    public function render()
    {
        return view('livewire.super-admin.task-type.task-type-index', [
            'taskTypes' => $this->results,
            'columns' => $this->getTableColumns(),
        ])->layout('layouts.dashboard');
    }
}
