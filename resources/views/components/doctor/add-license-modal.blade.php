<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeAddModal"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form wire:submit.prevent="saveLicense">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Add New License {{ $selectedProvider }}
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <x-ui.label>Provider</x-ui.label>
                                    <x-ui.input type="text" value="{{ $selectedProvider }}" readonly />
                                    <x-ui.error name="selectedProvider" />

                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                                    <div>
                                        <x-ui.label>License Type</x-ui.label>
                                        <x-ui.select wire:model="addForm.license_type_id" searchable
                                            class="mt-1 block w-full ">
                                            <x-ui.select.option value="">Select License Type</x-ui.select.option>
                                            @foreach ($licenseTypes as $type)
                                                <x-ui.select.option value="{{ $type->id }}">{{ $type->name }}
                                                    ({{ $type->code }})
                                                </x-ui.select.option>
                                            @endforeach
                                        </x-ui.select>
                                        <x-ui.error name="addForm.license_type_id" />
                                    </div>
                                     <div>
                                        <x-ui.label>State</x-ui.label>
                                        <x-ui.select wire:model="addForm.state_id" searchable
                                            class="mt-1 block w-full ">
                                            <x-ui.select.option value="">Select State</x-ui.select.option>
                                            @foreach ($states as $state)
                                                <x-ui.select.option value="{{ $state->id }}">{{ $state->name }}
                                                </x-ui.select.option>
                                            @endforeach
                                        </x-ui.select>
                                        <x-ui.error name="addForm.state_id" />
                                    </div>
                                    
                                </div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                                    <div>
                                        <x-ui.label>License Number</x-ui.label>
                                        <x-ui.input type="text" wire:model="addForm.license_number"
                                            placeholder="Enter license number" />
                                        <x-ui.error name="addForm.license_number" />
                                    </div>
                                     <div>
                                    <x-ui.label>Issuing Authority</x-ui.label>
                                    <x-ui.input type="text" wire:model="addForm.issuing_authority"
                                        placeholder="Enter issuing authority" />
                                    <x-ui.error name="addForm.issuing_authority" />
                                </div>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                                    <div>
                                        <x-ui.label>Issue Date</x-ui.label>
                                        <x-ui.input type="date" wire:model="addForm.issue_date"
                                            placeholder="Select issue date" />
                                        <x-ui.error name="addForm.issue_date" />
                                    </div>

                                    <div>
                                        <x-ui.label>Expiration Date</x-ui.label>
                                        <x-ui.input type="date" wire:model="addForm.expiration_date"
                                            placeholder="Select expiration date" />
                                        <x-ui.error name="addForm.expiration_date" />
                                    </div>
                                </div>

                                    <div>
                                        <x-ui.label>Notes</x-ui.label>
                                        <x-ui.textarea wire:model="addForm.notes"
                                            placeholder="Additional notes (optional)" />
                                        <x-ui.error name="addForm.notes" />
                                    </div>

                                <div class="mt-4">
                                    <label class="flex items-start gap-3 cursor-pointer">
                                        <input type="checkbox" wire:model="addForm.is_verified"
                                            class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" />
                                        <span class="text-sm text-text-primary">
                                            Is License Verified?
                                        </span>
                                    </label>
                                    <x-ui.error name="addForm.is_verified" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <x-ui.button type="submit" class="bg-teal-500 text-white text-xs hover:bg-teal-700 rounded-md" wire:loading.attr="disabled">
                        Add License
                    </x-ui.button>
                    <x-ui.button type="button" class="bg-red-500 text-white text-xs hover:bg-red-700 rounded-md" wire:click="closeAddModal">
                        Cancel
                    </x-ui.button>
                </div>
            </form>
        </div>
    </div>
</div>
