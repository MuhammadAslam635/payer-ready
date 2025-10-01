<?php

namespace App\Livewire\SuperAdmin\Payer;

use App\Traits\Admin\CrudTrait;
use Livewire\Component;
use Livewire\Attributes\Layout as AttributesLayout;
use App\Models\Payer;
use Illuminate\Support\Str;
#[AttributesLayout('layouts.dashboard')]
class PayerIndexComponent extends Component
{
    use CrudTrait;
    protected $model = Payer::class;
    protected function getModelClass(): string
    {
        return $this->model;
    }

    protected function getFormFields(): array
    {
        return [
            'name' => '',
            'slug' => '',
            'type' => '',
            'description' => '',
            'default_amount' => 0.00,
            'is_active' => true,
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            'name' => 'Name',
            'slug' => 'Slug',
            'type' => 'Payer Type',
            'description' => 'Description',
            'default_amount' => 'Default Amount',
            'is_active' => 'Status',
        ];
    }

    protected function getSearchableFields(): array
    {
        return ['name', 'slug', 'type', 'description'];
    }

    protected function rules(): array
    {
        $uniqueRule = 'required|string|max:10|unique:payers,slug';
        if ($this->editing && $this->modelId) {
            $uniqueRule .= ',' . $this->modelId;
        }

        return [
            'formData.slug' => $uniqueRule,
            'formData.name' => 'required|string|max:255',
            'formData.type' => 'required|in:government,commercial',
            'formData.description' => 'nullable|string|max:500',
            'formData.default_amount' => 'required|numeric|min:0|max:999999.99',
            'formData.is_active' => 'boolean',
        ];
    }

    protected function messages(): array
    {
        return [
            'formData.slug.required' => 'The slug field is required.',
            'formData.slug.unique' => 'The slug has already been taken.',
            'formData.name.required' => 'The name field is required.',
            'formData.type.required' => 'The payer type field is required.',
            'formData.type.in' => 'The payer type must be either government or commercial.',
            'formData.default_amount.required' => 'The default amount field is required.',
            'formData.default_amount.numeric' => 'The default amount must be a valid number.',
            'formData.default_amount.min' => 'The default amount must be at least 0.',
        ];
    }
    // public function genSlug()
    // {
    //     // if (!empty($this->formData['name'])) {
    //         $this->formData['slug'] = Str::slug($this->formData['name']);
    //         // Force Livewire to update the component
    //         $this->dispatch('slug-updated');
    //     // }
    // }

    public function render()
    {
        return view('livewire.super-admin.payer.payer-index-component', [
            'payers' => $this->results,
            'columns' => $this->getTableColumns(),
        ]);
    }
}
