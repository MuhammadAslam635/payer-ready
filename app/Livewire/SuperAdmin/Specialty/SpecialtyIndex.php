<?php

namespace App\Livewire\SuperAdmin\Specialty;

use App\Models\Specialty;
use App\Traits\Admin\CrudTrait;
use Livewire\Component;

class SpecialtyIndex extends Component
{
    use CrudTrait;

    protected function getModelClass(): string
    {
        return Specialty::class;
    }

    protected function getFormFields(): array
    {
        return [
            'code' => '',
            'name' => '',
            'taxonomy_code' => '',
            'description' => '',
            'is_active' => true,
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'taxonomy_code' => 'Taxonomy Code',
            'description' => 'Description',
            'is_active' => 'Status',
        ];
    }

    protected function getSearchableFields(): array
    {
        return ['code', 'name', 'taxonomy_code', 'description'];
    }

    protected function rules(): array
    {
        return [
            'formData.code' => 'required|string|max:10|unique:specialties,code,' . $this->modelId,
            'formData.name' => 'required|string|max:255',
            'formData.taxonomy_code' => 'nullable|string|max:20',
            'formData.description' => 'nullable|string|max:1000',
            'formData.is_active' => 'boolean',
        ];
    }

    protected function messages(): array
    {
        return [
            'formData.code.required' => 'The code field is required.',
            'formData.code.unique' => 'The code has already been taken.',
            'formData.name.required' => 'The name field is required.',
        ];
    }

    public function render()
    {
        return view('livewire.super-admin.specialty.specialty-index', [
            'specialties' => $this->results,
            'columns' => $this->getTableColumns(),
        ])->layout('layouts.dashboard');
    }
}
