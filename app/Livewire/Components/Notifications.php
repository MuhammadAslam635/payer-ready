<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Notifications extends Component
{
    public $notifications = [];
    public $show = false;
    public $unreadCount = 0;

    protected $listeners = [
        'open-notifications' => 'toggle',
        'notification-added' => 'addNotification',
        'notification-read' => 'markAsRead',
        'notification-deleted' => 'removeNotification'
    ];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        // Load notifications from database or session
        // This is a placeholder - implement based on your notification system
        $this->notifications = collect([
            [
                'id' => 1,
                'title' => 'New Application Submitted',
                'message' => 'Dr. John Smith has submitted a new credentialing application.',
                'type' => 'info',
                'read' => false,
                'created_at' => now()->subMinutes(5)
            ],
            [
                'id' => 2,
                'title' => 'License Expiring Soon',
                'message' => 'Dr. Jane Doe\'s medical license expires in 30 days.',
                'type' => 'warning',
                'read' => false,
                'created_at' => now()->subHours(2)
            ],
            [
                'id' => 3,
                'title' => 'Application Approved',
                'message' => 'Dr. Mike Johnson\'s application has been approved.',
                'type' => 'success',
                'read' => true,
                'created_at' => now()->subDays(1)
            ]
        ]);

        $this->unreadCount = $this->notifications->where('read', false)->count();
    }

    public function toggle()
    {
        $this->show = !$this->show;
    }

    public function addNotification($notification)
    {
        $this->notifications->prepend($notification);
        $this->unreadCount++;
    }

    public function markAsRead($notificationId)
    {
        $notification = $this->notifications->firstWhere('id', $notificationId);
        if ($notification && !$notification['read']) {
            $notification['read'] = true;
            $this->unreadCount--;
        }
    }

    public function markAllAsRead()
    {
        $this->notifications->transform(function ($notification) {
            $notification['read'] = true;
            return $notification;
        });
        $this->unreadCount = 0;
    }

    public function removeNotification($notificationId)
    {
        $notification = $this->notifications->firstWhere('id', $notificationId);
        if ($notification && !$notification['read']) {
            $this->unreadCount--;
        }
        $this->notifications = $this->notifications->reject(function ($notification) use ($notificationId) {
            return $notification['id'] === $notificationId;
        });
    }

    public function getNotificationIcon($type)
    {
        return match($type) {
            'success' => 'check-circle',
            'warning' => 'exclamation-triangle',
            'error' => 'x-circle',
            'info' => 'information-circle',
            default => 'bell'
        };
    }

    public function getNotificationColor($type)
    {
        return match($type) {
            'success' => 'text-green-400',
            'warning' => 'text-yellow-400',
            'error' => 'text-red-400',
            'info' => 'text-blue-400',
            default => 'text-gray-400'
        };
    }

    public function render()
    {
        return view('livewire.components.notifications');
    }
}
