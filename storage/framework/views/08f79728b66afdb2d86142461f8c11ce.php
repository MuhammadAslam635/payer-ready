<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => $attributes->whereStartsWith('wire:model')->first() ?? $attributes->whereStartsWith('x-model')->first(),
    'prefix' => null,
    'suffix' => null,
    'prefixIcon' => null,
    'suffixIcon' => null,
    'iconAfter' => null,
    'clearable' => null,
    'copyable' => null,
    'revealable' => null,
    'invalid' => null,
    'type' => 'text',
    'size' => null,
    'icon' => null,
    'as' => null,
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
    'name' => $attributes->whereStartsWith('wire:model')->first() ?? $attributes->whereStartsWith('x-model')->first(),
    'prefix' => null,
    'suffix' => null,
    'prefixIcon' => null,
    'suffixIcon' => null,
    'iconAfter' => null,
    'clearable' => null,
    'copyable' => null,
    'revealable' => null,
    'invalid' => null,
    'type' => 'text',
    'size' => null,
    'icon' => null,
    'as' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php

    $invalid ??= $name && $errors->has($name);

    $classes = [
        // isolate stacking context to prevent z-index and shadow bleed from parent
        'isolate',

        'relative flex items-stretch w-full shadow-xs disabled:shadow-none transition-colors duration-200',

        'rounded-box',
        // Tailwind v4 '_input' means space + 'input'; these selectors target the input child
        '[&:has([data-slot=input-prefix])_input]:rounded-l-none',  // remove left border-radius if prefix exists

        '[&:has([data-slot=input-suffix])_input]:rounded-r-none',  // remove right border-radius if suffix exists

        '[&:has([data-slot=input-prefix]):has([data-slot=input-suffix])_input]:rounded-none', // no border-radius if both exist
    ];

    $iconCount = count(array_filter([$clearable,$copyable,$revealable]));
?>

<div <?php echo e($attributes->class(Arr::toCssClasses([...$classes]))); ?>>
    
    <!--[if BLOCK]><![endif]--><?php if(filled($prefix) || filled($prefixIcon)): ?>
        <?php if (isset($component)) { $__componentOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input.extra-slot','data' => ['dataSlot' => 'input-prefix']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input.extra-slot'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-slot' => 'input-prefix']); ?>
            <!--[if BLOCK]><![endif]--><?php if($prefix instanceof \Illuminate\View\ComponentSlot): ?>
                <?php echo e($prefix); ?>

            <?php elseif($prefixIcon): ?>
                <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => ''.e($prefixIcon).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => ''.e($prefixIcon).'']); ?>
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
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d)): ?>
<?php $attributes = $__attributesOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d; ?>
<?php unset($__attributesOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d)): ?>
<?php $component = $__componentOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d; ?>
<?php unset($__componentOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div
        x-data 
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            'w-full grid isolate',

            // Overlap input actions to the right of the input using grid positioning
            '[&>[data-slot=input-actions]]:col-start-2 [&>[data-slot=input-actions]]:row-start-1 [&>[data-slot=input-actions]]:z-10 [&>[data-slot=input-actions]]:place-self-center',

            // Input spans full width, underlying input and actions share grid row/column
            '[&>[data-slot=control]]:col-start-1 [&>[data-slot=control]]:row-start-1 [&>[data-slot=control]]:col-span-2 ',

            // Dynamically pad input's right based on number of action icons present
            '[&:has([data-slot=input-actions]):has([data-slot=input-option])>[data-slot=control]]:pr-[1.9rem]',
            '[&:has([data-slot=input-actions]):has([data-slot=input-option]+[data-slot=input-option])>[data-slot=control]]:pr-[3.8rem]',
            '[&:has([data-slot=input-actions]):has([data-slot=input-option]+[data-slot=input-option]+[data-slot=input-option])>[data-slot=control]]:pr-[5.7rem]',
        ]); ?>"
        
        style="<?php echo \Illuminate\Support\Arr::toCssStyles([
            '--icon-count: '. $iconCount,
            '--icon-width: 2rem',
            'grid-template-columns: 1fr calc(var(--icon-width) * var(--icon-count))'
        ]) ?>"
    >
        <input
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'z-10',
                'w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500',
                'bg-white dark:bg-neutral-900 dark:disabled:bg-neutral-800',
                'disabled:cursor-not-allowed transition-colors duration-200',
                'shadow-none dark:shadow-sm disabled:shadow-none rounded-box',
                'focus:ring-2 focus:ring-offset-0 focus:outline-none',
                'border-black/10 focus:border-black/15 focus:ring-neutral-900/15 dark:border-white/15 dark:focus:border-white/20 dark:focus:ring-neutral-100/15' => !$invalid,
                'border-red-600/30 border-2 focus:border-red-600/30 focus:ring-red-600/20 dark:border-red-400/30 dark:focus:border-red-400/30 dark:focus:ring-red-400/20' => $invalid,
            ]); ?>"
            name="<?php echo e($name); ?>"
            type="<?php echo e($type); ?>"
            data-slot="control"
            <?php echo e($attributes); ?>

            x-ref="input"
            <?php if($invalid): ?> invalid <?php endif; ?>
        />
        <div class="flex items-center h-[92%] mr-1" data-slot="input-actions">
            <!--[if BLOCK]><![endif]--><?php if($copyable): ?>   <?php if (isset($component)) { $__componentOriginal7884b7e159fd38269c134cd47f2a73b7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7884b7e159fd38269c134cd47f2a73b7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input.options.copyable','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input.options.copyable'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7884b7e159fd38269c134cd47f2a73b7)): ?>
<?php $attributes = $__attributesOriginal7884b7e159fd38269c134cd47f2a73b7; ?>
<?php unset($__attributesOriginal7884b7e159fd38269c134cd47f2a73b7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7884b7e159fd38269c134cd47f2a73b7)): ?>
<?php $component = $__componentOriginal7884b7e159fd38269c134cd47f2a73b7; ?>
<?php unset($__componentOriginal7884b7e159fd38269c134cd47f2a73b7); ?>
<?php endif; ?>   <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if($clearable): ?>  <?php if (isset($component)) { $__componentOriginal4179bd0ad0a651a165cb6c5eb4408060 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4179bd0ad0a651a165cb6c5eb4408060 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input.options.clearable','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input.options.clearable'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4179bd0ad0a651a165cb6c5eb4408060)): ?>
<?php $attributes = $__attributesOriginal4179bd0ad0a651a165cb6c5eb4408060; ?>
<?php unset($__attributesOriginal4179bd0ad0a651a165cb6c5eb4408060); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4179bd0ad0a651a165cb6c5eb4408060)): ?>
<?php $component = $__componentOriginal4179bd0ad0a651a165cb6c5eb4408060; ?>
<?php unset($__componentOriginal4179bd0ad0a651a165cb6c5eb4408060); ?>
<?php endif; ?>  <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <!--[if BLOCK]><![endif]--><?php if($revealable): ?> <?php if (isset($component)) { $__componentOriginal1693c1e3c4a3c7f159619e59d8b77ef1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1693c1e3c4a3c7f159619e59d8b77ef1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input.options.revealable','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input.options.revealable'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1693c1e3c4a3c7f159619e59d8b77ef1)): ?>
<?php $attributes = $__attributesOriginal1693c1e3c4a3c7f159619e59d8b77ef1; ?>
<?php unset($__attributesOriginal1693c1e3c4a3c7f159619e59d8b77ef1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1693c1e3c4a3c7f159619e59d8b77ef1)): ?>
<?php $component = $__componentOriginal1693c1e3c4a3c7f159619e59d8b77ef1; ?>
<?php unset($__componentOriginal1693c1e3c4a3c7f159619e59d8b77ef1); ?>
<?php endif; ?> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>

    
    <!--[if BLOCK]><![endif]--><?php if(filled($suffix) || filled($suffixIcon)): ?>
        <?php if (isset($component)) { $__componentOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input.extra-slot','data' => ['dataSlot' => 'input-suffix']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input.extra-slot'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-slot' => 'input-suffix']); ?>
            <!--[if BLOCK]><![endif]--><?php if($suffix instanceof \Illuminate\View\ComponentSlot): ?>
                <div class="px-3">
                    <?php echo e($suffix); ?>

                </div>
            <?php elseif($suffixIcon): ?>
                <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => ''.e($suffixIcon).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => ''.e($suffixIcon).'']); ?>
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
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d)): ?>
<?php $attributes = $__attributesOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d; ?>
<?php unset($__attributesOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d)): ?>
<?php $component = $__componentOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d; ?>
<?php unset($__componentOriginal8c1b8d5cd5e64c67c430bb664f2ddf2d); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH E:\payer-ready\resources\views/components/ui/input/index.blade.php ENDPATH**/ ?>