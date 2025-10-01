<?php
namespace App\Livewire\SuperAdmin;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout as AttributesLayout;
use Livewire\Component;
use Livewire\WithPagination;

#[AttributesLayout('layouts.dashboard')]
class SuperAdminNotificationComponent extends Component
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

    public function loadNotifications()
    {
        $query = \Illuminate\Notifications\DatabaseNotification::query();

        // Search functionality
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereRaw("(data->>'title')::text ILIKE '%' || ? || '%'", [$this->search])
                  ->orWhereRaw("(data->>'message')::text ILIKE '%' || ? || '%'", [$this->search])
                  ->orWhereRaw("(data->>'task_name')::text ILIKE '%' || ? || '%'", [$this->search])
                  ->orWhereRaw("(data->>'assigned_by')::text ILIKE '%' || ? || '%'", [$this->search]);
            });
        }

        // Sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function markAsRead($notificationId)
    {
        $notification = \Illuminate\Notifications\DatabaseNotification::find($notificationId);
        
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        $query = \Illuminate\Notifications\DatabaseNotification::query()
            ->whereNull('read_at');

        // Apply search filter if active
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereRaw("(data->>'title')::text ILIKE '%' || ? || '%'", [$this->search])
                  ->orWhereRaw("(data->>'message')::text ILIKE '%' || ? || '%'", [$this->search])
                  ->orWhereRaw("(data->>'task_name')::text ILIKE '%' || ? || '%'", [$this->search])
                  ->orWhereRaw("(data->>'assigned_by')::text ILIKE '%' || ? || '%'", [$this->search]);
            });
        }

        $query->update(['read_at' => now()]);
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.super-admin.super-admin-notification-component', [
            'notifications' => $this->loadNotifications()
        ]);
    }
}