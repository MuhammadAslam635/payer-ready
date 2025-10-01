<?php

namespace App\Livewire\SuperAdmin\User;

use App\Enums\UserType;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout as AttributesLayout;


#[AttributesLayout('layouts.dashboard')]
class AdminViewAllUsersComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $userTypeFilter = '';
    public $statusFilter = '';
    public $perPage = 12;

    protected $queryString = [
        'search' => ['except' => ''],
        'userTypeFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingUserTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function toggleUserStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        session()->flash('message', "User {$user->name} has been {$status} successfully.");
    }

    public function getUsers()
    {
        return User::query()
            ->whereIn('user_type', [UserType::DOCTOR->value, UserType::ORGANIZATION_ADMIN->value])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->userTypeFilter, function ($query) {
                $query->where('user_type', $this->userTypeFilter);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter === '1');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.super-admin.user.admin-view-all-users-component', [
            'users' => $this->getUsers(),
            'userTypes' => [
                UserType::DOCTOR->value => UserType::label(UserType::DOCTOR),
                UserType::ORGANIZATION_ADMIN->value => UserType::label(UserType::ORGANIZATION_ADMIN),
            ]
        ]);
    }
}
