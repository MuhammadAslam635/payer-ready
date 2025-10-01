<?php

namespace App\Livewire\SuperAdmin\Notifcations;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout as AttributesLayout;

#[AttributesLayout('layouts.dashboard')]
class AllNotificationComponent extends Component
{
    public $notifications;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $user = Auth::user();
        
       $this->notifications = \Illuminate\Notifications\DatabaseNotification::query()
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications(); // Refresh the list
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->loadNotifications(); // Refresh the list
    }
    public function render()
    {
        return view('livewire.super-admin.notifcations.all-notification-component');
    }
}
