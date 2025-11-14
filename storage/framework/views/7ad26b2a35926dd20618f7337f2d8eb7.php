<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => null,
    'messages' => [],
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'name' => null,
    'messages' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $errorMessages = [];
    
    // 1. From $errors bag 
    if ($name && $errors->has($name)) {
        $errorMessages = array_merge($errorMessages, $errors->get($name));
    }
    
    // 2. From manual messages prop
    if (filled($messages)) {
        $errorMessages = array_merge($errorMessages, Arr::wrap($messages));
    }
    
    $errorMessages = array_filter(array_unique($errorMessages));
    
    $hasErrors = !empty($errorMessages);
    
    $classes = [
        '[&>[data-slot=icon]]:!text-red-600 [&>[data-slot=icon]]:dark:!text-red-400', // force our icon to take red color 
        'mt-2 text-sm text-red-600 dark:text-red-400',
        'flex items-start gap-2',
        'hidden' => !$hasErrors,
    ];
?>

<!--[if BLOCK]><![endif]--><?php if($hasErrors): ?>
    <div 
        aria-live="polite"
        role="alert"
        <?php echo e($attributes->class(Arr::toCssClasses($classes))); ?> 
        data-slot="error"
    >
        <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'exclamation-circle','class' => 'flex-shrink-0 w-4 h-4 mt-0.5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'exclamation-circle','class' => 'flex-shrink-0 w-4 h-4 mt-0.5']); ?>
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
        <div class="flex-1">
            <!--[if BLOCK]><![endif]--><?php if(count($errorMessages) === 1): ?>
                <span><?php echo e($errorMessages[0]); ?></span>
            <?php else: ?>
                <ul class="list-disc list-inside space-y-1">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $errorMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($message); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]--><?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/components/ui/error.blade.php ENDPATH**/ ?>