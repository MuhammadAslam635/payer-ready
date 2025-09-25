<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeEditModal"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <form wire:submit.prevent="updateLicense">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">
                                Edit License
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- License Type -->
                                <div>
                                    <label for="edit_license_type" class="block text-sm font-medium text-gray-700">License Type</label>
                                    <select wire:model="editForm.license_type_id" 
                                            id="edit_license_type"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                        <option value="">Select License Type</option>
                                        @foreach ($licenseTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->code }})</option>
                                        @endforeach
                                    </select>
                                    @error('editForm.license_type_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- State -->
                                <div>
                                    <label for="edit_state" class="block text-sm font-medium text-gray-700">State</label>
                                    <select wire:model="editForm.state_id" 
                                            id="edit_state"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }} ({{ $state->code }})</option>
                                        @endforeach
                                    </select>
                                    @error('editForm.state_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- License Number -->
                                <div>
                                    <label for="edit_license_number" class="block text-sm font-medium text-gray-700">License Number</label>
                                    <input type="text" 
                                           wire:model="editForm.license_number" 
                                           id="edit_license_number" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    @error('editForm.license_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Issuing Authority -->
                                <div>
                                    <label for="edit_issuing_authority" class="block text-sm font-medium text-gray-700">Issuing Authority</label>
                                    <input type="text" 
                                           wire:model="editForm.issuing_authority" 
                                           id="edit_issuing_authority" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    @error('editForm.issuing_authority') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Issue Date -->
                                <div>
                                    <label for="edit_issue_date" class="block text-sm font-medium text-gray-700">Issue Date</label>
                                    <input type="date" 
                                           wire:model="editForm.issue_date" 
                                           id="edit_issue_date" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    @error('editForm.issue_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Expiration Date -->
                                <div>
                                    <label for="edit_expiration_date" class="block text-sm font-medium text-gray-700">Expiration Date</label>
                                    <input type="date" 
                                           wire:model="editForm.expiration_date" 
                                           id="edit_expiration_date" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                                    @error('editForm.expiration_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="mt-4">
                                <label for="edit_notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea wire:model="editForm.notes" 
                                          id="edit_notes" 
                                          rows="3" 
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"></textarea>
                                @error('editForm.notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Checkboxes -->
                            <div class="mt-4 space-y-3">
                                <div>
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox" 
                                               wire:model="editForm.is_verified" 
                                               id="edit_is_verified" 
                                               class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                        <span class="text-sm text-text-primary">
                                            Mark as Verified
                                        </span>
                                    </label>
                                </div>

                                <div>
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox" 
                                               wire:model="editForm.urgent" 
                                               id="edit_urgent" 
                                               class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                        <span class="text-sm text-text-primary">
                                            Mark as Urgent
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Update License
                    </button>
                    <button type="button" 
                            wire:click="closeEditModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>