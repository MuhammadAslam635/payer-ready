<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
<div>
                <h1 class="text-2xl font-bold text-slate-900">Super Admin Dashboard</h1>
                <p class="text-slate-600 mt-1">Overview of system statistics and recent activity</p>
            </div>
            <div class="text-sm text-slate-500">
                Last updated: <?php echo e(now()->format('M d, Y \a\t g:i A')); ?>

            </div>
        </div>
    </div>

    <!-- Main Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Organizations -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Total Organizations</p>
                    <p class="text-2xl font-bold text-slate-900"><?php echo e(number_format($stats['totalOrganizations'])); ?></p>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-green-600 font-medium"><?php echo e($stats['activeOrganizations']); ?></span> active
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

        <!-- Total Clinics -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Total Clinics</p>
                    <p class="text-2xl font-bold text-slate-900"><?php echo e(number_format($stats['totalClinics'])); ?></p>
                    <p class="text-xs text-slate-500 mt-1">
                        <span class="text-green-600 font-medium"><?php echo e($stats['activeClinics']); ?></span> active
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Total Users</p>
                    <p class="text-2xl font-bold text-slate-900"><?php echo e(number_format($stats['totalUsers'])); ?></p>
                    <p class="text-xs text-slate-500 mt-1">All user types</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Activity Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Latest Transactions -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">Latest Transactions</h3>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
            </div>
            <div class="space-y-4">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $stats['latestTransactions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-slate-900"><?php echo e($transaction['description']); ?></p>
                                <p class="text-xs text-slate-500"><?php echo e($transaction['user_name']); ?> • <?php echo e($transaction['created_at']->diffForHumans()); ?></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-green-600">$<?php echo e(number_format($transaction['amount'], 2)); ?></p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <?php echo e(ucfirst($transaction['status'])); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                        <p class="mt-2 text-sm text-slate-500">No recent transactions</p>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Latest Registered Users -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">Latest Registered Users</h3>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
            </div>
            <div class="space-y-4">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $stats['latestUsers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="w-8 h-8 rounded-full object-cover bg-slate-200" src="<?php echo e($user['profile_photo_url']); ?>" alt="<?php echo e($user['name']); ?>">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-slate-900"><?php echo e($user['name']); ?></p>
                                <p class="text-xs text-slate-500"><?php echo e(ucfirst(str_replace('_', ' ', $user['user_type']))); ?> • <?php echo e($user['created_at']->diffForHumans()); ?></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?php echo e($user['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo e($user['is_active'] ? 'Active' : 'Inactive'); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                        <p class="mt-2 text-sm text-slate-500">No recent users</p>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>

    <!-- Certificate Requests -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-slate-900">Latest Certificate Requests</h3>
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Doctor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Certificate Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Requested</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $stats['latestCertificateRequests']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="w-8 h-8 rounded-full object-cover bg-slate-200" src="<?php echo e($request['doctor']['profile_photo_url']); ?>" alt="<?php echo e($request['doctor']['name']); ?>">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-slate-900"><?php echo e($request['doctor']['name']); ?></p>
                                        <p class="text-xs text-slate-500"><?php echo e($request['doctor']['email']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-slate-900"><?php echo e($request['certificate_type']); ?></p>
                                <p class="text-xs text-slate-500"><?php echo e($request['organization_name']); ?></p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?php echo e($request['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($request['status'] === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')); ?>">
                                    <?php echo e(ucfirst($request['status'])); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                <?php echo e($request['created_at']->diffForHumans()); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-900">View</button>
                                    <!--[if BLOCK]><![endif]--><?php if($request['status'] === 'pending'): ?>
                                        <button class="text-green-600 hover:text-green-900">Approve</button>
                                        <button class="text-red-600 hover:text-red-900">Reject</button>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="mt-2 text-sm text-slate-500">No certificate requests</p>
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php /**PATH E:\payer-ready\resources\views/livewire/dashboard/super-admin-dashboard-component.blade.php ENDPATH**/ ?>