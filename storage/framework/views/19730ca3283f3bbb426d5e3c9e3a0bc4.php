<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-slate-800">My Notifications</h1>
                <!--[if BLOCK]><![endif]--><?php if($notifications->where('read_at', null)->count() > 0): ?>
                    <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','variant' => 'ghost','size' => 'sm','class' => '!text-primary-600 hover:!text-primary-700','wire:click' => 'markAllAsRead']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','variant' => 'ghost','size' => 'sm','class' => '!text-primary-600 hover:!text-primary-700','wire:click' => 'markAllAsRead']); ?>
                        Mark all as read
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $attributes = $__attributesOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__attributesOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $component = $__componentOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__componentOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-end">
                <!-- Search Input -->
                

                <!-- Filters and Controls -->
                <div class="flex items-center gap-4">
                    <!-- Per Page Selector -->
                    <div class="flex items-center gap-2">
                        <label for="perPage" class="text-sm font-medium text-slate-700">Show:</label>
                        <?php if (isset($component)) { $__componentOriginal231e2c645bf8af0c5c05a5dc5a94c862 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal231e2c645bf8af0c5c05a5dc5a94c862 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.select.index','data' => ['wire:model.live' => 'perPage','class' => 'w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'perPage','class' => 'w-full']); ?>
                            <?php if (isset($component)) { $__componentOriginalb178088b41690ba18d9960f87fd0bd48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb178088b41690ba18d9960f87fd0bd48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.select.option','data' => ['value' => '10']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '10']); ?>10 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $attributes = $__attributesOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $component = $__componentOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__componentOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalb178088b41690ba18d9960f87fd0bd48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb178088b41690ba18d9960f87fd0bd48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.select.option','data' => ['value' => '15']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '15']); ?>15 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $attributes = $__attributesOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $component = $__componentOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__componentOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalb178088b41690ba18d9960f87fd0bd48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb178088b41690ba18d9960f87fd0bd48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.select.option','data' => ['value' => '25']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '25']); ?>25 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $attributes = $__attributesOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $component = $__componentOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__componentOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalb178088b41690ba18d9960f87fd0bd48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb178088b41690ba18d9960f87fd0bd48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.select.option','data' => ['value' => '50']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '50']); ?>50 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $attributes = $__attributesOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $component = $__componentOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__componentOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal231e2c645bf8af0c5c05a5dc5a94c862)): ?>
<?php $attributes = $__attributesOriginal231e2c645bf8af0c5c05a5dc5a94c862; ?>
<?php unset($__attributesOriginal231e2c645bf8af0c5c05a5dc5a94c862); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal231e2c645bf8af0c5c05a5dc5a94c862)): ?>
<?php $component = $__componentOriginal231e2c645bf8af0c5c05a5dc5a94c862; ?>
<?php unset($__componentOriginal231e2c645bf8af0c5c05a5dc5a94c862); ?>
<?php endif; ?>
                    </div>

                    <!-- Sort Controls -->
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-slate-700">Sort by:</span>
                        <div class="flex gap-1">
                            <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','size' => 'xs','variant' => 'outline','wire:click' => 'sortBy(\'created_at\')','class' => ''.e($sortBy === 'created_at' ? '!bg-primary-100 !text-primary-700 !border-primary-200' : '!bg-white !text-slate-600 hover:!bg-slate-50').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','size' => 'xs','variant' => 'outline','wire:click' => 'sortBy(\'created_at\')','class' => ''.e($sortBy === 'created_at' ? '!bg-primary-100 !text-primary-700 !border-primary-200' : '!bg-white !text-slate-600 hover:!bg-slate-50').'']); ?>
                                Date
                                <!--[if BLOCK]><![endif]--><?php if($sortBy === 'created_at'): ?>
                                    <span class="ml-1"><?php echo e($sortDirection === 'asc' ? '↑' : '↓'); ?></span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $attributes = $__attributesOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__attributesOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $component = $__componentOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__componentOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','size' => 'xs','variant' => 'outline','wire:click' => 'sortBy(\'read_at\')','class' => ''.e($sortBy === 'read_at' ? '!bg-primary-100 !text-primary-700 !border-primary-200' : '!bg-white !text-slate-600 hover:!bg-slate-50').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','size' => 'xs','variant' => 'outline','wire:click' => 'sortBy(\'read_at\')','class' => ''.e($sortBy === 'read_at' ? '!bg-primary-100 !text-primary-700 !border-primary-200' : '!bg-white !text-slate-600 hover:!bg-slate-50').'']); ?>
                                Status
                                <!--[if BLOCK]><![endif]--><?php if($sortBy === 'read_at'): ?>
                                    <span class="ml-1"><?php echo e($sortDirection === 'asc' ? '↑' : '↓'); ?></span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $attributes = $__attributesOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__attributesOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $component = $__componentOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__componentOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
                        </div>
                    </div>
                </div>
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
                            ?>
                            
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-800">
                                        <?php echo e($data['title'] ?? 'New Notification'); ?>

                                    </p>
                                    <p class="text-sm text-slate-600 mt-1">
                                        <?php echo e($data['message'] ?? 'You have a new notification'); ?>

                                    </p>
                                    
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
                                    <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','variant' => 'ghost','size' => 'xs','class' => 'ml-4 !text-blue-600 hover:!text-blue-800','wire:click' => 'markAsRead(\''.e($notification->id).'\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','variant' => 'ghost','size' => 'xs','class' => 'ml-4 !text-blue-600 hover:!text-blue-800','wire:click' => 'markAsRead(\''.e($notification->id).'\')']); ?>
                                        Mark as read
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $attributes = $__attributesOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__attributesOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $component = $__componentOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__componentOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
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
                    <h3 class="mt-2 text-sm font-medium text-slate-900">No notifications found</h3>
                    <!--[if BLOCK]><![endif]--><?php if($search): ?>
                        <p class="mt-1 text-sm text-slate-500">No notifications match your search criteria.</p>
                        <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','variant' => 'ghost','size' => 'sm','class' => 'mt-3 !text-primary-600 hover:!text-primary-700','wire:click' => 'clearSearch']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','variant' => 'ghost','size' => 'sm','class' => 'mt-3 !text-primary-600 hover:!text-primary-700','wire:click' => 'clearSearch']); ?>
                            Clear search
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $attributes = $__attributesOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__attributesOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $component = $__componentOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__componentOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
                    <?php else: ?>
                        <p class="mt-1 text-sm text-slate-500">You have no notifications at this time.</p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!--[if BLOCK]><![endif]--><?php if($notifications->count() > 0): ?>
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-slate-200">
                <?php echo e($notifications->links()); ?>

            </div>
            
            <!-- Footer -->
            <div class="px-6 py-3 bg-slate-50 border-t border-slate-200">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-500">
                        Showing <?php echo e($notifications->count()); ?> of <?php echo e($notifications->total()); ?> notification<?php echo e($notifications->total() !== 1 ? 's' : ''); ?>

                        <!--[if BLOCK]><![endif]--><?php if($notifications->where('read_at', null)->count() > 0): ?>
                            (<?php echo e($notifications->where('read_at', null)->count()); ?> unread)
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($search): ?>
                            for "<?php echo e($search); ?>"
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </p>
                    <!--[if BLOCK]><![endif]--><?php if($search): ?>
                        <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','variant' => 'ghost','size' => 'sm','class' => '!text-primary-600 hover:!text-primary-700','wire:click' => 'clearSearch']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','variant' => 'ghost','size' => 'sm','class' => '!text-primary-600 hover:!text-primary-700','wire:click' => 'clearSearch']); ?>
                            Clear search
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $attributes = $__attributesOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__attributesOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $component = $__componentOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__componentOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div><?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/livewire/doctor/doctor-notification-component.blade.php ENDPATH**/ ?>