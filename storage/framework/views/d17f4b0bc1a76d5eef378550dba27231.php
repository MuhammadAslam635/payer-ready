<?php foreach (([
    'checkIcon' => 'check',
    'checkIconClass' => '',
    'searchable' => false
]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'value' => null,
    'label' => null,
    'icon' => null,
    'iconClass' => null,
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
    'value' => null,
    'label' => null,
    'icon' => null,
    'iconClass' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // if there no label provided (when the value is the same as label) give the slot the value's value
    $slot = filled($slot->__toString()) ? $slot->__toString() : $value;
?>

<li 
    tabindex="0"
    x-bind:data-value="<?php echo \Illuminate\Support\Js::from($value)->toHtml() ?>"
    x-bind:data-label="<?php echo \Illuminate\Support\Js::from($slot)->toHtml() ?>"

    x-show="isItemShown(<?php echo \Illuminate\Support\Js::from($value)->toHtml() ?>)"
    
    x-on:mouseleave="$el.blur()"
    x-on:mouseenter="$el.focus()"
    
    x-bind:id="'option-' + getFilteredIndex(<?php echo \Illuminate\Support\Js::from($value)->toHtml() ?>)"
    x-on:click="select(<?php echo \Illuminate\Support\Js::from($value)->toHtml() ?>)"
    
    x-bind:class="{
        'bg-neutral-300 dark:bg-neutral-700 hover:bg-neutral-100 hover:dark:bg-neutral-700': isFocused(<?php echo \Illuminate\Support\Js::from($value)->toHtml() ?>),
        '[&>[data-slot=icon]]:opacity-100': isSelected(<?php echo \Illuminate\Support\Js::from($value)->toHtml() ?>),
    }"
    role="option"
    data-slot="option"
    class="cursor-pointer focus:bg-neutral-100 focus:dark:bg-neutral-700 px-3 py-0.5 rounded-[calc(var(--round)-var(--padding))] col-span-full grid grid-cols-subgrid items-center w-full self-center gap-x-2 text-[1rem]"
>
    <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => $checkIcon,'class' => \Illuminate\Support\Arr::toCssClasses([
            'text-black dark:text-white z-10 place-self-center opacity-0 size-[1.15rem]',
            $checkIconClass,
        ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($checkIcon),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
            'text-black dark:text-white z-10 place-self-center opacity-0 size-[1.15rem]',
            $checkIconClass,
        ]))]); ?>
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
    <!--[if BLOCK]><![endif]--><?php if(filled($icon)): ?>
        <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => $icon,'class' => \Illuminate\Support\Arr::toCssClasses([
                'text-black dark:text-white z-10 pl-1.5',
                $iconClass
            ])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses([
                'text-black dark:text-white z-10 pl-1.5',
                $iconClass
            ]))]); ?>
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
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <span class="col-start-3 text-start text-black dark:text-white"><?php echo e($slot); ?></span>
</li><?php /**PATH E:\payer-ready\resources\views/components/ui/select/option.blade.php ENDPATH**/ ?>