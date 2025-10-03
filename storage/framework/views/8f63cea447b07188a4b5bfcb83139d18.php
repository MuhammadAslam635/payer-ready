<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
<div>
                <h1 class="text-2xl font-bold text-slate-900">Organization Manager Dashboard</h1>
                <p class="text-slate-600 mt-1">Manage your organization's staff and doctors</p>
                <!--[if BLOCK]><![endif]--><?php if($stats['organization']): ?>
                    <p class="text-sm text-slate-500 mt-1"><?php echo e($stats['organization']->business_name); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="text-sm text-slate-500">
                Last updated: <?php echo e(now()->format('M d, Y \a\t g:i A')); ?>

            </div>
        </div>
    </div>

    <!-- Main Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Staff -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Total Staff</p>
                    <p class="text-2xl font-bold text-slate-900"><?php echo e(number_format($stats['totalStaff'])); ?></p>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-green-600 font-medium"><?php echo e($stats['activeStaff']); ?></span> active
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Doctors -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Total Doctors</p>
                    <p class="text-2xl font-bold text-slate-900"><?php echo e(number_format($stats['totalDoctors'])); ?></p>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-green-600 font-medium"><?php echo e($stats['activeDoctors']); ?></span> active
                    </p>
                </div>
            </div>
        </div>

        <!-- Recent Staff -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Recent Staff</p>
                    <p class="text-2xl font-bold text-slate-900"><?php echo e(number_format($stats['recentStaff'])); ?></p>
                    <p class="text-xs text-slate-500 mt-1">Last 30 days</p>
                </div>
            </div>
        </div>

        <!-- Recent Doctors -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Recent Doctors</p>
                    <p class="text-2xl font-bold text-slate-900"><?php echo e(number_format($stats['recentDoctors'])); ?></p>
                    <p class="text-xs text-slate-500 mt-1">Last 30 days</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Latest Staff Members -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest Staff Members</h3>
            </div>
            <div class="p-6">
                <!--[if BLOCK]><![endif]--><?php if($stats['latestStaff']->count() > 0): ?>
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stats['latestStaff']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $staff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full" src="<?php echo e($staff['profile_photo_url']); ?>" alt="<?php echo e($staff['name']); ?>">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900 truncate"><?php echo e($staff['name']); ?></p>
                                    <p class="text-sm text-slate-500 truncate"><?php echo e($staff['role']); ?></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($staff['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php echo e($staff['is_active'] ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <p class="text-slate-500 text-center py-4">No staff members found</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Latest Doctors -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Latest Doctors</h3>
            </div>
            <div class="p-6">
                <!--[if BLOCK]><![endif]--><?php if($stats['latestDoctors']->count() > 0): ?>
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stats['latestDoctors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <img class="w-8 h-8 rounded-full" src="<?php echo e($doctor['profile_photo_url']); ?>" alt="<?php echo e($doctor['name']); ?>">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900 truncate"><?php echo e($doctor['name']); ?></p>
                                    <p class="text-sm text-slate-500 truncate"><?php echo e($doctor['specialty']); ?></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($doctor['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php echo e($doctor['is_active'] ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <p class="text-slate-500 text-center py-4">No doctors found</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>

    <!-- Latest Transactions -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Latest Transactions</h3>
        </div>
        <div class="p-6">
            <!--[if BLOCK]><![endif]--><?php if($stats['latestTransactions']->count() > 0): ?>
                <div class="space-y-4">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stats['latestTransactions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-900"><?php echo e($transaction['description']); ?></p>
                                <p class="text-sm text-slate-500"><?php echo e($transaction['staff_name']); ?></p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="text-sm font-medium text-slate-900">$<?php echo e(number_format($transaction['amount'], 2)); ?></span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($transaction['status'] === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                    <?php echo e(ucfirst($transaction['status'])); ?>

                                </span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php else: ?>
                <p class="text-slate-500 text-center py-4">No transactions found</p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>
<?php /**PATH E:\payer-ready\resources\views/livewire/dashboard/organization-manager-dashboard-component.blade.php ENDPATH**/ ?>