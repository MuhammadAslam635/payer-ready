<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Doctor Expirables</h1>
                    <p class="mt-1 text-sm text-slate-600">Licenses and payer credentials expired for doctors you created.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">About</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Expires</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $this->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium <?php echo e($item['category'] === 'License' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'); ?>">
                                    <?php echo e($item['category']); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900"><?php echo e($item['about']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700"><?php echo e($item['number'] ?? '—'); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <!--[if BLOCK]><![endif]--><?php if($item['expires_at']): ?>
                                    <?php $days = now()->diffInDays($item['expires_at'], false); ?>
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                        <?php echo e($days <= 0 ? 'bg-red-100 text-red-800' : ($days <= 30 ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800')); ?>">
                                        <?php echo e($item['expires_at']->format('M d, Y')); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-slate-400">N/A</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">
                                No expirables found.
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/livewire/organization/doctor-expirables-component.blade.php ENDPATH**/ ?>