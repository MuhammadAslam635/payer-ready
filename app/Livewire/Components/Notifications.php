<?php
namespace App\Livewire\Components;

use App\Enums\UserType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    public $notifications = [];
    public $show          = false;
    public $unreadCount   = 0;

    protected $listeners = [
        'open-notifications'    => 'toggle',
        'notification-added'    => 'addNotification',
        'notification-read'     => 'markAsRead',
        'notification-deleted'  => 'removeNotification',
        'refresh-notifications' => 'loadNotifications',
    ];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (! Auth::check()) {
            $this->notifications = collect([]);
            $this->unreadCount   = 0;
            return;
        }

        $user = Auth::user();

        // Get notifications based on user type
        switch ($user->user_type) {
            case \App\Enums\UserType::SUPER_ADMIN:
                // Super Admin sees all notifications from all users
                $dbNotifications = \Illuminate\Notifications\DatabaseNotification::query()
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
                    ->get();
                break;

            case \App\Enums\UserType::ORGANIZATION_ADMIN:
                // Organization Admin sees notifications for their organization's users
                $organizationUserIds = \App\Models\User::where('organization_id', $user->organization_id)
                    ->pluck('id')
                    ->toArray();

                $dbNotifications = \Illuminate\Notifications\DatabaseNotification::query()
                    ->whereIn('notifiable_id', $organizationUserIds)
                    ->where('notifiable_type', \App\Models\User::class)
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
                    ->get();
                break;

            case \App\Enums\UserType::DOCTOR:
            default:
                // Doctor and other users see only their own notifications
                $dbNotifications = $user->notifications()
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
                    ->get();
                break;
        }

        $this->notifications = $dbNotifications->map(function ($notification) {
            $data = $notification->data;
            return [
                'id'         => $notification->id,
                'title'      => $data['title'] ?? 'Notification',
                'message'    => $data['message'] ?? '',
                'type'       => $data['type'] ?? 'info',
                'url'        => $data['url'] ?? '#',
                'read'       => ! is_null($notification->read_at),
                'created_at' => Carbon::parse($notification->created_at)->diffForHumans(),
            ];
        });

        $this->unreadCount = $this->notifications->where('read', false)->count();
    }

    public function toggle()
    {
        $this->show = ! $this->show;
    }

    public function addNotification($notification)
{
    $formattedNotification = [
        'id'         => $notification['id'] ?? uniqid(),
        'title'      => $notification['title'] ?? 'Notification',
        'message'    => $notification['message'] ?? '',
        'type'       => $notification['type'] ?? 'info',
        'url'        => $notification['url'] ?? '#',
        'read'       => $notification['read'] ?? false,
        'created_at' => $notification['created_at'] ?? now()->diffForHumans(),
    ];

    $this->notifications->prepend($formattedNotification);
    $this->unreadCount++;
}

    public function markAsRead($notificationId)
    {
        if (! Auth::check()) {
            return;
        }

        // Mark notification as read in database
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification && is_null($notification->read_at)) {
            $notification->markAsRead();
            $this->loadNotifications(); // Refresh notifications
        }
    }

    public function markAllAsRead()
    {
        if (! Auth::check()) {
            return;
        }

        // Mark all unread notifications as read
        Auth::user()->unreadNotifications->markAsRead();
        $this->loadNotifications(); // Refresh notifications
    }

    public function removeNotification($notificationId)
    {
        if (! Auth::check()) {
            return;
        }

        // Delete notification from database
        if (Auth::user()->user_type === UserType::DOCTOR) {
            $notification = Auth::user()->notifications()->find($notificationId);
        } elseif (Auth::user()->user_type === UserType::ORGANIZATION_ADMIN) {
            $notification = Auth::user()->organization()->notifications()->find($notificationId);
        } elseif (Auth::user()->user_type === UserType::SUPER_ADMIN) {
            $notification = Auth::user()->notifications()->find($notificationId);
        }
        if ($notification) {
            $notification->delete();
            $this->loadNotifications(); // Refresh notifications
        }
    }

    public function getNotificationIcon($type)
    {
        return match ($type) {
            'success' => 'check-circle',
            'warning' => 'exclamation-triangle',
            'error'   => 'x-circle',
            'info'    => 'information-circle',
            default   => 'bell'
        };
    }

    public function getNotificationColor($type)
    {
        return match ($type) {
            'success' => 'text-green-400',
            'warning' => 'text-yellow-400',
            'error'   => 'text-red-400',
            'info'    => 'text-blue-400',
            default   => 'text-gray-400'
        };
    }

    public function render()
    {
        return view('livewire.components.notifications');
    }
}
