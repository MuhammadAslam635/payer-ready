<div class="w-full">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h4 class="text-xl font-semibold text-gray-900">Task Details: {{ $taskType->name }}</h4>
                <p class="text-gray-600 mt-1">{{ $taskType->description }}</p>
            </div>
            <a href="{{ route('super-admin.task-types.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-md transition-colors duration-200">
                <x-ui.icon name="arrow-left-circle" class="w-4 h-4 mr-2" /> Back to Tasks
            </a>
        </div>

        <div class="p-6">
            <!-- Task Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="text-lg font-medium text-gray-900 mb-3">Task Information</h6>
                    <div class="space-y-2">
                        <p class="text-sm"><span class="font-medium text-gray-700">Name:</span> <span class="text-gray-900">{{ $taskType->name }}</span></p>
                        <p class="text-sm"><span class="font-medium text-gray-700">Description:</span> <span class="text-gray-900">{{ $taskType->description }}</span></p>
                        <p class="text-sm"><span class="font-medium text-gray-700">Created:</span> <span class="text-gray-900">{{ $taskType->created_at->format('M d, Y') }}</span></p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <h6 class="text-lg font-medium text-gray-900 mb-3">Assignment Statistics</h6>
                    <div class="space-y-2">
                        <p class="text-sm"><span class="font-medium text-gray-700">Total Assignments:</span> <span class="text-gray-900">{{ $assignments->total() }}</span></p>
                        <p class="text-sm"><span class="font-medium text-gray-700">Pending:</span> <span class="text-yellow-600">{{ $assignments->where('status', 'pending')->count() }}</span></p>
                        <p class="text-sm"><span class="font-medium text-gray-700">In Progress:</span> <span class="text-blue-600">{{ $assignments->where('status', 'in_progress')->count() }}</span></p>
                        <p class="text-sm"><span class="font-medium text-gray-700">Completed:</span> <span class="text-green-600">{{ $assignments->where('status', 'completed')->count() }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="md:col-span-2">
                    <div class="relative">
                        <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="Search by user name or email..." 
                               wire:model.live.debounce.300ms="search">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" wire:model.live="perPage">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                    </select>
                </div>
            </div>

            <!-- Assignments Table -->
            <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th wire:click="sortBy('id')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                ID
                                @if($sortField === 'id')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('user_id')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                Assigned To
                                @if($sortField === 'user_id')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User Type</th>
                            <th wire:click="sortBy('status')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                Status
                                @if($sortField === 'status')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th wire:click="sortBy('due_date')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                Due Date
                                @if($sortField === 'due_date')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            <th wire:click="sortBy('created_at')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                Assigned On
                                @if($sortField === 'created_at')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($assignments as $assignment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $assignment->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $assignment->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $assignment->user->email }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', $assignment->user->user_type->value)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($assignment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($assignment->status === 'in_progress') bg-blue-100 text-blue-800
                                        @elseif($assignment->status === 'completed') bg-green-100 text-green-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $assignment->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($assignment->due_date)
                                        <div>{{ $assignment->due_date->format('M d, Y') }}</div>
                                        @if($assignment->due_date->isPast() && $assignment->status !== 'completed')
                                            <div class="text-xs text-red-600">Overdue</div>
                                        @endif
                                    @else
                                        <span class="text-gray-500">No due date</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    @if($assignment->notes)
                                        <span title="{{ $assignment->notes }}" class="truncate block max-w-xs">
                                            {{ Str::limit($assignment->notes, 50) }}
                                        </span>
                                    @else
                                        <span class="text-gray-500">No notes</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $assignment->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <x-ui.button  icon="pencil" size="sm" variant="primary" color="teal" 
                                                wire:click="editAssignment({{ $assignment->id }})"
                                                title="Edit Assignment">
                                            
                                        </x-ui.button>
                                        <x-ui.button icon="trash" size="sm" variant="primary" coor="teal" 
                                                wire:click="deleteAssignment({{ $assignment->id }})"
                                                title="Delete Assignment">
                                        </x-ui.button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-4"></i>
                                        <p class="text-lg">No assignments found for this task.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($assignments->hasPages())
                <div class="flex justify-center mt-6">
                    {{ $assignments->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Assignment Modal -->
    @if($showEditModal && $editingAssignment)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                
                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900" id="modal-title">Edit Assignment</h3>
                            <button type="button" class="text-gray-400 hover:text-gray-600" wire:click="closeEditModal">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <form wire:submit.prevent="updateAssignment">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="editProvider" class="block text-sm font-medium text-gray-700 mb-1">Assign To</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('editProvider') border-red-500 @enderror" 
                                            wire:model="editProvider" id="editProvider">
                                        <option value="">Select Provider</option>
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id }}">
                                                {{ $provider->name }} ({{ ucfirst(str_replace('_', ' ', $provider->user_type->value)) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('editProvider')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="editStatus" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('editStatus') border-red-500 @enderror" 
                                            wire:model="editStatus" id="editStatus">
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                    @error('editStatus')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="editDueDate" class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
                                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('editDueDate') border-red-500 @enderror" 
                                       wire:model="editDueDate" id="editDueDate">
                                @error('editDueDate')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="editNotes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('editNotes') border-red-500 @enderror" 
                                          wire:model="editNotes" id="editNotes" rows="3" 
                                          placeholder="Additional notes or instructions..."></textarea>
                                @error('editNotes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </form>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" wire:click="updateAssignment">
                            <span wire:loading.remove wire:target="updateAssignment">Update Assignment</span>
                            <span wire:loading wire:target="updateAssignment" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Updating...
                            </span>
                        </button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" wire:click="closeEditModal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

