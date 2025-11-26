<div>
    <!-- Success Message -->
    <!--[if BLOCK]><![endif]--><?php if(session('success')): ?>
        <div class="bg-success-50 border-b border-success-200 px-4 py-3">
            <div class="max-w-7xl mx-auto">
                <p class="text-success-800 text-center"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">
            <!-- Smart Checklist Sidebar -->
            <div class="w-80 bg-white rounded-xl shadow-sm border border-border p-6 h-fit">
                <h3 class="text-lg font-bold text-text-primary mb-6">Your Smart Checklist</h3>
                <div class="space-y-3">
                    <!-- Step 1: Welcome & Core Profile -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer <?php echo e($currentStep >= 1 ? 'bg-success-50' : 'bg-gray-50'); ?>"
                         wire:click="goToStep(1)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center <?php echo e($currentStep > 1 ? 'bg-success-500 text-white' : ($currentStep == 1 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500')); ?>">
                            <!--[if BLOCK]><![endif]--><?php if($currentStep > 1): ?>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            <?php else: ?>
                                1
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <span class="font-medium text-text-primary">Welcome & Core Profile</span>
                    </div>

                    
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow-sm border border-border p-8">
                    <!-- Optional Information Banner -->
                    <!--[if BLOCK]><![endif]--><?php if($currentStep != 7): ?>
                        <div class="bg-primary-50 border border-primary-200 rounded-lg p-4 mb-6">
                            <div class="flex">
                                <svg class="w-5 h-5 text-primary-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h3 class="text-sm font-medium text-primary-800">Optional Information</h3>
                                    <p class="text-sm text-primary-700 mt-1">Don't have the details handy? No problem. You can skip these for now and add them later from your dashboard.</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- Step Content -->
                    <div class="min-h-96">
                        <!--[if BLOCK]><![endif]--><?php if($currentStep == 1): ?>
                            <?php if (isset($component)) { $__componentOriginal683855d42c8ae39983c1c0539eb167fb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal683855d42c8ae39983c1c0539eb167fb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth.sign-up-form','data' => ['userType' => $userType,'specialties' => $specialties,'states' => $states,'errors' => $errors]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth.sign-up-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['userType' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($userType),'specialties' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($specialties),'states' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($states),'errors' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal683855d42c8ae39983c1c0539eb167fb)): ?>
<?php $attributes = $__attributesOriginal683855d42c8ae39983c1c0539eb167fb; ?>
<?php unset($__attributesOriginal683855d42c8ae39983c1c0539eb167fb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal683855d42c8ae39983c1c0539eb167fb)): ?>
<?php $component = $__componentOriginal683855d42c8ae39983c1c0539eb167fb; ?>
<?php unset($__componentOriginal683855d42c8ae39983c1c0539eb167fb); ?>
<?php endif; ?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center mt-8 pt-6 border-t border-border">
                        <div></div>

                        <div class="flex items-center gap-4">
                            <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','wire:click' => 'submitForm','wire:loading.attr' => 'enabled','wire:target' => 'submitForm','wire:loading.class' => 'opacity-50 cursor-not-allowed disabled:opacity-50 disabled:cursor-not-allowed','xOn:click' => 'setTimeout(() => window.scrollTo({top: 0, behavior: \'smooth\'}), 100)','class' => 'px-8 py-3 bg-success-600 hover:bg-success-700 text-white font-semibold rounded-lg transition-colors']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','wire:click' => 'submitForm','wire:loading.attr' => 'enabled','wire:target' => 'submitForm','wire:loading.class' => 'opacity-50 cursor-not-allowed disabled:opacity-50 disabled:cursor-not-allowed','x-on:click' => 'setTimeout(() => window.scrollTo({top: 0, behavior: \'smooth\'}), 100)','class' => 'px-8 py-3 bg-success-600 hover:bg-success-700 text-white font-semibold rounded-lg transition-colors']); ?>
                                <span wire:loading.remove wire:target="submitForm">Submit</span>
                                <span wire:loading wire:target="submitForm" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Submitting...
                                </span>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $attributes = $__attributesOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__attributesOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $component = $__componentOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__componentOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/livewire/registration.blade.php ENDPATH**/ ?>