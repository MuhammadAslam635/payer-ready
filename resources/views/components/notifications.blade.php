@props(['position' => 'bottom-right'])

@php
    $positionClasses = match($position) {
        'top-right' => 'top-4 right-4',
        'top-left' => 'top-4 left-4',
        'bottom-right' => 'bottom-4 right-4',
        'bottom-left' => 'bottom-4 left-4',
        default => 'bottom-4 right-4'
    };
@endphp

<!-- Notification Container -->
<div id="notification-container" class="fixed {{ $positionClasses }} z-50 space-y-2">
    <!-- Notifications will be dynamically added here -->
</div>

<!-- Notification Bell (Fixed Position) -->
<div class="fixed bottom-20 right-4 z-50">
    <button onclick="toggleNotificationPanel()" class="relative p-3 bg-white rounded-full shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-200">
        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5L9 15l4.5 4.5M9 15v-3a6 6 0 1112 0v3"/>
        </svg>

        <span id="notification-badge" class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-medium text-white hidden">
            0
        </span>
    </button>
</div>

<!-- Notification Panel -->
<div id="notification-panel" class="fixed bottom-32 right-4 z-50 w-80 max-w-sm hidden">
    <div class="bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden">
        <!-- Header -->
        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
            <div class="flex items-center space-x-2">
                <button onclick="markAllAsRead()" class="text-xs text-blue-600 hover:text-blue-800">
                    Mark all read
                </button>
                <button onclick="toggleNotificationPanel()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Notifications List -->
        <div id="notifications-list" class="max-h-96 overflow-y-auto">
            <!-- Notifications will be loaded here -->
        </div>

        <!-- Footer -->
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800">
                View all notifications
            </a>
        </div>
    </div>
</div>

<!-- Backdrop -->
<div id="notification-backdrop" class="fixed inset-0 z-40 hidden" onclick="toggleNotificationPanel()"></div>

<script>
    let notifications = [];
    let unreadCount = 0;

    // Sample notifications data
    const sampleNotifications = [
        {
            id: 1,
            title: 'New Application Submitted',
            message: 'Dr. John Smith has submitted a new credentialing application.',
            type: 'info',
            read: false,
            created_at: new Date(Date.now() - 5 * 60 * 1000) // 5 minutes ago
        },
        {
            id: 2,
            title: 'License Expiring Soon',
            message: 'Dr. Jane Doe\'s medical license expires in 30 days.',
            type: 'warning',
            read: false,
            created_at: new Date(Date.now() - 2 * 60 * 60 * 1000) // 2 hours ago
        },
        {
            id: 3,
            title: 'Application Approved',
            message: 'Dr. Mike Johnson\'s application has been approved.',
            type: 'success',
            read: true,
            created_at: new Date(Date.now() - 24 * 60 * 60 * 1000) // 1 day ago
        }
    ];

    function initNotifications() {
        notifications = [...sampleNotifications];
        updateUnreadCount();
        renderNotifications();
    }

    function updateUnreadCount() {
        unreadCount = notifications.filter(n => !n.read).length;
        const badge = document.getElementById('notification-badge');
        if (unreadCount > 0) {
            badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }

    function renderNotifications() {
        const container = document.getElementById('notifications-list');

        if (notifications.length === 0) {
            container.innerHTML = `
                <div class="px-4 py-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5L9 15l4.5 4.5M9 15v-3a6 6 0 1112 0v3"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                    <p class="mt-1 text-sm text-gray-500">You're all caught up!</p>
                </div>
            `;
            return;
        }

        container.innerHTML = notifications.map(notification => `
            <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition-colors duration-150 ${!notification.read ? 'bg-blue-50' : ''}">
                <div class="flex items-start space-x-3">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        ${getNotificationIcon(notification.type)}
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate">
                                ${notification.title}
                            </p>
                            ${!notification.read ? '<div class="flex-shrink-0 ml-2"><div class="h-2 w-2 bg-blue-500 rounded-full"></div></div>' : ''}
                        </div>
                        <p class="text-sm text-gray-500 mt-1">
                            ${notification.message}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            ${getTimeAgo(notification.created_at)}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex-shrink-0 flex items-center space-x-1">
                        ${!notification.read ? `
                            <button onclick="markAsRead(${notification.id})" class="text-xs text-blue-600 hover:text-blue-800" title="Mark as read">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        ` : ''}
                        <button onclick="removeNotification(${notification.id})" class="text-xs text-gray-400 hover:text-red-600" title="Delete">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function getNotificationIcon(type) {
        const icons = {
            success: '<svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
            warning: '<svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>',
            error: '<svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>',
            info: '<svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>'
        };
        return icons[type] || icons.info;
    }

    function getTimeAgo(date) {
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);

        if (diffInSeconds < 60) return 'Just now';
        if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + ' minutes ago';
        if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + ' hours ago';
        return Math.floor(diffInSeconds / 86400) + ' days ago';
    }

    function toggleNotificationPanel() {
        const panel = document.getElementById('notification-panel');
        const backdrop = document.getElementById('notification-backdrop');

        if (panel.classList.contains('hidden')) {
            panel.classList.remove('hidden');
            backdrop.classList.remove('hidden');
        } else {
            panel.classList.add('hidden');
            backdrop.classList.add('hidden');
        }
    }

    function markAsRead(id) {
        const notification = notifications.find(n => n.id === id);
        if (notification && !notification.read) {
            notification.read = true;
            updateUnreadCount();
            renderNotifications();
        }
    }

    function markAllAsRead() {
        notifications.forEach(notification => {
            notification.read = true;
        });
        updateUnreadCount();
        renderNotifications();
    }

    function removeNotification(id) {
        const notification = notifications.find(n => n.id === id);
        if (notification && !notification.read) {
            unreadCount--;
        }
        notifications = notifications.filter(n => n.id !== id);
        updateUnreadCount();
        renderNotifications();
    }

    function addNotification(notification) {
        notification.id = Date.now();
        notification.read = false;
        notification.created_at = new Date();
        notifications.unshift(notification);
        updateUnreadCount();
        renderNotifications();
    }

    // Initialize notifications when page loads
    document.addEventListener('DOMContentLoaded', initNotifications);

    // Global functions for external use
    window.showNotification = function(title, message, type = 'info') {
        addNotification({ title, message, type });
    };

    window.toggleNotifications = function() {
        toggleNotificationPanel();
    };
</script>
