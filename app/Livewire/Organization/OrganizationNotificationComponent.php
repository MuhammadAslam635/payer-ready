<?php

namespace App\Livewire\Organization;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class OrganizationNotificationComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 15;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 15],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function loadNotifications()
    {
        $user = Auth::user();
        
        // Create a query that will return empty results if no user or organization_id
        $query = DatabaseNotification::query();
        
        if (!$user || !$user->organization_id) {
            // Return empty paginated result
            return $query->whereRaw('1 = 0')->paginate($this->perPage);
        }

        $query = DatabaseNotification::whereHasMorph('notifiable', ['App\Models\User'], function ($query) use ($user) {
            $query->where('organization_id', $user->organization_id);
        });

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereRaw("(data->>'title')::text ILIKE '%' || ? || '%'", [$this->search])
                  ->orWhereRaw("(data->>'message')::text ILIKE '%' || ? || '%'", [$this->search])
                  ->orWhereRaw("(data->>'task_details')::text ILIKE '%' || ? || '%'", [$this->search]);
            });
        }

        // Apply sorting
        if ($this->sortBy === 'read_at') {
            $query->orderByRaw('read_at IS NULL DESC, read_at ' . $this->sortDirection);
        } else {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        return $query->paginate($this->perPage);
    }

    public function markAsRead($notificationId)
    {
        $notification = DatabaseNotification::find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        
        if (!$user || !$user->organization_id) {
            return;
        }

        DatabaseNotification::whereHasMorph('notifiable', ['App\Models\User'], function ($query) use ($user) {
            $query->where('organization_id', $user->organization_id);
        })->whereNull('read_at');

        // Apply search filter if active
        if ($this->search) {
            $query = DatabaseNotification::whereHasMorph('notifiable', ['App\Models\User'], function ($query) use ($user) {
                $query->where('organization_id', $user->organization_id);
            })->whereNull('read_at')
            ->where(function ($q) {
                $q->whereRaw("(data->>'title')::text ILIKE '%' || ? || '%'", [$this->search])
                  ->orWhereRaw("(data->>'message')::text ILIKE '%' || ? || '%'", [$this->search])
                  ->orWhereRaw("(data->>'task_details')::text ILIKE '%' || ? || '%'", [$this->search]);
            });
            
            $query->update(['read_at' => now()]);
        } else {
            DatabaseNotification::whereHasMorph('notifiable', ['App\Models\User'], function ($query) use ($user) {
                $query->where('organization_id', $user->organization_id);
            })->whereNull('read_at')->update(['read_at' => now()]);
        }
    }

    public function render()
    {
        return view('livewire.organization.organization-notification-component', [
            'notifications' => $this->loadNotifications()
        ]);
    }
}