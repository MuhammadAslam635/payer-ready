
<?php foreach ((['icon', 'iconClasses', 'iconVariant', 'iconAfter']) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'button',
    'size' => 'md',
    'color' => null,
    'loading' => false, // Set to false to disable the loading indicator feature completely
    'loadingDisabled' => false, // Set to false to disable the loading indicator feature completely
    'variant' => 'primary',
    'icon' => null,
    'iconAfter' => null,
    'iconVariant' => null,
    'as' => 'button',
    'iconClasses' => null,
    'squared' => false
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
    'type' => 'button',
    'size' => 'md',
    'color' => null,
    'loading' => false, // Set to false to disable the loading indicator feature completely
    'loadingDisabled' => false, // Set to false to disable the loading indicator feature completely
    'variant' => 'primary',
    'icon' => null,
    'iconAfter' => null,
    'iconVariant' => null,
    'as' => 'button',
    'iconClasses' => null,
    'squared' => false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
// Automatically convert to square style if no content slot is provided
$squared = $slot->isEmpty();

/* DEALING WITH SIZES - START */
// Determine size-specific classes, including height, text size, and padding adjustments based on squared mode and icon presence
$sizeClasses = match($size) { 
    'lg' => '[:where(&)]:h-12 text-md' . ' '. ( $squared ? 'w-12': ($icon ? 'ps-4' : 'ps-5') . ' ' . ($iconAfter ? 'pe-4' : 'pe-5')),
    'md' => '[:where(&)]:h-10 text-base' . ' '. ( $squared ? 'w-10': ($icon ? 'ps-3' : 'ps-4') . ' ' . ($iconAfter ? 'pe-3' : 'pe-4')), // default
    'sm' => '[:where(&)]:h-8 text-sm' . ' '. ( $squared ? 'w-8': ($icon ? 'ps-2' : 'ps-3') . ' ' . ($iconAfter ? 'pe-2' : 'pe-3')),
    'xs' => '[:where(&)]:h-6 text-xs' . ' '. ( $squared ? 'w-6': ($icon ? 'ps-1' : 'ps-2') . ' ' . ($iconAfter ? 'pe-1' : 'pe-2')),
    default => '[:where(&)]:h-10 text-sm' . ' '. ( $squared ? 'w-10': ($icon ? 'ps-3' : 'ps-4') . ' ' . ($iconAfter ? 'pe-3' : 'pe-4')),
};
/* SIZES - END */

/* DEALING WITH ICONS - START */
// Set default icon variant based on button size and squared mode
$iconVariant ??= match($size) {
    'xs' => 'micro',
    'sm' => 'mini',
    'md' => $squared ? 'mini' : 'micro',
    'lg' => $squared ? 'mini' : 'micro',
    default => 'micro',
};


// Build icon classes array, including size, color overrides for variants, and any custom classes
$iconClasses = [
    $iconClasses,
    $size !== 'xs' ? 'size-5' : 'size-4',
    '!text-[var(--color-primary-fg)]' => $variant === 'primary',
    '!text-[var(--color-primary)]' => $variant === 'outline'
];
 
$iconAttributes = (new \Illuminate\View\ComponentAttributeBag())->class($iconClasses);
/* ICONS - END */

// Override theme variables based on the provided color for use in button styling (includes dark mode adjustments)
$colors = match($color) {
    'slate' => '[--color-primary:var(--color-slate-800)] [--color-primary-content:var(--color-slate-800)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-white)] dark:[--color-primary-content:var(--color-white)] dark:[--color-primary-fg:var(--color-slate-800)]',
    'neutral' => '[--color-primary:var(--color-neutral-800)] [--color-primary-content:var(--color-neutral-800)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-white)] dark:[--color-primary-content:var(--color-white)] dark:[--color-primary-fg:var(--color-neutral-800)]',
    'zinc' => '[--color-primary:var(--color-zinc-800)] [--color-primary-content:var(--color-zinc-800)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-white)] dark:[--color-primary-content:var(--color-white)] dark:[--color-primary-fg:var(--color-zinc-800)]',
    'stone' => '[--color-primary:var(--color-stone-800)] [--color-primary-content:var(--color-stone-800)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-white)] dark:[--color-primary-content:var(--color-white)] dark:[--color-primary-fg:var(--color-stone-800)]',
    'red' => '[--color-primary:var(--color-red-500)] [--color-primary-content:var(--color-red-600)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-red-500)] dark:[--color-primary-content:var(--color-red-400)] dark:[--color-primary-fg:var(--color-neutral-50)]',
    'orange' => '[--color-primary:var(--color-orange-500)] [--color-primary-content:var(--color-orange-600)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-orange-400)] dark:[--color-primary-content:var(--color-orange-400)] dark:[--color-primary-fg:var(--color-orange-950)]',
    'amber' => '[--color-primary:var(--color-amber-400)] [--color-primary-content:var(--color-amber-600)] [--color-primary-fg:var(--color-amber-950)] dark:[--color-primary:var(--color-amber-400)] dark:[--color-primary-content:var(--color-amber-400)] dark:[--color-primary-fg:var(--color-amber-950)]',
    'yellow' => '[--color-primary:var(--color-yellow-400)] [--color-primary-content:var(--color-yellow-600)] [--color-primary-fg:var(--color-yellow-950)] dark:[--color-primary:var(--color-yellow-400)] dark:[--color-primary-content:var(--color-yellow-400)] dark:[--color-primary-fg:var(--color-yellow-950)]',
    'lime' => '[--color-primary:var(--color-lime-400)] [--color-primary-content:var(--color-lime-600)] [--color-primary-fg:var(--color-lime-900)] dark:[--color-primary:var(--color-lime-400)] dark:[--color-primary-content:var(--color-lime-400)] dark:[--color-primary-fg:var(--color-lime-950)]',
    'green' => '[--color-primary:var(--color-green-600)] [--color-primary-content:var(--color-green-600)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-green-600)] dark:[--color-primary-content:var(--color-green-400)] dark:[--color-primary-fg:var(--color-neutral-50)]',
    'emerald' => '[--color-primary:var(--color-emerald-600)] [--color-primary-content:var(--color-emerald-600)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-emerald-600)] dark:[--color-primary-content:var(--color-emerald-400)] dark:[--color-primary-fg:var(--color-neutral-50)]',
    'teal' => '[--color-primary:var(--color-teal-600)] [--color-primary-content:var(--color-teal-600)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-teal-600)] dark:[--color-primary-content:var(--color-teal-400)] dark:[--color-primary-fg:var(--color-neutral-50)]',
    'cyan' => '[--color-primary:var(--color-cyan-600)] [--color-primary-content:var(--color-cyan-600)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-cyan-600)] dark:[--color-primary-content:var(--color-cyan-400)] dark:[--color-primary-fg:var(--color-neutral-50)]',
    'sky' => '[--color-primary:var(--color-sky-600)] [--color-primary-content:var(--color-sky-600)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-sky-600)] dark:[--color-primary-content:var(--color-sky-400)] dark:[--color-primary-fg:var(--color-neutral-50)]',
    'blue' => '[--color-primary:var(--color-blue-500)] [--color-primary-content:var(--color-blue-600)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-blue-500)] dark:[--color-primary-content:var(--color-blue-400)] dark:[--color-primary-fg:var(--color-neutral-50)]',
    'indigo' => '[--color-primary:var(--color-indigo-500)] [--color-primary-content:var(--color-indigo-600)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-indigo-500)] dark:[--color-primary-content:var(--color-indigo-300)] dark:[--color-primary-fg:var(--color-neutral-50)]',
    'violet' => '[--color-primary:var(--color-violet-500)] [--color-primary-content:var(--color-violet-600)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-violet-500)] dark:[--color-primary-content:var(--color-violet-400)] dark:[--color-primary-fg:var(--color-neutral-50)]',
    'purple' => '[--color-primary:var(--color-purple-500)] [--color-primary-content:var(--color-purple-600)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-purple-500)] dark:[--color-primary-content:var(--color-purple-300)] dark:[--color-primary-fg:var(--color-neutral-50)]',
    'fuchsia' => '[--color-primary:var(--color-fuchsia-600)] [--color-primary-content:var(--color-fuchsia-600)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-fuchsia-600)] dark:[--color-primary-content:var(--color-fuchsia-400)] dark:[--color-primary-fg:var(--color-neutral-50)]',
    'pink' => '[--color-primary:var(--color-pink-600)] [--color-primary-content:var(--color-pink-600)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-pink-600)] dark:[--color-primary-content:var(--color-pink-400)] dark:[--color-primary-fg:var(--color-neutral-50)]',
    'rose' => '[--color-primary:var(--color-rose-500)] [--color-primary-content:var(--color-rose-500)] [--color-primary-fg:var(--color-neutral-50)] dark:[--color-primary:var(--color-rose-500)] dark:[--color-primary-content:var(--color-rose-400)] dark:[--color-primary-fg:var(--color-neutral-50)]',
    default => '',
};

// Determine variant-specific classes for background, text, borders, and hover states
$variantClasses = match($variant){
    'primary' => array_merge(
        // Use direct Tailwind classes for better browser compatibility when color is specified
        match($color) {
            'teal' => ['!bg-teal-600', 'hover:!bg-teal-700', '!text-white'],
            'green' => ['!bg-green-600', 'hover:!bg-green-700', '!text-white'],
            'blue' => ['!bg-blue-500', 'hover:!bg-blue-600', '!text-white'],
            'red' => ['!bg-red-500', 'hover:!bg-red-600', '!text-white'],
            'emerald' => ['!bg-emerald-600', 'hover:!bg-emerald-700', '!text-white'],
            'cyan' => ['!bg-cyan-600', 'hover:!bg-cyan-700', '!text-white'],
            default => ['!bg-[var(--color-primary)]', 'hover:!bg-[--alpha(var(--color-primary)/50%)]', '!text-[var(--color-primary-fg)]']
        },
        ['border border-black/10 dark:border-0'], // Border styles
        filled($color) && !in_array($color, ['teal', 'green', 'blue', 'red', 'emerald', 'cyan']) ? [$colors] : [] // Only set CSS variables for colors not in direct list
    ),
    'solid' => [
        'bg-neutral-800/5 hover:bg-neutral-800/10 dark:bg-white/10 dark:hover:bg-white/20',
        'text-neutral-800 dark:text-white'
    ],
    'soft' => [
        'text-neutral-500 hover:text-neutral-800 dark:text-neutral-400 dark:hover:text-white',
        ' bg-transparent'
    ],
    'outline' => [
        'border border-[--alpha(var(--color-primary)/50%)] hover:border-[color-mix(in_oklab,_var(--color-primary),_black_20%)]', // Border
        'bg-[--alpha(var(--color-primary)/5%)] hover:bg-[--alpha(var(--color-primary)/10%)]', // Background
        'text-[var(--color-primary)]', 
        $colors => filled($color), // Ensure variables are set
    ],
    'ghost' => [
        'bg-transparent hover:bg-neutral-800/5', // Background colors
        'text-neutral-800' // Text colors
    ],
    'danger' =>[
        ' dark:shadow-none', // Shadow styling
        'bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500', // Background colors
        'text-white' // Text colors
    ],
    'none' => [],
    default => []
};

// Assemble base button classes, including layout, disabled states, and conditional styles
$classes = [
    'relative inline-flex items-center font-medium justify-center gap-x-2 whitespace-nowrap transition-colors duration-200',
    'disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none cursor-pointer',
    '[&_a]:no-underline [&_a]:decoration-none [&_a:hover]:no-underline' => $variant !== 'none' , // Handle anchor tags inside the button
    'rounded-field' => $variant !== 'none' , // Apply rounding unless variant is 'none'
    
    // Handling loading logic via CSS: Show loading indicator as flex and set opacity-0 on its siblings
    '[&>[data-loading=true]:first-child]:flex', // Override 'hidden' to display the loading div during loading
    '[&>[data-loading=true]:first-child~*]:opacity-0', // Apply opacity-0 to all subsequent children (e.g., icons, text)
    $sizeClasses,
    ...$variantClasses,
];

/* LOADING LOGIC - START */

// Check if any wire:loading attributes are present for dynamic handling
$hasWireLoading = filled($attributes->whereStartsWith('wire:loading')->first());

$loadingAttributes = new \Illuminate\View\ComponentAttributeBag();
// Configure loading attributes for Livewire actions (adds data-loading="true" during loading)
$loadingAttributes = $loadingAttributes->merge($hasWireLoading || $type === 'submit' ? [
    'wire:loading.attr' => 'data-loading',
    'wire:target' => $attributes->has('wire:target') ? $attributes->get('wire:target') : ($attributes->whereStartsWith('wire:click')->first() ?? null),
] : []);

// Fallback for non-Livewire cases, I believe there use case for this static case beyond we actually need it in demo docs: 
$loadingAttributes = $loadingAttributes->merge($loading ? [
    'data-loading' => 'true', // thats 'true' is crucial, boolean true will break the work
    ] : []);

/* LOADING LOGIC - END */
?>

<?php if (isset($component)) { $__componentOriginal58500cbfbf20aac906866f14bf9da72c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal58500cbfbf20aac906866f14bf9da72c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.abstract','data' => ['as' => $as,'type' => $type,'attributes' => $attributes->class($classes)->merge([
        'role' => $as === 'a' && !$attributes->has('href') ? 'button' : null,
        'aria-busy' => $loading ? 'true' : 'false',
        'aria-disabled' => $attributes->has('disabled') ? 'true' : 'false',
        // I know it basic, but you can create mapping labels for popular icons like ['x-mark' => 'Close']... 
        'aria-label' => $squared && blank($slot) ? Str::title($icon ?? $iconAfter ?? 'Button') : null,
    ]),'dataSlot' => 'button']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button.abstract'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['as' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($as),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($type),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($attributes->class($classes)->merge([
        'role' => $as === 'a' && !$attributes->has('href') ? 'button' : null,
        'aria-busy' => $loading ? 'true' : 'false',
        'aria-disabled' => $attributes->has('disabled') ? 'true' : 'false',
        // I know it basic, but you can create mapping labels for popular icons like ['x-mark' => 'Close']... 
        'aria-label' => $squared && blank($slot) ? Str::title($icon ?? $iconAfter ?? 'Button') : null,
    ])),'data-slot' => 'button']); ?>
        
        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'absolute inset-0 hidden items-center justify-center '
            ]); ?>"
            
            <?php echo e($loadingAttributes); ?>

        >
            <?php if (isset($component)) { $__componentOriginalf0fb8d54e448565cc9b0ecc2e4078cb1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0fb8d54e448565cc9b0ecc2e4078cb1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.loading','data' => ['variant' => $iconVariant,'dataSlot' => 'loading-indicator','attributes' => $iconAttributes]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon.loading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconVariant),'data-slot' => 'loading-indicator','attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconAttributes)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0fb8d54e448565cc9b0ecc2e4078cb1)): ?>
<?php $attributes = $__attributesOriginalf0fb8d54e448565cc9b0ecc2e4078cb1; ?>
<?php unset($__attributesOriginalf0fb8d54e448565cc9b0ecc2e4078cb1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0fb8d54e448565cc9b0ecc2e4078cb1)): ?>
<?php $component = $__componentOriginalf0fb8d54e448565cc9b0ecc2e4078cb1; ?>
<?php unset($__componentOriginalf0fb8d54e448565cc9b0ecc2e4078cb1); ?>
<?php endif; ?>
        </div> 

    <!--[if BLOCK]><![endif]--><?php if(filled($icon)): ?>
        <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => $icon,'variant' => $iconVariant,'attributes' => $iconAttributes,'dataSlot' => 'right-icon']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconVariant),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconAttributes),'data-slot' => 'right-icon']); ?>
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

    <!--[if BLOCK]><![endif]--><?php if($slot->isNotEmpty()): ?>
        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            '!text-[var(--color-primary-fg)]' => $variant === 'primary' && filled($color),
            'text-inherit' => $variant !== 'primary' || !filled($color)
        ]); ?>">
            <?php echo e($slot); ?>

        </span>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if(filled($iconAfter)): ?>
        <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => $iconAfter,'variant' => $iconVariant,'attributes' => $iconAttributes,'dataSlot' => 'left-icon']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconAfter),'variant' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconVariant),'attributes' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($iconAttributes),'data-slot' => 'left-icon']); ?>
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
<?php if (isset($__attributesOriginal58500cbfbf20aac906866f14bf9da72c)): ?>
<?php $attributes = $__attributesOriginal58500cbfbf20aac906866f14bf9da72c; ?>
<?php unset($__attributesOriginal58500cbfbf20aac906866f14bf9da72c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal58500cbfbf20aac906866f14bf9da72c)): ?>
<?php $component = $__componentOriginal58500cbfbf20aac906866f14bf9da72c; ?>
<?php unset($__componentOriginal58500cbfbf20aac906866f14bf9da72c); ?>
<?php endif; ?><?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/components/ui/button/index.blade.php ENDPATH**/ ?>