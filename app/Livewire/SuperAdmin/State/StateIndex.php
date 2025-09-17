<?php

namespace App\Livewire\SuperAdmin\State;

use App\Models\State;
use App\Traits\Admin\CrudTrait;
use Livewire\Component;

class StateIndex extends Component
{
    use CrudTrait;

    protected function getModelClass(): string
    {
        return State::class;
    }

    protected function getFormFields(): array
    {
        return [
            'code' => '',
            'name' => '',
            'country' => 'US',
            'is_active' => true,
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'country' => 'Country',
            'is_active' => 'Status',
        ];
    }

    protected function getSearchableFields(): array
    {
        return ['code', 'name', 'country'];
    }

    protected function rules(): array
    {
        return [
            'formData.code' => 'required|string|max:10|unique:states,code,' . $this->modelId,
            'formData.name' => 'required|string|max:255',
            'formData.country' => 'required|string|max:10',
            'formData.is_active' => 'boolean',
        ];
    }

    protected function messages(): array
    {
        return [
            'formData.code.required' => 'The code field is required.',
            'formData.code.unique' => 'The code has already been taken.',
            'formData.name.required' => 'The name field is required.',
            'formData.country.required' => 'The country field is required.',
        ];
    }

    public function render()
    {
        return view('livewire.super-admin.state.state-index', [
            'states' => $this->results,
            'columns' => $this->getTableColumns(),
        ])->layout('layouts.dashboard');
    }
}
