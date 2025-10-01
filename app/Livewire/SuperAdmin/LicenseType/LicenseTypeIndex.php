<?php

namespace App\Livewire\SuperAdmin\LicenseType;

use App\Models\LicenseType;
use App\Traits\Admin\CrudTrait;
use Livewire\Component;

use Livewire\Attributes\Layout as AttributesLayout;

#[AttributesLayout('layouts.dashboard')]
class LicenseTypeIndex extends Component
{
    use CrudTrait;

    protected function getModelClass(): string
    {
        return LicenseType::class;
    }

    protected function getFormFields(): array
    {
        return [
            'name' => '',
            'code' => '',
            'description' => '',
            'issuing_authority' => '',
            'validity_years' => 1,
            'default_amount' => 0.00,
            'requires_renewal' => true,
            'is_active' => true,
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'issuing_authority' => 'Issuing Authority',
            'validity_years' => 'Validity (Years)',
            'default_amount' => 'Default Amount',
            'requires_renewal' => 'Requires Renewal',
            'is_active' => 'Status',
        ];
    }

    protected function getSearchableFields(): array
    {
        return ['code', 'name', 'description', 'issuing_authority'];
    }

    protected function rules(): array
    {
        $modelId = $this->modelId ?: 'NULL';
        
        return [
            'formData.name' => 'required|string|max:255',
            'formData.code' => 'required|string|max:20|unique:license_types,code,' . $modelId,
            'formData.description' => 'nullable|string|max:1000',
            'formData.issuing_authority' => 'required|string|max:255',
            'formData.validity_years' => 'required|integer|min:1|max:100',
            'formData.default_amount' => 'required|numeric|min:0|max:999999.99',
            'formData.requires_renewal' => 'boolean',
            'formData.is_active' => 'boolean',
        ];
    }

    protected function messages(): array
    {
        return [
            'formData.name.required' => 'The name field is required.',
            'formData.code.required' => 'The code field is required.',
            'formData.code.unique' => 'The code has already been taken.',
            'formData.issuing_authority.required' => 'The issuing authority field is required.',
            'formData.validity_years.required' => 'The validity years field is required.',
            'formData.validity_years.min' => 'The validity years must be at least 1.',
            'formData.default_amount.required' => 'The default amount field is required.',
            'formData.default_amount.numeric' => 'The default amount must be a valid number.',
            'formData.default_amount.min' => 'The default amount must be at least 0.',
        ];
    }

    public function render()
    {
        return view('livewire.super-admin.license-type.license-type-index', [
            'licenseTypes' => $this->results,
            'columns' => $this->getTableColumns(),
        ]);
    }
}
