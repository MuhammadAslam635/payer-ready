<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Payer Enrollments</h1>
        <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','color' => 'teal','variant' => 'primary','icon' => 'plus','class' => '!px-5','wire:click' => 'openRequestModal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','color' => 'teal','variant' => 'primary','icon' => 'plus','class' => '!px-5','wire:click' => 'openRequestModal']); ?>
            Request New Payer
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

    <!-- Explanation Section -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Provider Credentials Management</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>This section manages your provider credentials with various payers and insurance companies. Here you can:</p>
                    <ul class="mt-2 list-disc list-inside space-y-1">
                        <li><strong>Request New Payer:</strong> Submit applications to new insurance companies or payers</li>
                        <li><strong>Track Status:</strong> Monitor the progress of your credentialing applications</li>
                        <li><strong>Manage Documents:</strong> Upload and manage required documentation for each payer</li>
                        <li><strong>View History:</strong> Access your complete credentialing history and submission dates</li>
                    </ul>
                    <p class="mt-2"><strong>Note:</strong> Credentialing typically takes 30-90 days depending on the payer requirements.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Section -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <button wire:click="setActiveTab('all')"
                class="py-2 px-1 border-b-2 font-medium text-sm <?php echo e($activeTab === 'all' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                All
                <span
                    class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2.5 rounded-full text-xs"><?php echo e($stats['all'] ?? 0); ?></span>
            </button>
            <button wire:click="setActiveTab('requested')"
                class="py-2 px-1 border-b-2 font-medium text-sm <?php echo e($activeTab === 'requested' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                Requested
                <span
                    class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2.5 rounded-full text-xs"><?php echo e($stats['requested'] ?? 0); ?></span>
            </button>
            <button wire:click="setActiveTab('working')"
                class="py-2 px-1 border-b-2 font-medium text-sm <?php echo e($activeTab === 'working' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                Working
                <span
                    class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2.5 rounded-full text-xs"><?php echo e($stats['working'] ?? 0); ?></span>
            </button>
            <button wire:click="setActiveTab('pending')"
                class="py-2 px-1 border-b-2 font-medium text-sm <?php echo e($activeTab === 'pending' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                Pending Payer
                <span
                    class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2.5 rounded-full text-xs"><?php echo e($stats['pending'] ?? 0); ?></span>
            </button>
            <button wire:click="setActiveTab('completed')"
                class="py-2 px-1 border-b-2 font-medium text-sm <?php echo e($activeTab === 'completed' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                Completed
                <span
                    class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2.5 rounded-full text-xs"><?php echo e($stats['completed'] ?? 0); ?></span>
            </button>
            <button wire:click="setActiveTab('return_for_correction')"
                class="py-2 px-1 border-b-2 font-medium text-sm <?php echo e($activeTab === 'return_for_correction' ? 'border-teal-500 text-teal-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?>">
                Return for Correction
                <span
                    class="ml-2 bg-gray-100 text-gray-900 py-0.5 px-2.5 rounded-full text-xs"><?php echo e($stats['return_for_correction'] ?? 0); ?></span>
            </button>
        </nav>
    </div>

    <!-- Table Section -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            PAYER
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            STATE
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            REQUEST TYPE
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            SUBMISSION DATE
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            PROVIDER
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            STATUS
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ACTIONS
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $statusValue = strtolower((string) $enrollment->status);
                            $isRequested = $statusValue === \App\Enums\CredentialStatus::REQUESTED->value;
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?php echo e($enrollment->payer->name); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($enrollment->state->name); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e(\App\Enums\CredentialRequest::from($enrollment->request_type)->label()); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($enrollment->submitted_at ? $enrollment->submitted_at->format('M d, Y') : 'N/A'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($enrollment->user->name); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $statusClass = match ($statusValue) {
                                        'completed' => 'bg-green-100 text-green-800',
                                        'working' => 'bg-yellow-100 text-yellow-800',
                                        'requested' => 'bg-blue-100 text-blue-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                ?>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($statusClass); ?>">
                                    <?php echo e(ucfirst($statusValue)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <!--[if BLOCK]><![endif]--><?php if($isRequested): ?>
                                    <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','variant' => 'ghost','size' => 'sm','squared' => true,'icon' => 'trash','class' => 'text-red-600 hover:text-red-900','wire:click' => 'delete('.e($enrollment->id).')','title' => 'Delete Payer Enrollment']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','variant' => 'ghost','size' => 'sm','squared' => true,'icon' => 'trash','class' => 'text-red-600 hover:text-red-900','wire:click' => 'delete('.e($enrollment->id).')','title' => 'Delete Payer Enrollment']); ?>
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
                                <?php else: ?>
                                    <span class="text-xs text-gray-400 italic">Not available</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-lg font-medium">Loading applications...</p>
                                    <p class="text-sm text-gray-400 mt-1">Your payer enrollment applications will appear
                                        here</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Request New Payer Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showRequestModal): ?>
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeRequestModal">
                </div>

                <!-- Modal panel -->
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <!-- Modal Header -->

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900" id="modal-title">
                                Request New Payer Enrollment
                            </h3>
                            <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','variant' => 'ghost','squared' => true,'size' => 'sm','icon' => 'x-mark','class' => 'text-gray-400 hover:text-gray-600','wire:click' => 'closeRequestModal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','variant' => 'ghost','squared' => true,'size' => 'sm','icon' => 'x-mark','class' => 'text-gray-400 hover:text-gray-600','wire:click' => 'closeRequestModal']); ?>
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
                        <form wire:submit="submitRequest">
                            <!-- Step 1: Select Provider -->
                            <div class="mb-6">
                                <div class="flex items-center mb-3">
                                    <div
                                        class="w-8 h-8 bg-teal-500 text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">
                                        1
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Provider</h4>
                                        <p class="text-xs text-gray-500">Your provider information (automatically selected)
                                        </p>
                                    </div>
                                </div>
                                <!-- Hidden input to ensure value is submitted -->
                                <input type="hidden" wire:model="selectedProvider" value="<?php echo e(Auth::id()); ?>">
                                <select
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                    disabled>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($provider->id); ?>" selected><?php echo e($provider->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                            </div>

                            <!-- Step 2: Select Payer -->
                            <div class="mb-6">
                                <div class="flex items-center mb-3">
                                    <div
                                        class="w-8 h-8 <?php echo e($selectedProvider ? 'bg-teal-500' : 'bg-gray-300'); ?> text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">
                                        2
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Select Payer</h4>
                                        <p class="text-xs text-gray-500">Choose a payer. Payers the provider is already
                                            enrolled with are hidden.</p>
                                    </div>
                                </div>
                                <select wire:model.live="selectedPayer"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                    <?php echo e(!$selectedProvider ? 'disabled' : ''); ?>>
                                    <option value="">Select a payer...</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $payers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($payer->id); ?>"><?php echo e($payer->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>

                            </div>

                            <!-- Step 3: Select State -->
                            <div class="mb-6">
                                <div class="flex items-center mb-3">
                                    <div
                                        class="w-8 h-8 <?php echo e($selectedPayer ? 'bg-teal-500' : 'bg-gray-300'); ?> text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">
                                        3
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Select State</h4>
                                        <p class="text-xs text-gray-500">Choose the state for this enrollment</p>
                                    </div>
                                </div>
                                <select wire:model.live="selectedState"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                    <?php echo e(!$selectedPayer ? 'disabled' : ''); ?>>
                                    <option value="">Select a state...</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($state->id); ?>"><?php echo e($state->name); ?>

                                            (<?php echo e($state->code); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                            </div>

                          
                            <!-- Step 5: Select Request Type -->
                            <div class="mb-6">
                                <div class="flex items-center mb-3">
                                    <div
                                        class="w-8 h-8 <?php echo e($selectedState ? 'bg-teal-500' : 'bg-gray-300'); ?> text-white rounded-full flex items-center justify-center text-sm font-medium mr-3">
                                        5
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">Select Request Type</h4>
                                        <p class="text-xs text-gray-500">Is this a new enrollment or re-credentialing?
                                        </p>
                                    </div>
                                </div>
                                <select wire:model.live="selectedRequestType"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                                    <?php echo e(!$selectedState ? 'disabled' : ''); ?>>
                                    <option value="">Select request type...</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = \App\Enums\CredentialRequest::values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requestType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($requestType); ?>"><?php echo e($requestType); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'submit','class' => 'w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto sm:text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:ml-3 sm:w-auto sm:text-sm']); ?>
                                    Submit Request
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
                                <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['wire:click' => 'closeRequestModal','type' => 'button','class' => 'mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'closeRequestModal','type' => 'button','class' => 'mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm']); ?>
                                    Cancel
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
                        </form>
                    </div>

                    <!-- Modal Footer -->


                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Delete Confirmation Modal -->
    <!--[if BLOCK]><![endif]--><?php if($showDeleteModal): ?>
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <?php if (isset($component)) { $__componentOriginal56804098dcf376a0e2227cb77b6cd00a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.icon.index','data' => ['name' => 'exclamation-triangle','class' => 'h-6 w-6 text-red-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'exclamation-triangle','class' => 'h-6 w-6 text-red-600']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $attributes = $__attributesOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__attributesOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a)): ?>
<?php $component = $__componentOriginal56804098dcf376a0e2227cb77b6cd00a; ?>
<?php unset($__componentOriginal56804098dcf376a0e2227cb77b6cd00a); ?>
<?php endif; ?>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Delete Payer Enrollment
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Are you sure you want to delete this payer enrollment? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','color' => 'red','variant' => 'primary','class' => 'w-full sm:w-auto sm:ml-3','wire:click' => 'confirmDelete']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','color' => 'red','variant' => 'primary','class' => 'w-full sm:w-auto sm:ml-3','wire:click' => 'confirmDelete']); ?>
                            Delete
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
                        <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button.index','data' => ['type' => 'button','variant' => 'outline','color' => 'slate','class' => 'mt-3 w-full sm:mt-0 sm:ml-3 sm:w-auto','wire:click' => 'cancelDelete']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','variant' => 'outline','color' => 'slate','class' => 'mt-3 w-full sm:mt-0 sm:ml-3 sm:w-auto','wire:click' => 'cancelDelete']); ?>
                            Cancel
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
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/livewire/doctor/application/payer-enrollment-component.blade.php ENDPATH**/ ?>