    <div class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">My Tasks</h1>
                    <p class="text-slate-600 mt-1">Manage your professional tasks and assignments</p>
                </div>
            </div>
        </div>

        <!-- Task Navigation Tabs -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="border-b border-slate-200">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <!-- All Tasks Tab -->
                    <button wire:click="setActiveTab('all')" class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                        'border-teal-500 text-teal-600' => $activeTab === 'all',
                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' =>
                            $activeTab !== 'all',
                    ]); ?>">
                        All
                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'ml-2 py-0.5 px-2 rounded-full text-xs font-medium',
                            'bg-teal-100 text-teal-600' => $activeTab === 'all',
                            'bg-slate-100 text-slate-600' => $activeTab !== 'all',
                        ]); ?>">
                            <?php echo e($taskCounts['all']); ?>

                        </span>
                    </button>

                    <!-- To Do Tab -->
                    <button wire:click="setActiveTab('todo')" class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                        'border-teal-500 text-teal-600' => $activeTab === 'todo',
                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' =>
                            $activeTab !== 'todo',
                    ]); ?>">
                        To Do
                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'ml-2 py-0.5 px-2 rounded-full text-xs font-medium',
                            'bg-teal-100 text-teal-600' => $activeTab === 'todo',
                            'bg-slate-100 text-slate-600' => $activeTab !== 'todo',
                        ]); ?>">
                            <?php echo e($taskCounts['todo']); ?>

                        </span>
                    </button>

                    <!-- In Progress Tab -->
                    <button wire:click="setActiveTab('in_progress')" class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                        'border-teal-500 text-teal-600' => $activeTab === 'in_progress',
                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' =>
                            $activeTab !== 'in_progress',
                    ]); ?>">
                        In Progress
                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'ml-2 py-0.5 px-2 rounded-full text-xs font-medium',
                            'bg-teal-100 text-teal-600' => $activeTab === 'in_progress',
                            'bg-slate-100 text-slate-600' => $activeTab !== 'in_progress',
                        ]); ?>">
                            <?php echo e($taskCounts['in_progress']); ?>

                        </span>
                    </button>

                    <!-- Completed Tab -->
                    <button wire:click="setActiveTab('completed')" class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                        'border-teal-500 text-teal-600' => $activeTab === 'completed',
                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' =>
                            $activeTab !== 'completed',
                    ]); ?>">
                        Completed
                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'ml-2 py-0.5 px-2 rounded-full text-xs font-medium',
                            'bg-teal-100 text-teal-600' => $activeTab === 'completed',
                            'bg-slate-100 text-slate-600' => $activeTab !== 'completed',
                        ]); ?>">
                            <?php echo e($taskCounts['completed']); ?>

                        </span>
                    </button>
                </nav>
            </div>

            <!-- Task Content Area -->
            <div class="p-6">
                <!--[if BLOCK]><![endif]--><?php if($tasks->count() > 0): ?>
                    <!-- Tasks List -->
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div
                                class="bg-slate-50 rounded-lg p-4 border border-slate-200 hover:border-slate-300 transition-colors duration-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-slate-900 mb-2"><?php echo e($task->title); ?></h3>
                                        <p class="text-slate-600 mb-3"><?php echo e($task->description); ?></p>

                                        <div class="flex items-center space-x-4 text-sm text-slate-500">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <?php echo e($task->due_date ? $task->due_date->format('M d, Y') : 'No due date'); ?>

                                            </span>

                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                                <?php echo e(ucfirst($task->priority ?? 'normal')); ?> Priority
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2 ml-4">
                                        <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                            'bg-yellow-100 text-yellow-800' => $task->status === 'pending',
                                            'bg-blue-100 text-blue-800' => $task->status === 'in_progress',
                                            'bg-green-100 text-green-800' => $task->status === 'completed',
                                        ]); ?>">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $task->status))); ?>

                                        </span>

                                        <!--[if BLOCK]><![endif]--><?php if($task->status !== 'completed'): ?>
                                            <button
                                                class="text-slate-400 hover:text-slate-600 transition-colors duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="mx-auto h-24 w-24 bg-slate-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900 mb-2">No tasks in this category</h3>
                        <p class="text-slate-500 mb-6">You're all caught up!</p>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
<?php /**PATH E:\payer-ready\resources\views/livewire/doctor/my-tasks-component.blade.php ENDPATH**/ ?>