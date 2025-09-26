<!-- Main Grid Layout: 3 columns for lg, 1 column for sm -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left Sidebar: User Profile (Column 1) -->
    <div class="lg:col-span-1 space-y-6 min-h-screen">
        <!-- User Profile Card -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="text-center">
                <!-- Profile Image -->
                <div
                    class="mx-auto w-24 h-24 rounded-full bg-gradient-to-r from-teal-400 to-blue-500 flex items-center justify-center mb-4">
                    <!--[if BLOCK]><![endif]--><?php if(auth()->user()->profile_photo_path): ?>
                        <img src="<?php echo e(auth()->user()->profile_photo_url); ?>" alt="<?php echo e(auth()->user()->name); ?>"
                            class="w-24 h-24 rounded-full object-cover">
                    <?php else: ?>
                        <span class="text-2xl font-bold text-white"><?php echo e(substr(auth()->user()->name, 0, 1)); ?></span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- User Info -->
                <h2 class="text-xl font-bold text-slate-900"><?php echo e(auth()->user()->name); ?></h2>
                <p class="text-slate-600 text-sm"><?php echo e(auth()->user()->email); ?></p>

                <!-- Status Badge -->
                <div class="flex items-center justify-center mt-4">
                    <span class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <?php echo e(Auth::user()->is_active ? 'Active' : 'Pending'); ?>

                    </span>
                </div>

            </div>

            <!-- User Details -->
            <div class="mt-6 space-y-3">
                <div class="flex justify-between">
                        <span class="text-sm text-slate-500">Middle Name:</span>
                        <span class="text-sm font-medium text-slate-900"><?php echo e(Auth::user()->middle_name ?? 'N/A'); ?></span>
                    </div>
                <!--[if BLOCK]><![endif]--><?php if(Auth::user()): ?>
                    <?php if(Auth::user()->npi_number): ?>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-500">NPI:</span>
                            <span class="text-sm font-medium text-slate-900"><?php echo e(Auth::user()->npi_number); ?></span>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-500">DEA Number:</span>
                        <span class="text-sm font-medium text-slate-900"><?php echo e(Auth::user()->dea_number ?? 'N/A'); ?></span>
                    </div>
                    <?php if(Auth::user()->dea_expiration_date): ?>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-500">Expiration At:</span>
                            <span class="text-sm font-medium text-slate-900"><?php echo e(Auth::user()->dea_expiration_date); ?>

                            </span>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-500">Date Of Birth:</span>
                        <span class="text-sm font-medium text-slate-900"><?php echo e(Auth::user()->date_of_birth ?? 'N/A'); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-500">Contact Number:</span>
                        <span class="text-sm font-medium text-slate-900"><?php echo e(Auth::user()->phone ?? 'N/A'); ?></span>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <div class="flex justify-between">
                    <span class="text-sm text-slate-500">Member Since:</span>
                    <span
                        class="text-sm font-medium text-slate-900"><?php echo e(auth()->user()->created_at->format('M Y')); ?></span>
                </div>
            </div>

            <!-- Edit Profile Button -->
            <div class="mt-6">
                <a href="<?php echo e(route('profile.show')); ?>" wire:navigate
                    class="w-full bg-teal-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <?php echo e('Edit Profile'); ?>

                </a>
            </div>
        </div>
    </div>

    <!-- Right Content Area (Columns 2-3) -->
    <div class="lg:col-span-2 space-y-6 max-h-screen overflow-y-auto scrollable-content">

        <!-- Stats Overview -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Certificates -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-slate-900"><?php echo e(auth()->user()->certificates->count() ?? 0); ?>

                        </p>
                        <p class="text-sm text-slate-500">Certificates</p>
                    </div>
                </div>
            </div>

            <!-- Tasks -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-slate-900"><?php echo e(auth()->user()->tasks->count() ?? 0); ?></p>
                        <p class="text-sm text-slate-500">Tasks</p>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-slate-900"><?php echo e(auth()->user()->documents->count() ?? 0); ?></p>
                        <p class="text-sm text-slate-500">Documents</p>
                    </div>
                </div>
            </div>

            <!-- Addresses -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-2xl font-bold text-slate-900"><?php echo e(auth()->user()->addresses->count() ?? 0); ?></p>
                        <p class="text-sm text-slate-500">Addresses</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Transactions -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="p-6 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest Transactions</h3>
            </div>
            <div class="p-6">
                <?php if(auth()->user()->transactions && auth()->user()->transactions->count() > 0): ?>
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = auth()->user()->transactions->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div
                                class="flex items-center justify-between py-3 border-b border-slate-100 last:border-b-0">
                                <div class="flex items-center">
                                    <div class="p-2 bg-slate-100 rounded-lg mr-3">
                                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">
                                            <?php echo e($transaction->description ?? 'Transaction'); ?></p>
                                        <p class="text-xs text-slate-500">
                                            <?php echo e($transaction->created_at->format('M d, Y')); ?></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-slate-900">
                                        $<?php echo e(number_format($transaction->amount, 2)); ?></p>
                                    <p class="text-xs text-slate-500"><?php echo e(ucfirst($transaction->status)); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                        <p class="mt-2 text-sm text-slate-500">No transactions found</p>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Records Tables -->
        <div class="space-y-6">

            <!-- Certificates Table -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Certificates</h3>
                </div>
                <div class="overflow-x-auto">
                    <?php if(auth()->user()->certificates && auth()->user()->certificates->count() > 0): ?>
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Certificate</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Issue Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Expiry Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                <?php $__currentLoopData = auth()->user()->certificates->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                            <?php echo e($certificate->certificateType->name ?? 'Certificate'); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                            <?php echo e($certificate->issue_date ? $certificate->issue_date->format('M d, Y') : '-'); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                            <?php echo e($certificate->expiry_date ? $certificate->expiry_date->format('M d, Y') : '-'); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            <p class="mt-2 text-sm text-slate-500">No certificates found</p>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>

            <!-- Documents Table -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">Documents</h3>
                </div>
                <div class="overflow-x-auto">
                    <?php if(auth()->user()->documents && auth()->user()->documents->count() > 0): ?>
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Document</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Type</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Upload Date</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                <?php $__currentLoopData = auth()->user()->documents->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                            <?php echo e($document->name ?? 'Document'); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                            <?php echo e($document->documentType->name ?? 'Document'); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                            <?php echo e($document->created_at->format('M d, Y')); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Uploaded
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-2 text-sm text-slate-500">No documents found</p>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>

        </div>
    </div>
</div>
<?php /**PATH E:\payer-ready\resources\views/livewire/doctor/doctor-profile-component.blade.php ENDPATH**/ ?>