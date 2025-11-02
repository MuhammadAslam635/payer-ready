<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Doctor Tasks</h1>
                <p class="text-slate-600 mt-1">View and manage tasks for doctors in your organization</p>
            </div>
        </div>
    </div>

    <!-- Task Navigation Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="border-b border-slate-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <!-- All Tasks Tab -->
                <button wire:click="setActiveTab('all')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
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
                </button>

                <!-- To Do Tab -->
                <button wire:click="setActiveTab('todo')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
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
                </button>

                <!-- In Progress Tab -->
                <button wire:click="setActiveTab('in_progress')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
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
                </button>

                <!-- Completed Tab -->
                <button wire:click="setActiveTab('completed')" @class([
                    'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
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
                </button>
            </nav>
        </div>

        <!-- Search and Filters -->
        <div class="p-6 border-b border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex-1 max-w-lg">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-ui.icon name="magnifying-glass" class="h-5 w-5 text-slate-400" />
                        </div>
                        <input wire:model.live="search" type="text"
                            class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-md leading-5 bg-white placeholder-slate-500 focus:outline-none focus:placeholder-slate-400 focus:ring-1 focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                            placeholder="Search by task type, notes or doctor...">
                    </div>
                </div>
                <div>
                    <select wire:model.live="perPage" class="text-sm border-slate-300 rounded-md focus:ring-teal-500 focus:border-teal-500">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Task Content Area -->
        <div class="p-6">
            @if ($tasks->count() > 0)
                <!-- Tasks List -->
                <div class="space-y-4">
                    @foreach ($tasks as $task)
                        <div class="bg-slate-50 rounded-lg p-4 border border-slate-200 hover:border-slate-300 transition-colors duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <h3 class="text-lg font-medium text-slate-900">{{ $task->taskType->name ?? 'Task' }}</h3>
                                        <span class="ml-3 inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                            {{ $task->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($task->status === 'in_progress' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-800') }}">
                                            {{ ucfirst(str_replace('_',' ', $task->status)) }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-slate-600 mb-3">{{ $task->notes }}</p>

                                    <div class="flex items-center space-x-4 text-sm text-slate-500">
                                        <span class="flex items-center">
                                            <x-ui.icon name="user" class="w-4 h-4 mr-1 text-slate-400" />
                                            {{ $task->user->name ?? '—' }}
                                        </span>
                                        @if($task->due_date)
                                        <span class="flex items-center">
                                            <x-ui.icon name="calendar" class="w-4 h-4 mr-1 text-slate-400" />
                                            Due: {{ $task->due_date->format('M d, Y') }}
                                        </span>
                                        @endif
                                        <span class="flex items-center">
                                            <x-ui.icon name="user-circle" class="w-4 h-4 mr-1 text-slate-400" />
                                            Created by: {{ $task->createdBy->name ?? '—' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">{{ $tasks->links() }}</div>
            @else
                <div class="text-center py-12">
                    <x-ui.icon name="document-text" class="mx-auto h-12 w-12 text-slate-400" />
                    <h3 class="mt-2 text-sm font-medium text-slate-900">No tasks found</h3>
                    <p class="mt-1 text-sm text-slate-500">
                        @if($search)
                            No tasks match your search criteria.
                        @else
                            There are no tasks in this category yet.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>


