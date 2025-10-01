<?php
namespace App\Livewire\Organization\Notifications;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout as AttributesLayout;
use Livewire\Component;

#[AttributesLayout('layouts.dashboard')]
class AllOrganizationNotificationsComponent extends Component
{
    public $notifications;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $user = Auth::user();

        $organizationUserIds = \App\Models\User::where('organization_id', $user->organization_id)
            ->pluck('id')
            ->toArray();

        $this->notifications = \Illuminate\Notifications\DatabaseNotification::query()
            ->whereIn('notifiable_id', $organizationUserIds)
            ->where('notifiable_type', \App\Models\User::class)
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
        return view('livewire.organization.notifications.all-organization-notifications-component');
    }
}
