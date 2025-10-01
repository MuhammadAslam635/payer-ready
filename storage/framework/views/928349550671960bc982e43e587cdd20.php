<div class="relative" x-data="{ open: false }">
    <button @click="open = !open"
        class="relative text-slate-500 p-2 bg-primary-100 rounded-full hover:text-primary-600 transition-colors">
        <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'bell-alert','class' => 'h-5 w-5 sm:h-6 sm:w-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'bell-alert','class' => 'h-5 w-5 sm:h-6 sm:w-6']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $attributes = $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $component = $__componentOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
        <!--[if BLOCK]><![endif]--><?php if($unreadCount > 0): ?>
            <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-5 w-5 bg-red-500 text-white text-xs font-medium items-center justify-center">
                    <?php echo e($unreadCount > 9 ? '9+' : $unreadCount); ?>

                </span>
            </span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </button>

    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-20">
        <!-- Header -->
        <div class="px-4 py-2 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-slate-800">Notifications</h3>
            <!--[if BLOCK]><![endif]--><?php if($unreadCount > 0): ?>
                <button wire:click="markAllAsRead" class="text-xs text-primary-600 hover:text-primary-700 font-medium">
                    Mark all read
                </button>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Notification Items -->
        <div class="max-h-64 overflow-y-auto">
            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50 border-b border-slate-50 <?php echo e(!$notification['read'] ? 'bg-blue-50' : ''); ?>">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 <?php echo e($notification['read'] ? 'bg-slate-300' : 'bg-blue-500'); ?> rounded-full mt-2"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="font-medium text-slate-800"><?php echo e($notification['title']); ?></p>
                                    <p class="text-xs text-slate-500 mt-1"><?php echo e($notification['message']); ?></p>
                                    <p class="text-xs text-slate-400 mt-1"><?php echo e($notification['created_at']); ?></p>
                                </div>
                                <div class="flex items-center space-x-2 ml-2">
                                    <!--[if BLOCK]><![endif]--><?php if(!$notification['read']): ?>
                                        <button wire:click="markAsRead('<?php echo e($notification['id']); ?>')"
                                                class="text-xs text-primary-600 hover:text-primary-700 font-medium">
                                            Mark read
                                        </button>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php if($notification['url'] && $notification['url'] !== '#'): ?>
                                        <a href="<?php echo e($notification['url']); ?>"
                                           class="text-xs text-slate-500 hover:text-slate-700 font-medium">
                                            View →
                                        </a>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-4 py-8 text-center">
                    <div class="mx-auto h-8 w-8 text-slate-400 mb-2">
                        <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'bell-slash','class' => 'h-8 w-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'bell-slash','class' => 'h-8 w-8']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $attributes = $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $component = $__componentOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
                    </div>
                    <p class="text-sm text-slate-500">No notifications</p>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Footer -->
        <!--[if BLOCK]><![endif]--><?php if($notifications->count() > 0): ?>
            <div class="px-4 py-2 border-t border-slate-100">
                <?php
                    $user = Auth::user();
                    $notificationRoute = match($user->user_type) {
                        \App\Enums\UserType::SUPER_ADMIN => route('super-admin.notifications'),
                        \App\Enums\UserType::DOCTOR => route('doctor.notifications'),
                        \App\Enums\UserType::ORGANIZATION_ADMIN => route('organization-admin.notifications'),
                        default => '#'
                    };
                ?>
                <a href="<?php echo e($notificationRoute); ?>" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                    View all notifications
                </a>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>
<?php /**PATH E:\payer-ready\resources\views/livewire/components/notifications.blade.php ENDPATH**/ ?>