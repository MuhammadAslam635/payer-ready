<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeAddModal"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form wire:submit.prevent="saveLicense">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Add New License <?php echo e($selectedProvider); ?>

                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <?php if (isset($component)) { $__componentOriginalb2c43a998f3174877f99993c62e16bb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2c43a998f3174877f99993c62e16bb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Provider <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $attributes = $__attributesOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $component = $__componentOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__componentOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input.index','data' => ['type' => 'text','value' => ''.e($selectedProvider).'','readonly' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','value' => ''.e($selectedProvider).'','readonly' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $attributes = $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $component = $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.error','data' => ['name' => 'selectedProvider']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'selectedProvider']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $attributes = $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $component = $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>

                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                                    <div>
                                        <?php if (isset($component)) { $__componentOriginalb2c43a998f3174877f99993c62e16bb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2c43a998f3174877f99993c62e16bb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>License Type <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $attributes = $__attributesOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $component = $__componentOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__componentOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal231e2c645bf8af0c5c05a5dc5a94c862 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal231e2c645bf8af0c5c05a5dc5a94c862 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.select.index','data' => ['wire:model' => 'addForm.license_type_id','searchable' => true,'class' => 'mt-1 block w-full ']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'addForm.license_type_id','searchable' => true,'class' => 'mt-1 block w-full ']); ?>
                                            <?php if (isset($component)) { $__componentOriginalb178088b41690ba18d9960f87fd0bd48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb178088b41690ba18d9960f87fd0bd48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.select.option','data' => ['value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '']); ?>Select License Type <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $attributes = $__attributesOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $component = $__componentOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__componentOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
                                            <!--[if BLOCK]><![endif]--><?php if($licenseTypes && $licenseTypes->count() > 0): ?>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $licenseTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if (isset($component)) { $__componentOriginalb178088b41690ba18d9960f87fd0bd48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb178088b41690ba18d9960f87fd0bd48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.select.option','data' => ['value' => ''.e($type->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => ''.e($type->id).'']); ?><?php echo e($type->name); ?>

                                                        (<?php echo e($type->code); ?>)
                                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $attributes = $__attributesOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $component = $__componentOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__componentOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php else: ?>
                                                <?php if (isset($component)) { $__componentOriginalb178088b41690ba18d9960f87fd0bd48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb178088b41690ba18d9960f87fd0bd48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.select.option','data' => ['value' => '','disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '','disabled' => true]); ?>No license types available <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $attributes = $__attributesOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $component = $__componentOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__componentOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                                        <?php if (isset($component)) { $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.error','data' => ['name' => 'addForm.license_type_id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'addForm.license_type_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $attributes = $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $component = $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
                                    </div>
                                     <div>
                                        <?php if (isset($component)) { $__componentOriginalb2c43a998f3174877f99993c62e16bb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2c43a998f3174877f99993c62e16bb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>State <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $attributes = $__attributesOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $component = $__componentOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__componentOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal231e2c645bf8af0c5c05a5dc5a94c862 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal231e2c645bf8af0c5c05a5dc5a94c862 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.select.index','data' => ['wire:model' => 'addForm.state_id','searchable' => true,'class' => 'mt-1 block w-full ']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'addForm.state_id','searchable' => true,'class' => 'mt-1 block w-full ']); ?>
                                            <?php if (isset($component)) { $__componentOriginalb178088b41690ba18d9960f87fd0bd48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb178088b41690ba18d9960f87fd0bd48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.select.option','data' => ['value' => '']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '']); ?>Select State <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $attributes = $__attributesOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $component = $__componentOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__componentOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
                                            <!--[if BLOCK]><![endif]--><?php if($states && $states->count() > 0): ?>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if (isset($component)) { $__componentOriginalb178088b41690ba18d9960f87fd0bd48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb178088b41690ba18d9960f87fd0bd48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.select.option','data' => ['value' => ''.e($state->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => ''.e($state->id).'']); ?><?php echo e($state->name); ?>

                                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $attributes = $__attributesOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $component = $__componentOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__componentOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php else: ?>
                                                <?php if (isset($component)) { $__componentOriginalb178088b41690ba18d9960f87fd0bd48 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb178088b41690ba18d9960f87fd0bd48 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.select.option','data' => ['value' => '','disabled' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '','disabled' => true]); ?>No states available <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $attributes = $__attributesOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__attributesOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb178088b41690ba18d9960f87fd0bd48)): ?>
<?php $component = $__componentOriginalb178088b41690ba18d9960f87fd0bd48; ?>
<?php unset($__componentOriginalb178088b41690ba18d9960f87fd0bd48); ?>
<?php endif; ?>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                                        <?php if (isset($component)) { $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.error','data' => ['name' => 'addForm.state_id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'addForm.state_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $attributes = $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $component = $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
                                    </div>

                                </div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                                    <div>
                                        <?php if (isset($component)) { $__componentOriginalb2c43a998f3174877f99993c62e16bb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2c43a998f3174877f99993c62e16bb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>License Number <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $attributes = $__attributesOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $component = $__componentOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__componentOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input.index','data' => ['type' => 'text','wire:model' => 'addForm.license_number','placeholder' => 'Enter license number']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','wire:model' => 'addForm.license_number','placeholder' => 'Enter license number']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $attributes = $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $component = $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.error','data' => ['name' => 'addForm.license_number']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'addForm.license_number']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $attributes = $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $component = $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
                                    </div>
                                     <div>
                                    <?php if (isset($component)) { $__componentOriginalb2c43a998f3174877f99993c62e16bb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2c43a998f3174877f99993c62e16bb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Issuing Authority <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $attributes = $__attributesOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $component = $__componentOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__componentOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input.index','data' => ['type' => 'text','wire:model' => 'addForm.issuing_authority','placeholder' => 'Enter issuing authority']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','wire:model' => 'addForm.issuing_authority','placeholder' => 'Enter issuing authority']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $attributes = $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $component = $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.error','data' => ['name' => 'addForm.issuing_authority']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'addForm.issuing_authority']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $attributes = $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $component = $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
                                </div>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                                    <div>
                                        <?php if (isset($component)) { $__componentOriginalb2c43a998f3174877f99993c62e16bb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2c43a998f3174877f99993c62e16bb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Issue Date <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $attributes = $__attributesOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $component = $__componentOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__componentOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input.index','data' => ['type' => 'date','wire:model' => 'addForm.issue_date','placeholder' => 'Select issue date']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','wire:model' => 'addForm.issue_date','placeholder' => 'Select issue date']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $attributes = $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $component = $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.error','data' => ['name' => 'addForm.issue_date']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'addForm.issue_date']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $attributes = $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $component = $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
                                    </div>

                                    <div>
                                        <?php if (isset($component)) { $__componentOriginalb2c43a998f3174877f99993c62e16bb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2c43a998f3174877f99993c62e16bb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Expiration Date <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $attributes = $__attributesOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $component = $__componentOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__componentOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input.index','data' => ['type' => 'date','wire:model' => 'addForm.expiration_date','placeholder' => 'Select expiration date']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','wire:model' => 'addForm.expiration_date','placeholder' => 'Select expiration date']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $attributes = $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $component = $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.error','data' => ['name' => 'addForm.expiration_date']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'addForm.expiration_date']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $attributes = $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $component = $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
                                    </div>
                                </div>

                                    <div>
                                        <?php if (isset($component)) { $__componentOriginalb2c43a998f3174877f99993c62e16bb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2c43a998f3174877f99993c62e16bb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.label','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Notes <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $attributes = $__attributesOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $component = $__componentOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__componentOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal62d1193389a71cd99ff302a00abbf991 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal62d1193389a71cd99ff302a00abbf991 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.textarea.index','data' => ['wire:model' => 'addForm.notes','placeholder' => 'Additional notes (optional)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'addForm.notes','placeholder' => 'Additional notes (optional)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal62d1193389a71cd99ff302a00abbf991)): ?>
<?php $attributes = $__attributesOriginal62d1193389a71cd99ff302a00abbf991; ?>
<?php unset($__attributesOriginal62d1193389a71cd99ff302a00abbf991); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal62d1193389a71cd99ff302a00abbf991)): ?>
<?php $component = $__componentOriginal62d1193389a71cd99ff302a00abbf991; ?>
<?php unset($__componentOriginal62d1193389a71cd99ff302a00abbf991); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.error','data' => ['name' => 'addForm.notes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'addForm.notes']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $attributes = $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $component = $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
                                    </div>

                                <div class="mt-4">
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox" wire:model="addForm.is_verified"
                                            class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" />
                                        <span class="text-sm text-text-primary">
                                            Is License Verified?
                                        </span>
                                    </label>
                                    <?php if (isset($component)) { $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.error','data' => ['name' => 'addForm.is_verified']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'addForm.is_verified']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $attributes = $__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__attributesOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07)): ?>
<?php $component = $__componentOriginal49789f0e11f6b7c94cbebf11f344eb07; ?>
<?php unset($__componentOriginal49789f0e11f6b7c94cbebf11f344eb07); ?>
<?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'submit','class' => 'bg-teal-500 text-white text-xs hover:bg-teal-700 rounded-md','wire:loading.attr' => 'disabled']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'bg-teal-500 text-white text-xs hover:bg-teal-700 rounded-md','wire:loading.attr' => 'disabled']); ?>
                        Add License
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','class' => 'bg-red-500 text-white text-xs hover:bg-red-700 rounded-md','wire:click' => 'closeAddModal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','class' => 'bg-red-500 text-white text-xs hover:bg-red-700 rounded-md','wire:click' => 'closeAddModal']); ?>
                        Cancel
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
            </form>
        </div>
    </div>
</div>
<?php /**PATH E:\payer-ready\resources\views/components/doctor/add-license-modal.blade.php ENDPATH**/ ?>