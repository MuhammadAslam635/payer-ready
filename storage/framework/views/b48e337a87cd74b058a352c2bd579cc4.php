<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['tagline' => 'Manage your professional credentials and reference providers']));

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

foreach (array_filter((['tagline' => 'Manage your professional credentials and reference providers']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Welcome back, <?php echo e(Auth::user()->name); ?>!</h1>
                <p class="text-slate-600 mt-1"><?php echo e($tagline); ?></p>
            </div>
            <div class="text-sm text-slate-500">
                Last updated: <?php echo e(now()->format('M d, Y \a\t g:i A')); ?>

            </div>
        </div>
    </div>
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/components/breadcrumbs.blade.php ENDPATH**/ ?>