<?php foreach ((['required' => false]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'text' => null
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
    'text' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $classes = [
        'text-sm [:where(&)]:text-start font-medium select-none',
        '[:where(&)]:text-neutral-800 [:where(&)]:dark:text-white',
    ];
?>

<div <?php echo e($attributes->class($classes)); ?> data-slot="label">
    <!--[if BLOCK]><![endif]--><?php if($slot->isNotEmpty()): ?>
        <?php echo e($slot); ?>

    <?php else: ?>
        <?php echo e($text); ?>

    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    
    
    <!--[if BLOCK]><![endif]--><?php if(isset($required) && $required): ?> 
        <span class="text-red-500 text-xs px-1 py-1" aria-hidden="true">
            *
        </span>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH E:\payer-ready\resources\views/components/ui/label.blade.php ENDPATH**/ ?>