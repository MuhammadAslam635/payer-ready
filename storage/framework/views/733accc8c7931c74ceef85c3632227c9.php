<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-slate-800">Organization Notifications</h1>
                <!--[if BLOCK]><![endif]--><?php if($notifications->where('read_at', null)->count() > 0): ?>
                    <button wire:click="markAllAsRead" 
                            class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        Mark all as read
                    </button>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Notifications List -->
        <div class="divide-y divide-slate-100">
            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="px-6 py-4 <?php echo e($notification->read_at ? 'bg-white' : 'bg-blue-50'); ?> hover:bg-slate-50 transition-colors">
                    <div class="flex items-start space-x-4">
                        <!-- Status Indicator -->
                        <div class="flex-shrink-0 mt-2">
                            <!--[if BLOCK]><![endif]--><?php if($notification->read_at): ?>
                                <div class="w-2 h-2 bg-slate-300 rounded-full"></div>
                            <?php else: ?>
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Notification Content -->
                        <div class="flex-1">
                            <?php
                                $data = $notification->data;
                                $notifiableUser = \App\Models\User::find($notification->notifiable_id);
                            ?>
                            
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-800">
                                        <?php echo e($data['title'] ?? 'New Notification'); ?>

                                    </p>
                                    <p class="text-sm text-slate-600 mt-1">
                                        <?php echo e($data['message'] ?? 'You have a new notification'); ?>

                                    </p>
                                    
                                    <!--[if BLOCK]><![endif]--><?php if($notifiableUser): ?>
                        <p class="text-xs text-slate-500 mt-1">
                            <span class="font-medium">User:</span> <?php echo e($notifiableUser->name); ?> 
                            <span class="text-slate-400">(<?php echo e($notifiableUser->email); ?>)</span>
                        </p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <!--[if BLOCK]><![endif]--><?php if(isset($data['task_details'])): ?>
                                        <div class="mt-2 text-xs text-slate-500">
                                            <span class="font-medium">Task:</span> <?php echo e($data['task_details']); ?>

                                            <!--[if BLOCK]><![endif]--><?php if(isset($data['due_date'])): ?>
                                                <span class="ml-2">
                                                    <span class="font-medium">Due:</span> 
                                                    <?php echo e(\Carbon\Carbon::parse($data['due_date'])->format('M d, Y')); ?>

                                                </span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    
                                    <p class="text-xs text-slate-400 mt-2">
                                        <?php echo e($notification->created_at->diffForHumans()); ?>

                                    </p>
                                </div>
                                
                                <!--[if BLOCK]><![endif]--><?php if(!$notification->read_at): ?>
                                    <button wire:click="markAsRead('<?php echo e($notification->id); ?>')" 
                                            class="text-xs text-blue-600 hover:text-blue-800 font-medium ml-4">
                                        Mark as read
                                    </button>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-6 py-12 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-slate-100">
                        <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'bell-slash','class' => 'h-6 w-6 text-slate-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'bell-slash','class' => 'h-6 w-6 text-slate-400']); ?>
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
                    <h3 class="mt-2 text-sm font-medium text-slate-900">No notifications</h3>
                    <p class="mt-1 text-sm text-slate-500">No organization notifications found.</p>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!--[if BLOCK]><![endif]--><?php if($notifications->count() > 0): ?>
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200">
                <?php echo e($notifications->links()); ?>

            </div>
            
            <!-- Footer -->
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 text-center">
                <p class="text-sm text-slate-500">
                    Showing <?php echo e($notifications->count()); ?> notification<?php echo e($notifications->count() !== 1 ? 's' : ''); ?>

                    <!--[if BLOCK]><![endif]--><?php if($notifications->where('read_at', null)->count() > 0): ?>
                        (<?php echo e($notifications->where('read_at', null)->count()); ?> unread)
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </p>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div><?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/livewire/organization/organization-notification-component.blade.php ENDPATH**/ ?>