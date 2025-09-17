<?php

namespace App\Traits\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait CrudTrait
{
    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $showModal = false;
    public $editing = false;
    public $modelId = null;
    public $formData = [];
    public $showDeleteModal = false;
    public $deleteId = null;

    protected $rules = [];
    protected $messages = [];

    /**
     * Get the model class for this CRUD operation
     */
    abstract protected function getModelClass(): string;

    /**
     * Get the form fields for create/edit
     */
    abstract protected function getFormFields(): array;

    /**
     * Get the table columns for listing
     */
    abstract protected function getTableColumns(): array;

    /**
     * Get the searchable fields
     */
    abstract protected function getSearchableFields(): array;

    /**
     * Mount the component
     */
    public function mount()
    {
        $this->resetForm();
    }

    /**
     * Reset form data
     */
    public function resetForm()
    {
        $this->formData = [];
        $this->editing = false;
        $this->modelId = null;
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->resetErrorBag();
    }

    /**
     * Show create modal
     */
    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    /**
     * Show edit modal
     */
    public function edit($id)
    {
        $modelClass = $this->getModelClass();
        $model = $modelClass::findOrFail($id);

        $this->formData = $model->only(array_keys($this->getFormFields()));
        $this->editing = true;
        $this->modelId = $id;
        $this->showModal = true;
    }

    /**
     * Save the model
     */
    public function save()
    {
        $this->validate();

        // Trim string values in formData
        $this->formData = array_map(function ($value) {
            return is_string($value) ? trim($value) : $value;
        }, $this->formData);

        $modelClass = $this->getModelClass();

        if ($this->editing) {
            $model = $modelClass::findOrFail($this->modelId);
            $model->update($this->formData);
            session()->flash('message', 'Record updated successfully.');
        } else {
            $modelClass::create($this->formData);
            session()->flash('message', 'Record created successfully.');
        }

        $this->resetForm();
    }

    /**
     * Show delete confirmation modal
     */
    public function delete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    /**
     * Confirm delete
     */
    public function confirmDelete()
    {
        $modelClass = $this->getModelClass();
        $model = $modelClass::findOrFail($this->deleteId);
        $model->delete();

        session()->flash('message', 'Record deleted successfully.');
        $this->resetForm();
    }

    /**
     * Cancel delete
     */
    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    /**
     * Sort by field
     */
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Update per page
     */
    public function updatedPerPage()
    {
        $this->resetPage();
    }

    /**
     * Update search
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /**
     * Get paginated results
     */
    public function getResultsProperty(): LengthAwarePaginator
    {
        $modelClass = $this->getModelClass();
        $query = $modelClass::query();

        // Apply search
        if ($this->search) {
            $searchableFields = $this->getSearchableFields();
            $query->where(function ($q) use ($searchableFields) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    /**
     * Get the sort direction icon
     */
    public function getSortIcon($field): string
    {
        if ($this->sortField !== $field) {
            return 'heroicon-o-chevron-up-down';
        }

        return $this->sortDirection === 'asc'
            ? 'heroicon-o-chevron-up'
            : 'heroicon-o-chevron-down';
    }

    /**
     * Get the sort direction class
     */
    public function getSortClass($field): string
    {
        if ($this->sortField !== $field) {
            return 'text-gray-400';
        }

        return 'text-primary-600';
    }
}
