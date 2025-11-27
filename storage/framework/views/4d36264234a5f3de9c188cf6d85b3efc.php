<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Solutions | PayerReady</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-white min-h-screen flex flex-col">
    <?php if (isset($component)) { $__componentOriginal5214b438fcc0cb574166d38dd3f20dce = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5214b438fcc0cb574166d38dd3f20dce = $attributes; } ?>
<?php $component = App\View\Components\Web\Header::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('web.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Web\Header::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5214b438fcc0cb574166d38dd3f20dce)): ?>
<?php $attributes = $__attributesOriginal5214b438fcc0cb574166d38dd3f20dce; ?>
<?php unset($__attributesOriginal5214b438fcc0cb574166d38dd3f20dce); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5214b438fcc0cb574166d38dd3f20dce)): ?>
<?php $component = $__componentOriginal5214b438fcc0cb574166d38dd3f20dce; ?>
<?php unset($__componentOriginal5214b438fcc0cb574166d38dd3f20dce); ?>
<?php endif; ?>

    <main class="flex-1">
        <section class="bg-primary-50 border-b border-primary-100">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
                <p class="text-primary-600 font-semibold uppercase tracking-wide">Our Solutions</p>
                <h1 class="mt-3 text-3xl sm:text-4xl font-bold text-gray-900">
                    Expert-Led Credentialing & Compliance Support
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    Comprehensive services that help providers maintain credentialing, licensing, and payer enrollment without the administrative headaches.
                </p>
            </div>
        </section>

        <section class="py-16">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <?php if (isset($component)) { $__componentOriginalb7e3da6da61b0e29b1abdd02f31f940e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb7e3da6da61b0e29b1abdd02f31f940e = $attributes; } ?>
<?php $component = App\View\Components\Web\WhyChooseSection::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('web.why-choose-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Web\WhyChooseSection::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb7e3da6da61b0e29b1abdd02f31f940e)): ?>
<?php $attributes = $__attributesOriginalb7e3da6da61b0e29b1abdd02f31f940e; ?>
<?php unset($__attributesOriginalb7e3da6da61b0e29b1abdd02f31f940e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb7e3da6da61b0e29b1abdd02f31f940e)): ?>
<?php $component = $__componentOriginalb7e3da6da61b0e29b1abdd02f31f940e; ?>
<?php unset($__componentOriginalb7e3da6da61b0e29b1abdd02f31f940e); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalbdac7d6121f47dbaaac367d3cf43d37c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbdac7d6121f47dbaaac367d3cf43d37c = $attributes; } ?>
<?php $component = App\View\Components\Web\Stats::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('web.stats'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Web\Stats::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbdac7d6121f47dbaaac367d3cf43d37c)): ?>
<?php $attributes = $__attributesOriginalbdac7d6121f47dbaaac367d3cf43d37c; ?>
<?php unset($__attributesOriginalbdac7d6121f47dbaaac367d3cf43d37c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbdac7d6121f47dbaaac367d3cf43d37c)): ?>
<?php $component = $__componentOriginalbdac7d6121f47dbaaac367d3cf43d37c; ?>
<?php unset($__componentOriginalbdac7d6121f47dbaaac367d3cf43d37c); ?>
<?php endif; ?>
            </div>
        </section>
    </main>

    <?php if (isset($component)) { $__componentOriginald09e21c7de4c5e89c383822ca51b2a9a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald09e21c7de4c5e89c383822ca51b2a9a = $attributes; } ?>
<?php $component = App\View\Components\Web\Cta::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('web.cta'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Web\Cta::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald09e21c7de4c5e89c383822ca51b2a9a)): ?>
<?php $attributes = $__attributesOriginald09e21c7de4c5e89c383822ca51b2a9a; ?>
<?php unset($__attributesOriginald09e21c7de4c5e89c383822ca51b2a9a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald09e21c7de4c5e89c383822ca51b2a9a)): ?>
<?php $component = $__componentOriginald09e21c7de4c5e89c383822ca51b2a9a; ?>
<?php unset($__componentOriginald09e21c7de4c5e89c383822ca51b2a9a); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal8a8716efb3c62a45938aca52e78e0322 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8a8716efb3c62a45938aca52e78e0322 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $attributes = $__attributesOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__attributesOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8a8716efb3c62a45938aca52e78e0322)): ?>
<?php $component = $__componentOriginal8a8716efb3c62a45938aca52e78e0322; ?>
<?php unset($__componentOriginal8a8716efb3c62a45938aca52e78e0322); ?>
<?php endif; ?>
</body>
</html>

<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/pages/solutions.blade.php ENDPATH**/ ?>