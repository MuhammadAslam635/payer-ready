<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PayerReady - Expert-Led Credentialing & Compliance</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="min-h-screen bg-white">
    <!-- Header -->
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

    <!-- Hero Section -->
    <?php if (isset($component)) { $__componentOriginal7093b478d32fe74c8dbf368ff1136fdc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7093b478d32fe74c8dbf368ff1136fdc = $attributes; } ?>
<?php $component = App\View\Components\Web\Hero::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('web.hero'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Web\Hero::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7093b478d32fe74c8dbf368ff1136fdc)): ?>
<?php $attributes = $__attributesOriginal7093b478d32fe74c8dbf368ff1136fdc; ?>
<?php unset($__attributesOriginal7093b478d32fe74c8dbf368ff1136fdc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7093b478d32fe74c8dbf368ff1136fdc)): ?>
<?php $component = $__componentOriginal7093b478d32fe74c8dbf368ff1136fdc; ?>
<?php unset($__componentOriginal7093b478d32fe74c8dbf368ff1136fdc); ?>
<?php endif; ?>

    <!-- Stats Section -->
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

    <!-- Why Choose Us Section -->
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

    <!-- Process Section -->
    <?php if (isset($component)) { $__componentOriginal7b1770675917c5feaf66a25adc5749f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7b1770675917c5feaf66a25adc5749f5 = $attributes; } ?>
<?php $component = App\View\Components\Web\ProcessSection::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('web.process-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Web\ProcessSection::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7b1770675917c5feaf66a25adc5749f5)): ?>
<?php $attributes = $__attributesOriginal7b1770675917c5feaf66a25adc5749f5; ?>
<?php unset($__attributesOriginal7b1770675917c5feaf66a25adc5749f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7b1770675917c5feaf66a25adc5749f5)): ?>
<?php $component = $__componentOriginal7b1770675917c5feaf66a25adc5749f5; ?>
<?php unset($__componentOriginal7b1770675917c5feaf66a25adc5749f5); ?>
<?php endif; ?>

    <!-- Testimonials Section -->
    <?php if (isset($component)) { $__componentOriginal70a6756853514bae6852282712455997 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal70a6756853514bae6852282712455997 = $attributes; } ?>
<?php $component = App\View\Components\Web\Testimonials::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('web.testimonials'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Web\Testimonials::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal70a6756853514bae6852282712455997)): ?>
<?php $attributes = $__attributesOriginal70a6756853514bae6852282712455997; ?>
<?php unset($__attributesOriginal70a6756853514bae6852282712455997); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal70a6756853514bae6852282712455997)): ?>
<?php $component = $__componentOriginal70a6756853514bae6852282712455997; ?>
<?php unset($__componentOriginal70a6756853514bae6852282712455997); ?>
<?php endif; ?>

    <!-- Comparison Section -->
    <?php if (isset($component)) { $__componentOriginale9ee986ccbefc241198de78b9c69882a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale9ee986ccbefc241198de78b9c69882a = $attributes; } ?>
<?php $component = App\View\Components\Web\Comparison::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('web.comparison'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Web\Comparison::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale9ee986ccbefc241198de78b9c69882a)): ?>
<?php $attributes = $__attributesOriginale9ee986ccbefc241198de78b9c69882a; ?>
<?php unset($__attributesOriginale9ee986ccbefc241198de78b9c69882a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale9ee986ccbefc241198de78b9c69882a)): ?>
<?php $component = $__componentOriginale9ee986ccbefc241198de78b9c69882a; ?>
<?php unset($__componentOriginale9ee986ccbefc241198de78b9c69882a); ?>
<?php endif; ?>

    <!-- FAQ Section -->
    <?php if (isset($component)) { $__componentOriginal4a7cf00588329483d411f3c52c4cb8e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4a7cf00588329483d411f3c52c4cb8e9 = $attributes; } ?>
<?php $component = App\View\Components\Web\Faq::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('web.faq'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Web\Faq::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4a7cf00588329483d411f3c52c4cb8e9)): ?>
<?php $attributes = $__attributesOriginal4a7cf00588329483d411f3c52c4cb8e9; ?>
<?php unset($__attributesOriginal4a7cf00588329483d411f3c52c4cb8e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4a7cf00588329483d411f3c52c4cb8e9)): ?>
<?php $component = $__componentOriginal4a7cf00588329483d411f3c52c4cb8e9; ?>
<?php unset($__componentOriginal4a7cf00588329483d411f3c52c4cb8e9); ?>
<?php endif; ?>

    <!-- Final CTA Section -->
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

    <!-- Footer -->
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
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/welcome.blade.php ENDPATH**/ ?>