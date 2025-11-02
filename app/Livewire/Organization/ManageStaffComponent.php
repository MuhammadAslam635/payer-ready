<?php

namespace App\Livewire\Organization;

use App\Enums\UserType;
use App\Models\User;
use App\Models\State;
use App\Models\Specialty;
use Illuminate\Support\Facades\Auth;
use App\Traits\Admin\CrudTrait;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\Attributes\Layout as AttributesLayout;

#[AttributesLayout('layouts.dashboard')]
class ManageStaffComponent extends Component
{
    use CrudTrait;
    public $states = [];
    public $specialties = [];
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $search = '';

    protected function getModelClass(): string
    {
        return User::class;
    }

    protected function getFormFields(): array
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'user_type' => 'User Type',
            'password' => 'Password',
            'taxnomy_code' => 'Taxonomy Code',
            'speciality_id' => 'Primary Specialty',
            'state_id' => 'Primary State',
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'user_type' => 'User Type',
            'created_at' => 'Created At',
        ];
    }

    protected function getSearchableFields(): array
    {
        return ['name', 'email'];
    }

    protected function rules(): array
    {
        $rules = [
            'formData.name' => 'required|string|max:255',
            'formData.email' => 'required|email|max:255|unique:users,email',
            'formData.user_type' => 'required|in:' . implode(',', $this->getAllowedUserTypes()),
            'formData.taxnomy_code' => 'nullable|string|max:255',
            'formData.speciality_id' => 'nullable|exists:specialties,id',
            'formData.state_id' => 'nullable|exists:states,id',
        ];

        // Password is required only when creating new user
        if (!$this->editing) {
            $rules['formData.password'] = 'required|string|min:8';
        } else {
            // When editing, password is optional but must meet requirements if provided
            $rules['formData.password'] = 'nullable|string|min:8';
            // Update email validation to exclude current user
            $rules['formData.email'] = 'required|email|max:255|unique:users,email,' . $this->modelId;
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'formData.name.required' => 'The name field is required.',
            'formData.email.required' => 'The email field is required.',
            'formData.email.email' => 'Please enter a valid email address.',
            'formData.email.unique' => 'This email is already taken.',
            'formData.user_type.required' => 'The user type field is required.',
            'formData.user_type.in' => 'Please select a valid user type.',
            'formData.password.required' => 'The password field is required.',
            'formData.password.min' => 'The password must be at least 8 characters.',
        ];
    }

    public function mount()
    {
        $this->resetForm();
        $this->states = State::orderBy('name')->get(['id','name']);
        $this->specialties = Specialty::orderBy('name')->get(['id','name']);
    }

    public function resetForm()
    {
        $this->formData = [];
        $this->editing = false;
        $this->modelId = null;
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->resetErrorBag();

        // Set default user type to DOCTOR
        $this->formData['user_type'] = UserType::DOCTOR->value;
    }

    public function save()
    {
        $this->validate();

        // Trim string values in formData
        $this->formData = array_map(function ($value) {
            return is_string($value) ? trim($value) : $value;
        }, $this->formData);

        if ($this->editing) {
            $user = User::findOrFail($this->modelId);
            $updateData = [
                'name' => $this->formData['name'],
                'email' => $this->formData['email'],
                'user_type' => $this->formData['user_type'],
                'taxnomy_code' => $this->formData['taxnomy_code'] ?? null,
                'speciality_id' => $this->formData['speciality_id'] ?? null,
                'state_id' => $this->formData['state_id'] ?? null,
            ];

            // Only update password if provided
            if (!empty($this->formData['password'])) {
                $updateData['password'] = Hash::make($this->formData['password']);
            }

            $user->update($updateData);
            $this->toastSuccess('Staff member updated successfully.');
        } else {
            User::create([
                'name' => $this->formData['name'],
                'email' => $this->formData['email'],
                'user_type' => $this->formData['user_type'],
                'password' => Hash::make($this->formData['password']),
                'is_active' => true,
                'email_verified_at' => now(),
                'is_org' => false,
                'taxnomy_code' => $this->formData['taxnomy_code'] ?? null,
                'speciality_id' => $this->formData['speciality_id'] ?? null,
                'state_id' => $this->formData['state_id'] ?? null,
                'org_id' => Auth::id(),
            ]);
            $this->toastSuccess('Staff member created successfully.');
        }

        $this->resetForm();
    }

    /**
     * Get allowed user types (only DOCTOR and ORGANIZATION_COORDINATOR)
     */
    private function getAllowedUserTypes(): array
    {
        return [
            UserType::DOCTOR->value,
            UserType::ORGANIZATION_COORDINATOR->value,
        ];
    }

    /**
     * Get user type options for the dropdown
     */
    public function getUserTypeOptions(): array
    {
        $allowedTypes = $this->getAllowedUserTypes();
        $allOptions = UserType::options();

        // Filter to only include allowed types
        return array_intersect_key($allOptions, array_flip($allowedTypes));
    }

    /**
     * Show edit modal
     */
    public function edit($id)
    {
        $modelClass = $this->getModelClass();
        $model = $modelClass::findOrFail($id);

        $this->formData = $model->only(array_keys($this->getFormFields()));

        // Convert UserType enum to string value for form binding
        if (isset($this->formData['user_type']) && $this->formData['user_type'] instanceof UserType) {
            $this->formData['user_type'] = $this->formData['user_type']->value;
        }

        $this->editing = true;
        $this->modelId = $id;
        $this->showModal = true;
    }

    /**
     * Override the query to only show doctors and organization coordinators
     */
    public function getResultsProperty()
    {
        $query = $this->getModelClass()::query();

        // Limit to staff created by the authenticated organization admin
        $query->where('org_id', Auth::id());

        // Filter by allowed user types
        $query->whereIn('user_type', $this->getAllowedUserTypes());

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
        if ($this->sortField) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.organization.manage-staff-component');
    }
}
