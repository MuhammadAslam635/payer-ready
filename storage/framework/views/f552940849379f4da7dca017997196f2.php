<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">All Providers</h1>
                <p class="text-slate-600 mt-1">Search and invite healthcare providers to your organization</p>
            </div>
            <button wire:click="inviteSelectedProviders"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Invite New Provider
            </button>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search"
                class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-md leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                placeholder="Search by name or NPI...">
        </div>
    </div>

    <!-- Providers Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        <!--[if BLOCK]><![endif]--><?php if($providers->count() > 0): ?>
            <!-- Table Headers -->
            <div class="bg-slate-50 border-b border-slate-200">
                <div class="px-6 py-3">
                    <div class="grid grid-cols-5 gap-4 text-xs font-medium text-slate-500 uppercase tracking-wider">
                        <div class="col-span-1"></div>
                        <div class="col-span-1">
                            <button wire:click="sortBy('name')"
                                class="flex items-center space-x-1 hover:text-slate-700">
                                <span>NAME</span>
                                <!--[if BLOCK]><![endif]--><?php if($sortField === 'name'): ?>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <!--[if BLOCK]><![endif]--><?php if($sortDirection === 'asc'): ?>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7" />
                                        <?php else: ?>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                    </svg>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </button>
                        </div>
                        <div class="col-span-1">
                            <button wire:click="sortBy('status')"
                                class="flex items-center space-x-1 hover:text-slate-700">
                                <span>STATUS</span>
                                <!--[if BLOCK]><![endif]--><?php if($sortField === 'status'): ?>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <!--[if BLOCK]><![endif]--><?php if($sortDirection === 'asc'): ?>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7" />
                                        <?php else: ?>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                    </svg>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </button>
                        </div>
                        <div class="col-span-1">SPECIALTY</div>
                        <div class="col-span-1">NPI</div>
                    </div>
                </div>
            </div>

            <!-- Table Body -->
            <div class="divide-y divide-slate-200">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="px-6 py-4 hover:bg-slate-50 transition-colors duration-200">
                        <div class="grid grid-cols-5 gap-4 items-center">
                            <!-- Checkbox -->
                            <div class="col-span-1">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" wire:click="toggleProviderSelection(<?php echo e($provider->id); ?>)"
                                        <?php if(in_array($provider->id, $selectedProviders)): ?> checked <?php endif; ?>
                                        class="mt-1 h-4 w-4 text-teal-600 focus:ring-teal-500 border-slate-300 rounded">
                                </label>
                            </div>

                            <!-- Name -->
                            <div class="col-span-1">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div
                                            class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center">
                                            <span class="text-sm font-medium text-slate-600">
                                                <?php echo e(substr($provider->user->name ?? 'N/A', 0, 2)); ?>

                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-slate-900">
                                            <?php echo e($provider->user->name ?? 'N/A'); ?>

                                        </div>
                                        <div class="text-sm text-slate-500">
                                            <?php echo e($provider->user->email ?? 'N/A'); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-span-1">
                                <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                    'bg-green-100 text-green-800' => $provider->status === 'active',
                                    'bg-yellow-100 text-yellow-800' => $provider->status === 'pending',
                                    'bg-red-100 text-red-800' => $provider->status === 'inactive',
                                    'bg-slate-100 text-slate-800' => !in_array($provider->status, [
                                        'active',
                                        'pending',
                                        'inactive',
                                    ]),
                                ]); ?>">
                                    <?php echo e(ucfirst($provider->status ?? 'Unknown')); ?>

                                </span>
                            </div>

                            <!-- Specialty -->
                            <div class="col-span-1">
                                <div class="text-sm text-slate-900">
                                    <?php echo e($provider->specialty->name ?? 'N/A'); ?>

                                </div>
                            </div>


                            <!-- NPI -->
                            <div class="col-span-1">
                                <div class="text-sm text-slate-900">
                                    <?php echo e($provider->npi_number ?? 'N/A'); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!-- Pagination -->
            <!--[if BLOCK]><![endif]--><?php if($providers->hasPages()): ?>
                <div class="bg-white px-4 py-3 border-t border-slate-200 sm:px-6">
                    <?php echo e($providers->links()); ?>

                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto h-24 w-24 bg-slate-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900 mb-2">No providers found</h3>
                <p class="text-slate-500 mb-6">Try adjusting your search criteria or invite new providers to get
                    started.</p>

                <button
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Invite New Provider
                </button>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

</div>
<?php /**PATH E:\payer-ready\resources\views/livewire/doctor/invite-providers-component.blade.php ENDPATH**/ ?>