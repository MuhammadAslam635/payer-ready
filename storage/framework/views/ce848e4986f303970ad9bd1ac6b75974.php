<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Welcome back, <?php echo e(Auth::user()->name); ?>!</h1>
                <p class="text-slate-600 mt-1">Manage your professional credentials and reference providers</p>
                <!--[if BLOCK]><![endif]--><?php if($stats['clinic']): ?>
                    <p class="text-sm text-slate-500 mt-1"><?php echo e($stats['clinic']->business_name); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="text-sm text-slate-500">
                Last updated: <?php echo e(now()->format('M d, Y \a\t g:i A')); ?>

            </div>
        </div>
    </div>

    <!-- Main Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Active Licenses -->
        <div class="bg-white rounded-lg border border-blue-200 p-6 relative">
            <div class="absolute top-4 right-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
            </div>
            <div class="pr-16">
                <h3 class="text-sm font-medium text-gray-600 mb-1">Active Licenses</h3>
                <p class="text-3xl font-bold text-black"><?php echo e(number_format($stats['activeLicenses'])); ?></p>
                <p class="text-sm text-gray-500 mt-1"><?php echo e($stats['totalLicenses']); ?> total licenses</p>
            </div>
        </div>

        <!-- Verified Documents -->
        <div class="bg-white rounded-lg border border-blue-200 p-6 relative">
            <div class="absolute top-4 right-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <div class="pr-16">
                <h3 class="text-sm font-medium text-gray-600 mb-1">Verified Documents</h3>
                <p class="text-3xl font-bold text-black"><?php echo e(number_format($stats['verifiedDocuments'])); ?></p>
                <p class="text-sm text-gray-500 mt-1"><?php echo e($stats['totalDocuments']); ?> total documents</p>
            </div>
        </div>

        <!-- Work History -->
        <div class="bg-white rounded-lg border border-blue-200 p-6 relative">
            <div class="absolute top-4 right-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                    </svg>
                </div>
            </div>
            <div class="pr-16">
                <h3 class="text-sm font-medium text-gray-600 mb-1">Work History</h3>
                <p class="text-3xl font-bold text-black"><?php echo e(number_format($stats['totalWorkHistory'])); ?></p>
                <p class="text-sm text-gray-500 mt-1">Positions</p>
            </div>
        </div>

        <!-- Reference Providers -->
        <div class="bg-white rounded-lg border border-blue-200 p-6 relative">
            <div class="absolute top-4 right-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <div class="pr-16">
                <h3 class="text-sm font-medium text-gray-600 mb-1">Reference Providers</h3>
                <p class="text-3xl font-bold text-black"><?php echo e(number_format($stats['totalReferences'])); ?></p>
                <p class="text-sm text-gray-500 mt-1">Professional references</p>
            </div>
        </div>
    </div>

    <!-- Reference Providers Section -->

        <!-- Add First Reference Provider Call-to-Action -->
        <div class="bg-white rounded-lg shadow-sm border-2 border-dashed border-slate-300 p-12">
            <div class="text-center">
                <div class="mx-auto h-24 w-24 bg-slate-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">Update Your Profile</h3>
                <p class="text-slate-600 mb-6 max-w-md mx-auto">
                     Work credentialing, verification, and professional relationships.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?php echo e(route('doctor.profile')); ?>" wire:navigate class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Show Profile
                    </a>
                </div>
                <p class="text-sm text-slate-500 mt-4">
                    Need to import many references? Bulk import will arrive soon.
                </p>
            </div>
        </div>

    <!-- Latest Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Latest Licenses -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest Licenses</h3>
            </div>
            <div class="p-6">
                <!--[if BLOCK]><![endif]--><?php if($stats['latestLicenses']->count() > 0): ?>
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stats['latestLicenses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $license): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-900"><?php echo e($license['license_number']); ?></p>
                                    <p class="text-sm text-slate-500"><?php echo e($license['state']); ?></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($license['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php echo e($license['is_active'] ? 'Active' : 'Expired'); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <p class="text-slate-500 text-center py-4">No licenses found</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Latest Documents -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest Documents</h3>
            </div>
            <div class="p-6">
                <!--[if BLOCK]><![endif]--><?php if($stats['latestDocuments']->count() > 0): ?>
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stats['latestDocuments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-900"><?php echo e($document['document_type']); ?></p>
                                    <p class="text-sm text-slate-500"><?php echo e($document['original_filename']); ?></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($document['is_verified'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                        <?php echo e($document['is_verified'] ? 'Verified' : 'Pending'); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <p class="text-slate-500 text-center py-4">No documents found</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
</div>
<?php /**PATH E:\payer-ready\resources\views/livewire/dashboard/doctor-dashboard-component.blade.php ENDPATH**/ ?>