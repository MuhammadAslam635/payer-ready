<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

#[Layout('layouts.dashboard')]
class DoctorNotificationComponent extends Component
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
        
        if (!$user) {
            return collect()->paginate($this->perPage);
        }

        $query = DatabaseNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', \App\Models\User::class);

        // Apply search filter
        // if ($this->search) {
        //     $query->where(function ($q) {
        //         $q->whereRaw("(data->>'title')::text ILIKE '%' || ? || '%'", [$this->search])
        //           ->orWhereRaw("(data->>'message')::text ILIKE '%' || ? || '%'", [$this->search])
        //           ->orWhereRaw("(data->>'task_details')::text ILIKE '%' || ? || '%'", [$this->search]);
        //     });
        // }

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
        $notification = DatabaseNotification::where('id', $notificationId)
            ->where('notifiable_id', Auth::id())
            ->first();
            
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        
        if (!$user) {
            return;
        }

        $query = DatabaseNotification::where('notifiable_id', $user->id)
            ->where('notifiable_type', \App\Models\User::class)
            ->whereNull('read_at');

        // Apply search filter if active
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereRaw("(data->>'title')::text ILIKE '%' || ? || '%'", [$this->search])
                  ->orWhereRaw("(data->>'message')::text ILIKE '%' || ? || '%'", [$this->search])
                  ->orWhereRaw("(data->>'task_details')::text ILIKE '%' || ? || '%'", [$this->search]);
            });
        }

        $query->update(['read_at' => now()]);
    }

    public function render()
    {
        return view('livewire.doctor.doctor-notification-component', [
            'notifications' => $this->loadNotifications()
        ]);
    }
}