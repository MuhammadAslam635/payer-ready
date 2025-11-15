<div class="space-y-6">
    <!-- Page Header -->
    <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['tagline' => 'Overview of system statistics and recent activity']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tagline' => 'Overview of system statistics and recent activity']); ?>
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

    <!-- Main Stats Cards -->
    <?php if (isset($component)) { $__componentOriginal7802239ea974e2f209378aff3350aad4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7802239ea974e2f209378aff3350aad4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.super-admin','data' => ['stats' => $stats]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.super-admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['stats' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7802239ea974e2f209378aff3350aad4)): ?>
<?php $attributes = $__attributesOriginal7802239ea974e2f209378aff3350aad4; ?>
<?php unset($__attributesOriginal7802239ea974e2f209378aff3350aad4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7802239ea974e2f209378aff3350aad4)): ?>
<?php $component = $__componentOriginal7802239ea974e2f209378aff3350aad4; ?>
<?php unset($__componentOriginal7802239ea974e2f209378aff3350aad4); ?>
<?php endif; ?>

    <!-- Latest Activity Sections -->
    <?php if (isset($component)) { $__componentOriginald7e7d18b498140603256c65d937e46b2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald7e7d18b498140603256c65d937e46b2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.latest-activity','data' => ['stats' => $stats]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.latest-activity'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['stats' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald7e7d18b498140603256c65d937e46b2)): ?>
<?php $attributes = $__attributesOriginald7e7d18b498140603256c65d937e46b2; ?>
<?php unset($__attributesOriginald7e7d18b498140603256c65d937e46b2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald7e7d18b498140603256c65d937e46b2)): ?>
<?php $component = $__componentOriginald7e7d18b498140603256c65d937e46b2; ?>
<?php unset($__componentOriginald7e7d18b498140603256c65d937e46b2); ?>
<?php endif; ?>

    <!-- Certificate Requests -->
    <?php if (isset($component)) { $__componentOriginal776ff425d93e4cfbc1bf00c1eb0127d7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal776ff425d93e4cfbc1bf00c1eb0127d7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dashboard.certificate-request','data' => ['stats' => $stats]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dashboard.certificate-request'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['stats' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($stats)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal776ff425d93e4cfbc1bf00c1eb0127d7)): ?>
<?php $attributes = $__attributesOriginal776ff425d93e4cfbc1bf00c1eb0127d7; ?>
<?php unset($__attributesOriginal776ff425d93e4cfbc1bf00c1eb0127d7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal776ff425d93e4cfbc1bf00c1eb0127d7)): ?>
<?php $component = $__componentOriginal776ff425d93e4cfbc1bf00c1eb0127d7; ?>
<?php unset($__componentOriginal776ff425d93e4cfbc1bf00c1eb0127d7); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/livewire/dashboard/super-admin-dashboard-component.blade.php ENDPATH**/ ?>