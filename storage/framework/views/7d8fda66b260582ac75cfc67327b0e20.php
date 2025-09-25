<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['dataSlot','class','ariaHidden']));

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

foreach (array_filter((['dataSlot','class','ariaHidden']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php if (isset($component)) { $__componentOriginalb17991d8926dd0e3f65e73f8e8aa29d2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb17991d8926dd0e3f65e73f8e8aa29d2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'heroicons::components.outline.eye-slash','data' => ['dataSlot' => $dataSlot,'class' => $class,'ariaHidden' => $ariaHidden]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicons::outline.eye-slash'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-slot' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($dataSlot),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($class),'aria-hidden' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ariaHidden)]); ?>

<?php echo e($slot ?? ""); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb17991d8926dd0e3f65e73f8e8aa29d2)): ?>
<?php $attributes = $__attributesOriginalb17991d8926dd0e3f65e73f8e8aa29d2; ?>
<?php unset($__attributesOriginalb17991d8926dd0e3f65e73f8e8aa29d2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb17991d8926dd0e3f65e73f8e8aa29d2)): ?>
<?php $component = $__componentOriginalb17991d8926dd0e3f65e73f8e8aa29d2; ?>
<?php unset($__componentOriginalb17991d8926dd0e3f65e73f8e8aa29d2); ?>
<?php endif; ?><?php /**PATH E:\payer-ready\storage\framework\views/ad770e6d6286708043f22f8237b218df.blade.php ENDPATH**/ ?>