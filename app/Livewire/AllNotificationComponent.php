<?php
namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout as AttributesLayout;
use Livewire\Component;
use Livewire\WithPagination;

#[AttributesLayout('layouts.dashboard')]
class AllNotificationComponent extends Component
{
    use WithPagination;

    public function loadNotifications()
    {
        $user = Auth::user();
        
        // Get notifications based on user type
        switch ($user->user_type) {
            case \App\Enums\UserType::SUPER_ADMIN:
                // Super Admin sees all notifications from all users
                return \Illuminate\Notifications\DatabaseNotification::query()
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
                
            case \App\Enums\UserType::ORGANIZATION_ADMIN:
                // Organization Admin sees notifications for their organization's users
                $organizationUserIds = \App\Models\User::where('organization_id', $user->organization_id)
                    ->pluck('id')
                    ->toArray();
                    
                return \Illuminate\Notifications\DatabaseNotification::query()
                    ->whereIn('notifiable_id', $organizationUserIds)
                    ->where('notifiable_type', \App\Models\User::class)
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
                
            case \App\Enums\UserType::DOCTOR:
            default:
                // Doctor and other users see only their own notifications
                return $user->notifications()
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
        }
    }

    public function markAsRead($notificationId)
    {
        $user = Auth::user();
        
        // Find notification based on user type
        switch ($user->user_type) {
            case \App\Enums\UserType::SUPER_ADMIN:
                $notification = \Illuminate\Notifications\DatabaseNotification::find($notificationId);
                break;
                
            case \App\Enums\UserType::ORGANIZATION_ADMIN:
                $organizationUserIds = \App\Models\User::where('organization_id', $user->organization_id)
                    ->pluck('id')
                    ->toArray();
                    
                $notification = \Illuminate\Notifications\DatabaseNotification::query()
                    ->whereIn('notifiable_id', $organizationUserIds)
                    ->where('notifiable_type', \App\Models\User::class)
                    ->find($notificationId);
                break;
                
            case \App\Enums\UserType::DOCTOR:
            default:
                $notification = $user->notifications()->find($notificationId);
                break;
        }
        
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        $user = Auth::user();
        
        // Mark all notifications as read based on user type
        switch ($user->user_type) {
            case \App\Enums\UserType::SUPER_ADMIN:
                \Illuminate\Notifications\DatabaseNotification::query()
                    ->whereNull('read_at')
                    ->update(['read_at' => now()]);
                break;
                
            case \App\Enums\UserType::ORGANIZATION_ADMIN:
                $organizationUserIds = \App\Models\User::where('organization_id', $user->organization_id)
                    ->pluck('id')
                    ->toArray();
                    
                \Illuminate\Notifications\DatabaseNotification::query()
                    ->whereIn('notifiable_id', $organizationUserIds)
                    ->where('notifiable_type', \App\Models\User::class)
                    ->whereNull('read_at')
                    ->update(['read_at' => now()]);
                break;
                
            case \App\Enums\UserType::DOCTOR:
            default:
                $user->unreadNotifications->markAsRead();
                break;
        }
    }

    public function render()
    {
        $notifications = $this->loadNotifications();
        return view('livewire.all-notification-component', compact('notifications'));
    }
}
