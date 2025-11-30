<div class="space-y-6">
    <!-- Organization Snapshot Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="space-y-4">
            <!-- Organization Name (Bold, Top) -->
            <!--[if BLOCK]><![endif]--><?php if(isset($stats['organization']) && $stats['organization'] && $stats['organization']->business_name): ?>
                <h1 class="text-2xl font-bold text-slate-900"><?php echo e($stats['organization']->business_name); ?></h1>
            <?php else: ?>
                <h1 class="text-2xl font-bold text-slate-900">Organization</h1>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            
            <!-- Dashboard Title (Not Bold) -->
            <p class="text-lg text-slate-700">Organization Manager Dashboard</p>
            
            <!-- Organization Details -->
            <div class="mt-6 pt-6 border-t border-slate-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Organization Name -->
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Organization Name</p>
                        <p class="text-base text-slate-900">
                            <?php echo e(isset($stats['organization']) && $stats['organization'] && $stats['organization']->business_name ? $stats['organization']->business_name : 'N/A'); ?>

                        </p>
                    </div>
                    
                    <!-- NPI -->
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">NPI</p>
                        <p class="text-base text-slate-900">
                            <?php echo e(isset($stats['organization']) && $stats['organization'] && $stats['organization']->npi_number ? $stats['organization']->npi_number : 'N/A'); ?>

                        </p>
                    </div>
                    
                    <!-- Tax ID -->
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Tax ID</p>
                        <p class="text-base text-slate-900">
                            <?php echo e(isset($stats['organization']) && $stats['organization'] && $stats['organization']->tax_id ? $stats['organization']->tax_id : 'N/A'); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <!-- Metrics Cards: Providers, Credentialing, Licensing, Enrollment -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Providers -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Providers</p>
                    <p class="text-2xl font-bold text-slate-900"><?php echo e(number_format($stats['metrics']['providers'] ?? 0)); ?></p>
                    <p class="text-xs text-slate-500 mt-1">Active providers</p>
                </div>
            </div>
        </div>

        <!-- Credentialing -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Credentialing</p>
                    <p class="text-2xl font-bold text-slate-900"><?php echo e(number_format($stats['metrics']['credentialing'] ?? 0)); ?></p>
                    <p class="text-xs text-slate-500 mt-1">Total credentials</p>
                </div>
            </div>
        </div>

        <!-- Licensing -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Licensing</p>
                    <p class="text-2xl font-bold text-slate-900"><?php echo e(number_format($stats['metrics']['licensing'] ?? 0)); ?></p>
                    <p class="text-xs text-slate-500 mt-1">Total licenses</p>
                </div>
            </div>
        </div>

        <!-- Enrollment -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <p class="text-sm font-medium text-slate-600">Enrollment</p>
                    <p class="text-2xl font-bold text-slate-900"><?php echo e(number_format($stats['metrics']['enrollment'] ?? 0)); ?></p>
                    <p class="text-xs text-slate-500 mt-1">Payer enrollments</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Compliance Score & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Compliance Score -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Compliance Score</h3>
            <div class="flex items-center justify-center">
                <div class="relative w-32 h-32">
                    <svg class="transform -rotate-90 w-32 h-32">
                        <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="8" fill="transparent" class="text-slate-200"/>
                        <?php
                            $score = $stats['complianceScore'] ?? 0;
                            $circumference = 2 * pi() * 56;
                            $offset = $circumference * (1 - $score / 100);
                            $colorClass = $score >= 80 ? 'text-green-600' : ($score >= 60 ? 'text-yellow-600' : 'text-red-600');
                        ?>
                        <circle cx="64" cy="64" r="56" stroke="currentColor" stroke-width="8" fill="transparent" 
                            stroke-dasharray="<?php echo e($circumference); ?>"
                            stroke-dashoffset="<?php echo e($offset); ?>"
                            class="<?php echo e($colorClass); ?> transition-all duration-300"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-3xl font-bold text-slate-900"><?php echo e($score); ?>%</span>
                    </div>
                </div>
            </div>
            <p class="text-sm text-slate-600 text-center mt-4">
                <?php if(($stats['complianceScore'] ?? 0) >= 80): ?>
                    Excellent compliance
                <?php elseif(($stats['complianceScore'] ?? 0) >= 60): ?>
                    Good compliance
                <?php else: ?>
                    Needs attention
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </p>
        </div>

        <!-- Quick Action Buttons -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <a href="<?php echo e(route('organization-admin.manage_staff')); ?>" class="flex flex-col items-center justify-center p-4 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                    <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-700">Add Provider</span>
                </a>
                <a href="<?php echo e(route('organization-admin.doctor_applications')); ?>" class="flex flex-col items-center justify-center p-4 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                    <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-700">New Enrollment</span>
                </a>
                <a href="<?php echo e(route('organization-admin.profile')); ?>" class="flex flex-col items-center justify-center p-4 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                    <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-700">View Licenses</span>
                </a>
                <a href="#" class="flex flex-col items-center justify-center p-4 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                    <svg class="w-8 h-8 text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-700">Reports</span>
                </a>
                <a href="<?php echo e(route('organization-admin.doctor_expirables')); ?>" class="flex flex-col items-center justify-center p-4 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                    <svg class="w-8 h-8 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-700">Expirables</span>
                </a>
                <a href="<?php echo e(route('organization-admin.profile')); ?>" class="flex flex-col items-center justify-center p-4 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                    <svg class="w-8 h-8 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-700">Settings</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Attention List & Activity Feed -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Attention List: Expiring / Missing Items -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Attention List</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    <?php echo e($stats['attentionList']->count()); ?> items
                </span>
            </div>
            <div class="p-6">
                <!--[if BLOCK]><![endif]--><?php if($stats['attentionList']->count() > 0): ?>
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stats['attentionList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-start space-x-3 p-3 rounded-lg <?php echo e($item['type'] === 'expiring' ? 'bg-yellow-50 border border-yellow-200' : 'bg-red-50 border border-red-200'); ?>">
                                <div class="flex-shrink-0">
                                    <!--[if BLOCK]><![endif]--><?php if($item['type'] === 'expiring'): ?>
                                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-900"><?php echo e($item['category']); ?>: <?php echo e($item['item']); ?></p>
                                    <p class="text-xs text-slate-600 mt-1"><?php echo e($item['doctor']); ?></p>
                                    <!--[if BLOCK]><![endif]--><?php if($item['type'] === 'expiring' && $item['expires_at']): ?>
                                        <p class="text-xs text-slate-500 mt-1">
                                            Expires in <?php echo e($item['days_until_expiry']); ?> days
                                            (<?php echo e($item['expires_at']->format('M d, Y')); ?>)
                                        </p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <p class="text-slate-500 text-center py-4">No items requiring attention</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Activity Feed: Latest Updates -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Activity Feed</h3>
            </div>
            <div class="p-6">
                <!--[if BLOCK]><![endif]--><?php if($stats['activityFeed']->count() > 0): ?>
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stats['activityFeed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <!--[if BLOCK]><![endif]--><?php if($activity['type'] === 'credential'): ?>
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                    <?php elseif($activity['type'] === 'license'): ?>
                                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                    <?php else: ?>
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-slate-900"><?php echo e($activity['description']); ?></p>
                                    <!--[if BLOCK]><![endif]--><?php if($activity['payer']): ?>
                                        <p class="text-xs text-slate-500 mt-1"><?php echo e($activity['payer']); ?></p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <p class="text-xs text-slate-400 mt-1"><?php echo e($activity['created_at']->diffForHumans()); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <p class="text-slate-500 text-center py-4">No recent activity</p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>

    <!-- Applications Snapshot Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Applications Snapshot</h3>
            <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Provider</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Payer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">State</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Submitted</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    <!--[if BLOCK]><![endif]--><?php if($stats['applicationsSnapshot']->count() > 0): ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stats['applicationsSnapshot']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900"><?php echo e($application['provider_name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?php echo e($application['payer_name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?php echo e($application['state_name']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500"><?php echo e($application['request_type']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($application['status'] === 'completed' ? 'bg-green-100 text-green-800' : ($application['status'] === 'working' ? 'bg-yellow-100 text-yellow-800' : ($application['status'] === 'requested' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'))); ?>">
                                        <?php echo e(ucfirst($application['status'])); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    <?php echo e($application['submitted_at'] ? $application['submitted_at']->format('M d, Y') : 'N/A'); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-slate-500">No applications found</td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/livewire/dashboard/organization-manager-dashboard-component.blade.php ENDPATH**/ ?>