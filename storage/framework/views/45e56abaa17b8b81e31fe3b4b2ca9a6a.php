<nav class="bg-white border-b border-gray-200 sticky top-0 z-50" x-data="{ mobileMenuOpen: false }" x-on:click.away="mobileMenuOpen = false">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="<?php echo e(route('home')); ?>" class="text-text-secondary hover:text-primary-600 transition-colors">Home</a>
                <a href="<?php echo e(route('solutions')); ?>" class="text-text-secondary hover:text-primary-600 transition-colors">Solutions</a>
                <a href="<?php echo e(route('how-it-works')); ?>" class="text-text-secondary hover:text-primary-600 transition-colors">How It Works</a>
                <a href="<?php echo e(route('pricing')); ?>" class="text-text-secondary hover:text-primary-600 transition-colors">Pricing</a>
                <a href="<?php echo e(route('resources')); ?>" class="text-text-secondary hover:text-primary-600 transition-colors">Resources</a>
                <a href="<?php echo e(route('about')); ?>" class="text-text-secondary hover:text-primary-600 transition-colors">About</a>
            </div>

            <!-- Desktop Auth Links -->
            <div class="hidden lg:flex items-center space-x-4">
                <a href="<?php echo e(route('login')); ?>" wire:navigate class="text-text-secondary hover:text-primary-600 transition-colors">
                    Sign In
                </a>
                <a href="<?php echo e(route('register')); ?>" wire:navigate class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                    Get Started
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
                        aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Hamburger icon -->
                    <svg x-show="!mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Close icon -->
                    <svg x-show="mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="lg:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
                <!-- Mobile Navigation Links -->
                <a href="<?php echo e(route('home')); ?>" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-text-secondary hover:text-primary-600 hover:bg-gray-50 rounded-md transition-colors">Home</a>
                <a href="<?php echo e(route('solutions')); ?>" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-text-secondary hover:text-primary-600 hover:bg-gray-50 rounded-md transition-colors">Solutions</a>
                <a href="<?php echo e(route('how-it-works')); ?>" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-text-secondary hover:text-primary-600 hover:bg-gray-50 rounded-md transition-colors">How It Works</a>
                <a href="<?php echo e(route('pricing')); ?>" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-text-secondary hover:text-primary-600 hover:bg-gray-50 rounded-md transition-colors">Pricing</a>
                <a href="<?php echo e(route('resources')); ?>" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-text-secondary hover:text-primary-600 hover:bg-gray-50 rounded-md transition-colors">Resources</a>
                <a href="<?php echo e(route('about')); ?>" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-text-secondary hover:text-primary-600 hover:bg-gray-50 rounded-md transition-colors">About</a>

                <!-- Mobile Auth Links -->
                <div class="border-t border-gray-200 pt-4 mt-4">
                    <a href="<?php echo e(route('login')); ?>" wire:navigate class="block px-3 py-2 text-base font-medium text-text-secondary hover:text-primary-600 hover:bg-gray-50 rounded-md transition-colors">
                        Sign In
                    </a>
                    <a href="<?php echo e(route('register')); ?>" wire:navigate class="block px-3 py-2 text-base font-medium bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-colors mt-2">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/components/web/header.blade.php ENDPATH**/ ?>