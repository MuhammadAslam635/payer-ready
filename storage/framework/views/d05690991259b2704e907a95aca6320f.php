<div class="space-y-6">
    <!-- Page Header -->


    <!-- Main Stats Cards -->
    <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['tagline' => 'Manage your professional credentials and reference providers']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tagline' => 'Manage your professional credentials and reference providers']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal360d002b1b676b6f84d43220f22129e2)): ?>
<?php $attributes = $__attributesOriginal360d002b1b676b6f84d43220f22129e2; ?>
<?php unset($__attributesOriginal360d002b1b676b6f84d43220f22129e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal360d002b1b676b6f84d43220f22129e2)): ?>
<?php $component = $__componentOriginal360d002b1b676b6f84d43220f22129e2; ?>
<?php unset($__componentOriginal360d002b1b676b6f84d43220f22129e2); ?>
<?php endif; ?>

    <!-- User Profile Card -->
    <?php if (isset($component)) { $__componentOriginal7cbdb91d93ffef8fedff7e7e63f3df8c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7cbdb91d93ffef8fedff7e7e63f3df8c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.provider-profile-section','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('provider-profile-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7cbdb91d93ffef8fedff7e7e63f3df8c)): ?>
<?php $attributes = $__attributesOriginal7cbdb91d93ffef8fedff7e7e63f3df8c; ?>
<?php unset($__attributesOriginal7cbdb91d93ffef8fedff7e7e63f3df8c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7cbdb91d93ffef8fedff7e7e63f3df8c)): ?>
<?php $component = $__componentOriginal7cbdb91d93ffef8fedff7e7e63f3df8c; ?>
<?php unset($__componentOriginal7cbdb91d93ffef8fedff7e7e63f3df8c); ?>
<?php endif; ?>

    <!-- Latest Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Latest Licenses -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest Licenses</h3>
            </div>
            <div class="p-6">
                <!--[if BLOCK]><![endif]--><?php if($stats['latestLicenses']->count() > 0): ?>
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stats['latestLicenses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-900"><?php echo e($license['license_number']); ?></p>
                                    <p class="text-sm text-slate-500"><?php echo e($license['state']); ?></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($license['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php echo e($license['is_active'] ? 'Active' : 'Expired'); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <p class="text-slate-500 text-center py-4">No licenses found</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Latest Documents -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest Documents</h3>
            </div>
            <div class="p-6">
                <!--[if BLOCK]><![endif]--><?php if($stats['latestDocuments']->count() > 0): ?>
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stats['latestDocuments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-900"><?php echo e($document['document_type']); ?></p>
                                    <p class="text-sm text-slate-500"><?php echo e($document['original_filename']); ?></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($document['is_verified'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                        <?php echo e($document['is_verified'] ? 'Verified' : 'Pending'); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <p class="text-slate-500 text-center py-4">No documents found</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/livewire/dashboard/doctor-dashboard-component.blade.php ENDPATH**/ ?>