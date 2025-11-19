<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="min-h-screen bg-bg-secondary py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                
                <h1 class="text-3xl font-bold text-text-primary">Create Your Account</h1>
                <p class="text-text-secondary mt-2">Choose your account type to get started</p>
            </div>

            <!-- Account Type Selection -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-text-primary mb-6 text-center">Choose Your Account Type</h2>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Doctor Card -->
                    <a href="<?php echo e(route('doctor-register')); ?>" wire:navigate class="block">
                        <div class="border-2 rounded-lg p-6 cursor-pointer transition-all hover:shadow-md hover:border-primary-500 hover:bg-primary-50 border-gray-200">
                                <div class="text-center">
                                    <div class="w-16 h-16 mx-auto mb-4 bg-primary-100 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-text-primary mb-2">I'm a Doctor</h3>
                                    <p class="text-text-secondary">Solo practitioner managing your own credentialing and enrollment</p>
                                </div>
                            </div>
                    </a>

                            <!-- Organization Card -->
                    <a href="<?php echo e(route('organization-register')); ?>" wire:navigate class="block">
                        <div class="border-2 rounded-lg p-6 cursor-pointer transition-all hover:shadow-md hover:border-primary-500 hover:bg-primary-50 border-gray-200">
                                <div class="text-center">
                                    <div class="w-16 h-16 mx-auto mb-4 bg-primary-100 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-text-primary mb-2">We are an Organization</h3>
                                    <p class="text-text-secondary">Group practice, facility, MSO, or hospital</p>
                                </div>
                            </div>
                    </a>
                        </div>

                <div class="text-center mt-8">
                    <p class="text-text-secondary text-sm">
                        Click on your account type above to start your registration
                    </p>
                    </div>
            </div>

            <!-- Footer Links -->
            <div class="text-center mt-8">
                <p class="text-text-secondary">
                    Already have an account?
                    <a href="<?php echo e(route('login')); ?>" wire:navigate class="text-primary-600 hover:text-primary-700 font-medium">Sign in here</a>
                </p>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/auth/register.blade.php ENDPATH**/ ?>