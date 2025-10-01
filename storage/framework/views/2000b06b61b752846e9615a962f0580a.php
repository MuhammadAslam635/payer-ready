<div>
    <!-- Notification Bell (Fixed Position) -->
    <div class="fixed bottom-20 right-4 z-50">
        <button wire:click="togglePanel" class="relative p-3 bg-white rounded-full shadow-lg hover:shadow-xl transition-shadow duration-200 border border-gray-200">
            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5L9 15l4.5 4.5M9 15v-3a6 6 0 1112 0v3"/>
            </svg>

            <!--[if BLOCK]><![endif]--><?php if($unreadCount > 0): ?>
                <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-medium text-white">
                    <?php echo e($unreadCount > 99 ? '99+' : $unreadCount); ?>

                </span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </button>
    </div>

    <!-- Notification Panel -->
    <!--[if BLOCK]><![endif]--><?php if($showPanel): ?>
        <div class="fixed bottom-32 right-4 z-50 w-80 max-w-sm">
            <div class="bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden">
                <!-- Header -->
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                    <div class="flex items-center space-x-2">
                        <!--[if BLOCK]><![endif]--><?php if($unreadCount > 0): ?>
                            <button wire:click="markAllAsRead" class="text-xs text-blue-600 hover:text-blue-800">
                                Mark all read
                            </button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <button wire:click="togglePanel" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Notifications List -->
                <div class="max-h-96 overflow-y-auto">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 <?php echo e(!$notification['read_at'] ? 'bg-blue-50' : ''); ?>">
                            <div class="flex items-start space-x-3">
                                <!-- Notification Icon -->
                                <div class="flex-shrink-0 mt-1">
                                    <!--[if BLOCK]><![endif]--><?php switch($notification['notification_type']):
                                        case ('success'): ?>
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                            <?php break; ?>
                                        <?php case ('warning'): ?>
                                            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                            <?php break; ?>
                                        <?php case ('error'): ?>
                                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                            <?php break; ?>
                                        <?php default: ?>
                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    <?php endswitch; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <!-- Notification Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900 truncate">
                                            <?php echo e($notification['title']); ?>

                                        </p>
                                        <!--[if BLOCK]><![endif]--><?php if(!$notification['read_at']): ?>
                                            <button wire:click="markAsRead('<?php echo e($notification['id']); ?>')" class="text-xs text-blue-600 hover:text-blue-800 ml-2">
                                                Mark read
                                            </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <?php echo e($notification['message']); ?>

                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        <?php echo e(\Carbon\Carbon::parse($notification['created_at'])->diffForHumans()); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-4 py-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.5 19.5L9 15l4.5 4.5M9 15v-3a6 6 0 1112 0v3"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No notifications yet</p>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- Footer -->
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
                    <a href="<?php echo e(route('notifications.all')); ?>" class="text-sm text-blue-600 hover:text-blue-800">
                        View all notifications
                    </a>
                </div>
            </div>
        </div>

        <!-- Backdrop -->
        <div class="fixed inset-0 z-40" wire:click="togglePanel"></div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Toast Notifications Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2">
        <!-- Toast notifications will be added here via JavaScript -->
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Listen for toast notifications
        window.addEventListener('show-toast', function(event) {
            showToast(event.detail.title, event.detail.message, event.detail.type);
        });

        // Listen for real-time notifications from Echo
        <!--[if BLOCK]><![endif]--><?php if(auth()->guard()->check()): ?>
        if (window.Echo && window.Laravel && window.Laravel.user) {
            window.Echo.private(`App.Models.User.${window.Laravel.user.id}`)
                .notification((notification) => {
                    console.log('Received real-time notification:', notification);
                    
                    // Dispatch to Livewire component
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('handleNewNotification', {
                        title: notification.title || 'New Notification',
                        message: notification.message || '',
                        type: notification.type || 'info'
                    });
                });
        }
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        // Toast notification function
        function showToast(title, message, type = 'info') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden transform transition-all duration-300 ease-in-out`;
            
            const bgColor = {
                'success': 'bg-green-50 border-green-200',
                'warning': 'bg-yellow-50 border-yellow-200',
                'error': 'bg-red-50 border-red-200',
                'info': 'bg-blue-50 border-blue-200'
            }[type] || 'bg-blue-50 border-blue-200';

            const iconColor = {
                'success': 'text-green-400',
                'warning': 'text-yellow-400',
                'error': 'text-red-400',
                'info': 'text-blue-400'
            }[type] || 'text-blue-400';

            toast.innerHTML = `
                <div class="p-4 ${bgColor}">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 ${iconColor}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p class="text-sm font-medium text-gray-900">${title}</p>
                            <p class="mt-1 text-sm text-gray-500">${message}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button onclick="this.closest('.max-w-sm').remove()" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(toast);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 300);
                }
            }, 5000);
        }

        // Make showToast globally available
        window.showToast = showToast;
    </script>
    <?php $__env->stopPush(); ?>
</div><?php /**PATH E:\payer-ready\resources\views/livewire/components/real-time-notifications.blade.php ENDPATH**/ ?>