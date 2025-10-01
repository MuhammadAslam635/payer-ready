<div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-[#14b8a6] to-[#0d9488] px-6 py-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <!-- Profile Photo -->
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <!--[if BLOCK]><![endif]--><?php if(auth()->user()->profile_photo_url): ?>
                            <img src="<?php echo e(auth()->user()->profile_photo_url); ?>" alt="<?php echo e(auth()->user()->name); ?>" class="w-20 h-20 rounded-full object-cover">
                        <?php else: ?>
                            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-green-600">
                                    <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                                </span>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="flex-1 text-center sm:text-left">
                    <h2 class="text-2xl font-bold text-white mb-2">
                        <?php echo e(auth()->user()->name); ?>

                        <?php if(auth()->user()->middle_name): ?>
                            <?php echo e(auth()->user()->middle_name); ?>

                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </h2>
                    <p class="text-green-100 mb-3">
                        <?php echo e(auth()->user()->specialties->first()?->name ?? 'Medical Professional'); ?>

                    </p>
                    <div class="flex flex-col sm:flex-row gap-2 text-sm text-green-100">
                        <span class="flex items-center justify-center sm:justify-start">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <?php echo e(auth()->user()->email); ?>

                        </span>
                        <?php if(auth()->user()->phone): ?>
                            <span class="flex items-center justify-center sm:justify-start">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <?php echo e(auth()->user()->phone); ?>

                            </span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white text-green-600">
                        <svg class="w-2 h-2 mr-2 fill-current" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3"/>
                        </svg>
                        <?php echo e(auth()->user()->is_active ? 'Active' : 'Inactive'); ?>

                    </span>
                </div>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Personal Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Personal Information</h3>

                    <?php if(auth()->user()->date_of_birth): ?>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-slate-600">Date of Birth:</span>
                            <span class="text-sm text-slate-900"><?php echo e(\Carbon\Carbon::parse(auth()->user()->date_of_birth)->format('M d, Y')); ?></span>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <?php if(auth()->user()->npi_number): ?>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-slate-600">NPI Number:</span>
                            <span class="text-sm text-slate-900 font-mono"><?php echo e(auth()->user()->npi_number); ?></span>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <?php if(auth()->user()->dea_number): ?>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-slate-600">DEA Number:</span>
                            <span class="text-sm text-slate-900 font-mono"><?php echo e(auth()->user()->dea_number); ?></span>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <?php if(auth()->user()->dea_expiration_date): ?>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-slate-600">DEA Expiration:</span>
                            <span class="text-sm text-slate-900"><?php echo e(\Carbon\Carbon::parse(auth()->user()->dea_expiration_date)->format('M d, Y')); ?></span>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- Professional Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Professional Information</h3>

                    <?php if(auth()->user()->specialties->count() > 0): ?>
                        <div>
                            <span class="text-sm font-medium text-slate-600 block mb-2">Specialties:</span>
                            <div class="space-y-1">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = auth()->user()->specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <?php echo e($specialty->name); ?>

                                        <!--[if BLOCK]><![endif]--><?php if($specialty->pivot->is_primary): ?>
                                            <span class="ml-1 text-green-600">•</span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <?php if(auth()->user()->caqh_id): ?>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-slate-600">CAQH ID:</span>
                            <span class="text-sm text-slate-900 font-mono"><?php echo e(auth()->user()->caqh_id); ?></span>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-600">Member Since:</span>
                        <span class="text-sm text-slate-900"><?php echo e(auth()->user()->created_at->format('M Y')); ?></span>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2">Account Status</h3>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-600">Email Verified:</span>
                            <span class="inline-flex items-center">
                                <?php if(auth()->user()->email_verified_at): ?>
                                    <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-green-600">Verified</span>
                                <?php else: ?>
                                    <svg class="w-4 h-4 text-red-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-red-600">Not Verified</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-600">E-Signature:</span>
                            <span class="inline-flex items-center">
                                <?php if(auth()->user()->e_signature): ?>
                                    <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-green-600">Completed</span>
                                <?php else: ?>
                                    <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-yellow-600">Pending</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-600">Terms Accepted:</span>
                            <span class="inline-flex items-center">
                                <?php if(auth()->user()->terms_condition): ?>
                                    <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-green-600">Accepted</span>
                                <?php else: ?>
                                    <svg class="w-4 h-4 text-red-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm text-red-600">Not Accepted</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 pt-6 border-t border-slate-200">
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?php echo e(route('doctor.profile')); ?>" wire:navigate class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#0d9488] hover:bg-[#0d9488] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors duration-200">

                        Provider Profile
                    </a>
                </div>
                <p class="text-sm text-slate-500 mt-4 text-center">
                    Keep your profile updated for better credentialing and verification processes.
                </p>
            </div>
        </div>
    </div>
<?php /**PATH E:\payer-ready\resources\views/components/provider-profile-section.blade.php ENDPATH**/ ?>