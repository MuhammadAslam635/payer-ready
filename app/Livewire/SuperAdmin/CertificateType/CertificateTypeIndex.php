<?php

namespace App\Livewire\SuperAdmin\CertificateType;

use App\Models\CertificateType;
use App\Traits\Admin\CrudTrait;
use Livewire\Component;
use Livewire\Attributes\Layout as AttributesLayout;

#[AttributesLayout('layouts.dashboard')]
class CertificateTypeIndex extends Component
{
    use CrudTrait;

    protected function getModelClass(): string
    {
        return CertificateType::class;
    }

    protected function getFormFields(): array
    {
        return [
            'name' => '',
            'certificate_number' => '',
            'description' => '',
            'issuing_organization' => '',
            'issue_date' => '',
            'expiry_date' => '',
            'requires_renewal' => true,
            'is_active' => true,
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            'certificate_number' => 'Certificate Number',
            'name' => 'Name',
            'issuing_organization' => 'Issuing Organization',
            'issue_date' => 'Issue Date',
            'expiry_date' => 'Expiry Date',
            'requires_renewal' => 'Requires Renewal',
            'is_active' => 'Status',
        ];
    }

    protected function getSearchableFields(): array
    {
        return ['certificate_number', 'name', 'description', 'issuing_organization'];
    }

    protected function rules(): array
    {
        $modelId = $this->modelId ?: 'NULL';
        
        return [
            'formData.name' => 'required|string|max:255',
            'formData.certificate_number' => 'required|string|max:255|unique:certificate_types,certificate_number,' . $modelId,
            'formData.description' => 'nullable|string|max:1000',
            'formData.issuing_organization' => 'required|string|max:255',
            'formData.issue_date' => 'required|date',
            'formData.expiry_date' => 'required|date|after:formData.issue_date',
            'formData.requires_renewal' => 'boolean',
            'formData.is_active' => 'boolean',
        ];
    }

    protected function messages(): array
    {
        return [
            'formData.name.required' => 'The name field is required.',
            'formData.certificate_number.required' => 'The certificate number field is required.',
            'formData.certificate_number.unique' => 'The certificate number has already been taken.',
            'formData.issuing_organization.required' => 'The issuing organization field is required.',
            'formData.issue_date.required' => 'The issue date field is required.',
            'formData.issue_date.date' => 'The issue date must be a valid date.',
            'formData.expiry_date.required' => 'The expiry date field is required.',
            'formData.expiry_date.date' => 'The expiry date must be a valid date.',
            'formData.expiry_date.after' => 'The expiry date must be after the issue date.',
        ];
    }

    public function toggleStatus($id)
    {
        $certificateType = CertificateType::findOrFail($id);
        $certificateType->update(['is_active' => !$certificateType->is_active]);
        
        $status = $certificateType->is_active ? 'activated' : 'deactivated';
        $this->toastSuccess("Certificate type {$status} successfully.");
    }

    public function render()
    {
        return view('livewire.super-admin.certificate-type.certificate-type-index', [
            'certificateTypes' => $this->results,
            'columns' => $this->getTableColumns(),
        ]);
    }
}
