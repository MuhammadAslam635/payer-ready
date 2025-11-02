<div class="space-y-6">
    <!-- Information Section -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-green-800">Task Status Management</h3>
                <div class="mt-2 text-sm text-green-700">
                    <p><strong>Status Changes:</strong> Task statuses can be changed from pending to complete and vice versa.</p>
                    <ul class="mt-2 list-disc list-inside space-y-1">
                        <li><strong>Quick Actions:</strong> Use the status buttons next to each task for immediate status changes</li>
                        <li><strong>Edit Modal:</strong> Click "Edit" to change all task details including status</li>
                        <li><strong>Available Statuses:</strong> Pending, In Progress, Completed, Cancelled</li>
                        <li><strong>Progress Tracking:</strong> Monitor task completion across different categories</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Doctor Tasks</h1>
                <p class="text-slate-600 mt-1">Manage tasks for doctors in your organization</p>
            </div>
            <!-- <div>
                <button wire:click="create"
                        class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Task
                </button>
            </div> -->
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="border-b border-slate-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                @php $tabs = [
                    'all' => 'All',
                    'todo' => 'To Do',
                    'in_progress' => 'In Progress',
                    'completed' => 'Completed',
                    'mine' => 'Created By Me',
                ]; @endphp
                @foreach($tabs as $key => $label)
                    <button wire:click="setActiveTab('{{ $key }}')" @class([
                        'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200',
                        'border-teal-500 text-teal-600' => $activeTab === $key,
                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' => $activeTab !== $key,
                    ])>
                        {{ $label }}
                        <span @class([
                            'ml-2 py-0.5 px-2 rounded-full text-xs font-medium',
                            'bg-teal-100 text-teal-600' => $activeTab === $key,
                            'bg-slate-100 text-slate-600' => $activeTab !== $key,
                        ])>
                            {{ $taskCounts[$key] ?? 0 }}
                        </span>
                    </button>
                @endforeach
            </nav>
        </div>

        <!-- List -->
        <div class="p-6 space-y-4">
            @forelse($this->tasks as $task)
                <div class="bg-slate-50 rounded-lg p-4 border border-slate-200 hover:border-slate-300 transition-colors duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1 text-sm text-slate-500">
                                <span>Doctor: <strong>{{ $task->user->name }}</strong></span>
                                <span>&middot;</span>
                                <span>Type: {{ $task->taskType->name ?? 'N/A' }}</span>
                                <span>&middot;</span>
                                <span>Created by: {{ $task->createdBy->is_org ? 'Organization Admin' : 'Itself' }}</span>
                            </div>
                            <p class="text-slate-700">{{ $task->notes }}</p>
                            <div class="flex items-center space-x-4 text-sm text-slate-500 mt-2">
                                <span>Due: {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}</span>
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

                            <!-- Quick Status Change Buttons -->
                            @if($task->status === 'pending')
                                <button wire:click="updateTaskStatus({{ $task->id }}, 'in_progress')" 
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100 transition-colors duration-200"
                                        title="Start Task">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h1m4 0h1m-6-8h1m4 0h1M9 2h6a2 2 0 012 2v16a2 2 0 01-2 2H9a2 2 0 01-2-2V4a2 2 0 012-2z"/>
                                    </svg>
                                    Start
                                </button>
                                <button wire:click="updateTaskStatus({{ $task->id }}, 'completed')" 
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-600 bg-green-50 border border-green-200 rounded hover:bg-green-100 transition-colors duration-200"
                                        title="Complete Task">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Complete
                                </button>
                            @elseif($task->status === 'in_progress')
                                <button wire:click="updateTaskStatus({{ $task->id }}, 'completed')" 
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-600 bg-green-50 border border-green-200 rounded hover:bg-green-100 transition-colors duration-200"
                                        title="Complete Task">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Complete
                                </button>
                                <button wire:click="updateTaskStatus({{ $task->id }}, 'pending')" 
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-600 bg-yellow-50 border border-yellow-200 rounded hover:bg-yellow-100 transition-colors duration-200"
                                        title="Back to Pending">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Back to Pending
                                </button>
                            @elseif($task->status === 'completed')
                                <button wire:click="updateTaskStatus({{ $task->id }}, 'in_progress')" 
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100 transition-colors duration-200"
                                        title="Reopen Task">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Reopen
                                </button>
                            @endif

                            <button wire:click="edit({{ $task->id }})" class="text-slate-400 hover:text-slate-600 transition-colors duration-200" title="Edit Task">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button wire:click="delete({{ $task->id }})" class="text-red-400 hover:text-red-600 transition-colors duration-200" title="Delete Task">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 bg-slate-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 mb-2">No tasks in this category</h3>
                    <p class="text-slate-500 mb-6">You're all caught up!</p>
                </div>
            @endforelse

            @if($this->tasks->hasPages())
                <div class="pt-4">{{ $this->tasks->links() }}</div>
            @endif
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="save">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Doctor</label>
                                    <select wire:model="form.user_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                        <option value="">Select doctor</option>
                                        @foreach($doctors as $doc)
                                            <option value="{{ $doc->id }}">{{ $doc->name }} ({{ $doc->email }})</option>
                                        @endforeach
                                    </select>
                                    @error('form.user_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Task Type</label>
                                    <select wire:model="form.task_type_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                        <option value="">Select task type</option>
                                        @foreach($taskTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.task_type_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <select wire:model="form.status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                            <option value="pending">Pending</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                        @error('form.status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Due Date</label>
                                        <input type="date" wire:model="form.due_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm" />
                                        @error('form.due_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea wire:model="form.notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm" placeholder="Describe the task..."></textarea>
                                    @error('form.notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" wire:target="save" wire:loading.attr="disabled"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-70 disabled:cursor-not-allowed sm:ml-3 sm:w-auto sm:text-sm">
                                <span wire:loading.remove wire:target="save">{{ $editing ? 'Update' : 'Create' }}</span>
                                <span wire:loading wire:target="save" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Processing...
                                </span>
                            </button>
                            <button type="button" wire:click="$set('showModal', false)"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>


