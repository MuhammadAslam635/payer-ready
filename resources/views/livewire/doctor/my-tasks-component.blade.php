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
                    <x-ui.button
                        type="button"
                        variant="ghost"
                        wire:click="setActiveTab('all')"
                        @class([
                            'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 rounded-none',
                            'border-teal-500 text-teal-600' => $activeTab === 'all',
                            'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' =>
                                $activeTab !== 'all',
                        ])>
                        All
                        <span @class([
                            'ml-2 py-0.5 px-2 rounded-full text-xs font-medium',
                            'bg-teal-100 text-teal-600' => $activeTab === 'all',
                            'bg-slate-100 text-slate-600' => $activeTab !== 'all',
                        ])>
                            {{ $taskCounts['all'] }}
                        </span>
                    </x-ui.button>

                    <!-- To Do Tab -->
                    <x-ui.button
                        type="button"
                        variant="ghost"
                        wire:click="setActiveTab('todo')"
                        @class([
                            'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 rounded-none',
                            'border-teal-500 text-teal-600' => $activeTab === 'todo',
                            'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' =>
                                $activeTab !== 'todo',
                        ])>
                        To Do
                        <span @class([
                            'ml-2 py-0.5 px-2 rounded-full text-xs font-medium',
                            'bg-teal-100 text-teal-600' => $activeTab === 'todo',
                            'bg-slate-100 text-slate-600' => $activeTab !== 'todo',
                        ])>
                            {{ $taskCounts['todo'] }}
                        </span>
                    </x-ui.button>

                    <!-- In Progress Tab -->
                    <x-ui.button
                        type="button"
                        variant="ghost"
                        wire:click="setActiveTab('in_progress')"
                        @class([
                            'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 rounded-none',
                            'border-teal-500 text-teal-600' => $activeTab === 'in_progress',
                            'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' =>
                                $activeTab !== 'in_progress',
                        ])>
                        In Progress
                        <span @class([
                            'ml-2 py-0.5 px-2 rounded-full text-xs font-medium',
                            'bg-teal-100 text-teal-600' => $activeTab === 'in_progress',
                            'bg-slate-100 text-slate-600' => $activeTab !== 'in_progress',
                        ])>
                            {{ $taskCounts['in_progress'] }}
                        </span>
                    </x-ui.button>

                    <!-- Completed Tab -->
                    <x-ui.button
                        type="button"
                        variant="ghost"
                        wire:click="setActiveTab('completed')"
                        @class([
                            'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 rounded-none',
                            'border-teal-500 text-teal-600' => $activeTab === 'completed',
                            'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' =>
                                $activeTab !== 'completed',
                        ])>
                        Completed
                        <span @class([
                            'ml-2 py-0.5 px-2 rounded-full text-xs font-medium',
                            'bg-teal-100 text-teal-600' => $activeTab === 'completed',
                            'bg-slate-100 text-slate-600' => $activeTab !== 'completed',
                        ])>
                            {{ $taskCounts['completed'] }}
                        </span>
                    </x-ui.button>
                </nav>
            </div>

            <!-- Task Content Area -->
            <div class="p-6">
                @if ($tasks->count() > 0)
                    <!-- Tasks List -->
                    <div class="space-y-4">
                        @foreach ($tasks as $task)
                            <div
                                class="bg-slate-50 rounded-lg p-4 border border-slate-200 hover:border-slate-300 transition-colors duration-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-slate-900 mb-2">{{ $task->taskType->name ?? 'Unknown Task' }}</h3>
                                        @if($task->taskType && $task->taskType->description)
                                            <p class="text-slate-600 mb-3">{{ $task->taskType->description }}</p>
                                        @endif
                                        @if($task->notes)
                                            <p class="text-slate-600 mb-3 text-sm italic">{{ $task->notes }}</p>
                                        @endif

                                        <div class="flex items-center space-x-4 text-sm text-slate-500">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}
                                            </span>

                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                                {{ ucfirst($task->priority ?? 'normal') }} Priority
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-2 ml-4">
                                        <span @class([
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                            'bg-yellow-100 text-yellow-800' => $task->status === 'pending',
                                            'bg-blue-100 text-blue-800' => $task->status === 'in_progress',
                                            'bg-green-100 text-green-800' => $task->status === 'completed',
                                        ])>
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>

                                        @if ($task->status === 'pending')
                                            <x-ui.button
                                                type="button"
                                                color="teal"
                                                variant="primary"
                                                size="sm"
                                                icon="play"
                                                class="uppercase tracking-wider"
                                                wire:click="updateTaskStatus({{ $task->id }}, 'in_progress')">
                                                Start
                                            </x-ui.button>
                                            <x-ui.button
                                                type="button"
                                                color="teal"
                                                variant="primary"
                                                size="sm"
                                                icon="check"
                                                class="uppercase tracking-wider"
                                                wire:click="updateTaskStatus({{ $task->id }}, 'completed')">
                                                Complete
                                            </x-ui.button>
                                        @elseif ($task->status === 'in_progress')
                                            <x-ui.button
                                                type="button"
                                                color="teal"
                                                variant="primary"
                                                size="sm"
                                                icon="check"
                                                class="uppercase tracking-wider"
                                                wire:click="updateTaskStatus({{ $task->id }}, 'completed')">
                                                Complete
                                            </x-ui.button>
                                            <x-ui.button
                                                type="button"
                                                color="teal"
                                                variant="primary"
                                                size="sm"
                                                icon="arrow-uturn-left"
                                                class="uppercase tracking-wider"
                                                wire:click="updateTaskStatus({{ $task->id }}, 'pending')">
                                                Back to Pending
                                            </x-ui.button>
                                        @elseif ($task->status === 'completed')
                                            <x-ui.button
                                                type="button"
                                                color="teal"
                                                variant="primary"
                                                size="sm"
                                                icon="arrow-uturn-left"
                                                class="uppercase tracking-wider"
                                                wire:click="updateTaskStatus({{ $task->id }}, 'in_progress')">
                                                Reopen
                                            </x-ui.button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
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
                @endif
            </div>
        </div>
    </div>
