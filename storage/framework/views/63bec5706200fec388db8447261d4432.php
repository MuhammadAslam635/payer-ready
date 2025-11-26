
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'disabled' => false,
    'resize' => 'vertical',
    'name' => $attributes->whereStartsWith('wire:model')->first() ?? $attributes->whereStartsWith('x-model')->first(),
    'rows' => null,
    'invalid' => null,
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
    'disabled' => false,
    'resize' => 'vertical',
    'name' => $attributes->whereStartsWith('wire:model')->first() ?? $attributes->whereStartsWith('x-model')->first(),
    'rows' => null,
    'invalid' => null,
    ]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $rows ??= 3;

    $initialHeight = (($rows) * 1.5) + 0.75;

    $classes = [
        // Text colors
        'inline-block p-2 w-full text-base sm:text-sm text-neutral-800 disabled:text-neutral-500 placeholder-neutral-400 disabled:placeholder-neutral-400/70',

        // Background
        'bg-white',

        // Cursor and transitions
        'disabled:cursor-not-allowed transition-colors duration-200',

        // Shadows and borders
        'shadow-sm disabled:shadow-none border rounded-box',

        // Focus outline
        'focus:ring-2 focus:ring-offset-0 focus:outline-none',

        // Normal state borders and focus rings
        'border-black/10 focus:border-black/15 focus:ring-neutral-900/15' => !$invalid,

        // Invalid state borders and focus rings
        'border-red-500 focus:border-red-500 focus:ring-red-500/25' => $invalid,

        // Resize handling
        match ($resize) {
            'none' => 'resize-none',
            'both' => 'resize',
            'horizontal' => 'resize-x',
            'vertical' => 'resize-y',
        },
    ];
?>


<textarea
    x-data="{
        initialHeight: <?php echo \Illuminate\Support\Js::from($initialHeight)->toHtml() ?> + 'rem',
        height: <?php echo \Illuminate\Support\Js::from($initialHeight)->toHtml() ?> + 'rem',
        name: <?php echo \Illuminate\Support\Js::from($name)->toHtml() ?>,
        state: '',
        resize() {
            if (!this.$el) return;
            this.$el.style.height = 'auto';
            let newHeight = this.$el.scrollHeight + 'px';

            if (this.$el.scrollHeight < parseFloat(this.initialHeight)) {
                this.$el.style.height = this.initialHeight;
            } else {
                this.$el.style.height = newHeight;
            }
        }
    }"
    x-init="
        $nextTick(() => {
            // Initialize state from x-model or wire:model binding
            this.state = this.$root?._x_model?.get();
        })

        // Two-way data binding: sync internal state back to Alpine/Livewire
        $watch('state', (value) => {
            // Sync with Alpine.js x-model
            this.$root?._x_model?.set(value);
                
            // Sync with Livewire wire:model (if present)
            let wireModel = this.$root.getAttributeNames().find(n => n.startsWith('wire:model'))
                
            if(this.$wire && wireModel){
                let prop = this.$root.getAttribute(wireModel)
                this.$wire.set(prop, value, wireModel?.includes('.live'));
            }
        });

        if(!this.$el) return;

        // give our textarea initial height based on the provided rows
        this.$el.style.height = this.initialHeight;

        const observer = new ResizeObserver(() => {
            this.resize();
        });

        observer.observe(this.$el);
    "
    <?php echo e($attributes->class(Arr::toCssClasses($classes))); ?>

    <?php if($disabled): echo 'disabled'; endif; ?>
    <?php if($invalid): ?> aria-invalid="true" data-slot="invalid" <?php endif; ?>
    data-slot="textarea"
    x-intersect.once="resize()"
    rows=<?php echo e($rows); ?>

    x-on:input.stop="resize()"
    x-on:resize.window="resize()"
    x-on:keydown="resize()"
></textarea>
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/components/ui/textarea/index.blade.php ENDPATH**/ ?>