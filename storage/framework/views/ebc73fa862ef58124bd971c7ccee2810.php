<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => '',
    'description' => '',
    'error' => '',
    'required' => false,
    'disabled' => false,
    'checked' => false,
    'value' => '',
    'name' => '',
    'id' => '',
    'class' => '',
    'labelClass' => '',
    'descriptionClass' => '',
    'errorClass' => '',
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
    'label' => '',
    'description' => '',
    'error' => '',
    'required' => false,
    'disabled' => false,
    'checked' => false,
    'value' => '',
    'name' => '',
    'id' => '',
    'class' => '',
    'labelClass' => '',
    'descriptionClass' => '',
    'errorClass' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $componentId = $id ?: 'checkbox-' . uniqid();
    $wireModel = $attributes->whereStartsWith('wire:model')->first();
    $xModel = $attributes->whereStartsWith('x-model')->first();
    
    $labelClasses = [
        'flex items-start gap-3 cursor-pointer',
        $labelClass
    ];
    
    $checkboxClasses = [
        'shrink-0 size-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 focus:ring-2',
        'disabled:opacity-50 disabled:cursor-not-allowed',
        $class
    ];
    
    $descriptionClasses = [
        'text-sm text-gray-600 dark:text-gray-400',
        $descriptionClass
    ];
    
    $errorClasses = [
        'text-sm text-red-600 dark:text-red-400 mt-1',
        $errorClass
    ];
?>

<div class="w-full">
    <label class="<?php echo \Illuminate\Support\Arr::toCssClasses($labelClasses); ?>" for="<?php echo e($componentId); ?>">
        <input
            type="checkbox"
            id="<?php echo e($componentId); ?>"
            name="<?php echo e($name); ?>"
            value="<?php echo e($value); ?>"
            <?php if($checked): ?> checked <?php endif; ?>
            <?php if($disabled): ?> disabled <?php endif; ?>
            <?php if($required): ?> required <?php endif; ?>
            <?php if($wireModel): ?> wire:model="<?php echo e($wireModel); ?>" <?php endif; ?>
            <?php if($xModel): ?> x-model="<?php echo e($xModel); ?>" <?php endif; ?>
            class="<?php echo \Illuminate\Support\Arr::toCssClasses($checkboxClasses); ?>"
            <?php echo e($attributes->except(['wire:model', 'x-model', 'class', 'labelClass', 'descriptionClass', 'errorClass'])); ?>

        />
        
        <div class="flex-1">
            <!--[if BLOCK]><![endif]--><?php if($label): ?>
                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                    <?php echo e($label); ?>

                    <!--[if BLOCK]><![endif]--><?php if($required): ?>
                        <span class="text-red-500 ml-1">*</span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            
            <!--[if BLOCK]><![endif]--><?php if($description): ?>
                <p class="<?php echo \Illuminate\Support\Arr::toCssClasses($descriptionClasses); ?>">
                    <?php echo e($description); ?>

                </p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </label>
    
    <!--[if BLOCK]><![endif]--><?php if($error): ?>
        <p class="<?php echo \Illuminate\Support\Arr::toCssClasses($errorClasses); ?>">
            <?php echo e($error); ?>

        </p>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/components/ui/checkbox.blade.php ENDPATH**/ ?>