<?php foreach (([
    'searchable' => false,
]) as $__key => $__value) {
    $__consumeVariable = is_string($__key) ? $__key : $__value;
    $$__consumeVariable = is_string($__key) ? $__env->getConsumableComponentData($__key, $__value) : $__env->getConsumableComponentData($__value);
} ?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'checkIcon' => 'check'
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
    'checkIcon' => 'check'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div 
    x-show="open"
    x-trap="open"
    x-effect="
        if(!open) $el.blur()
    "
    x-anchor.offset.5="$refs.selectTrigger"
    x-transition 
    x-on:click.away="close()"
    x-on:keydown.escape="close()"
    style="display: none;"
    class="bg-white w-full z-50 rounded-(--round) border border-neutral-200 max-h-60 overflow-y-auto"
>
    <!--[if BLOCK]><![endif]--><?php if($searchable): ?>
        <div
            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'grid items-center justify-center grid-cols-[20px_1fr] px-2', // give the icon 20 px and leave the input take the rest
                '[&>[data-slot=icon]+[data-slot=search-control]]:pl-6', // because there is an icon give it 6 padding   
                'w-full border-b border-neutral-200',
            ]); ?>"    
        >
            <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'magnifying-glass','class' => 'col-span-1 col-start-1 row-start-1 !text-neutral-500 !size-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'magnifying-glass','class' => 'col-span-1 col-start-1 row-start-1 !text-neutral-500 !size-5']); ?>
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

            <input 
                x-model="search"
                x-on:input.stop="isTyping = true"
                x-on:keydown.down.prevent.stop="handleKeydown($event)"
                x-on:keydown.up.prevent.stop="handleKeydown($event)"
                x-on:keydown.enter.prevent.stop="handleKeydown($event)"
                x-bind:aria-activedescendant="activeIndex !== null ? 'option-' + activeIndex : null"
                type="text"
                x-ref='searchControl'
                data-slot="search-control"
                placeholder="search..."
                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'bg-transparent placeholder:text-neutral-500 text-neutral-900',
                    'ring-0 ring-offset-0 outline-none focus:ring-0 border-0',
                    'col-span-4 col-start-1 row-start-1',
                ]); ?>"
            >
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    
    <ul 
        role="listbox"
        x-on:keydown.enter.prevent.stop="select($focus.focused().dataset.value)"
        x-on:keydown.up.prevent.stop="$focus.wrap().prev()"
        x-on:keydown.down.prevent.stop="$focus.wrap().next()"
        class="<?php echo \Illuminate\Support\Arr::toCssClasses([
            "grid grid-cols-[auto_auto_1fr] !p-(--padding) gap-y-1",
        ]); ?>"
    >
        <?php echo e($slot); ?>

    </ul>
    <template x-if="isSearchable && isTyping && !hasFilteredResults">
        <?php if (isset($component)) { $__componentOriginal47a99b571099212b0c284f0080dfbeaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal47a99b571099212b0c284f0080dfbeaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.text','data' => ['class' => 'h-14 flex items-center justify-center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-14 flex items-center justify-center']); ?>
            no results found
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal47a99b571099212b0c284f0080dfbeaa)): ?>
<?php $attributes = $__attributesOriginal47a99b571099212b0c284f0080dfbeaa; ?>
<?php unset($__attributesOriginal47a99b571099212b0c284f0080dfbeaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal47a99b571099212b0c284f0080dfbeaa)): ?>
<?php $component = $__componentOriginal47a99b571099212b0c284f0080dfbeaa; ?>
<?php unset($__componentOriginal47a99b571099212b0c284f0080dfbeaa); ?>
<?php endif; ?>
    </template>
</div><?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/components/ui/select/options.blade.php ENDPATH**/ ?>