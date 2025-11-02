<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Support Ticket</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Create a support ticket on behalf of one of your doctors</p>
            </div>
            <x-ui.button variant="primary" href="{{ route('organization-admin.all_support_tickets') }}" wire:navigate class="text-2xl font-bold text-gray-900 dark:text-white">
                <x-ui.icon name="arrow-left" class="w-4 h-4 mr-2" />
                Back to Tickets
            </x-ui.button>
        </div>
    </div>

    <!-- Create Ticket Form -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <form wire:submit.prevent="submit" class="p-6 space-y-6">
            <!-- Doctor Selection -->
            <div>
                <x-ui.label>Select Doctor (for whom ticket is created) <span class="text-red-500">*</span></x-ui.label>
                <x-ui.select wire:model="selectedDoctorId" placeholder="Choose a doctor...">
                    @foreach($doctors as $doctor)
                        <x-ui.select.option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->email }})</x-ui.select.option>
                    @endforeach
                </x-ui.select>
                <x-ui.error name="selectedDoctorId" />
            </div>

            <!-- Subject -->
            <div>
                <x-ui.label>Subject <span class="text-red-500">*</span></x-ui.label>
                <x-ui.input wire:model="subject" placeholder="Brief description of the issue" />
                <x-ui.error name="subject" />
            </div>

            <!-- Priority and Category Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Priority -->
                <div>
                    <x-ui.label>Priority <span class="text-red-500">*</span></x-ui.label>
                    <x-ui.select wire:model="priority">
                        <x-ui.select.option value="low">Low - General inquiry</x-ui.select.option>
                        <x-ui.select.option value="medium">Medium - Standard issue</x-ui.select.option>
                        <x-ui.select.option value="high">High - Urgent issue</x-ui.select.option>
                        <x-ui.select.option value="urgent">Urgent - Critical issue</x-ui.select.option>
                    </x-ui.select>
                    <x-ui.error name="priority" />
                </div>

                <!-- Category -->
                <div>
                    <x-ui.label>Category <span class="text-red-500">*</span></x-ui.label>
                    <x-ui.select wire:model="category">
                        <x-ui.select.option value="general">General Support</x-ui.select.option>
                        <x-ui.select.option value="technical">Technical Issue</x-ui.select.option>
                        <x-ui.select.option value="billing">Billing Question</x-ui.select.option>
                        <x-ui.select.option value="account">Account Management</x-ui.select.option>
                        <x-ui.select.option value="feature">Feature Request</x-ui.select.option>
                        <x-ui.select.option value="bug">Bug Report</x-ui.select.option>
                    </x-ui.select>
                    <x-ui.error name="category" />
                </div>
            </div>

            <!-- Description -->
            <div>
                <x-ui.label>Description <span class="text-red-500">*</span></x-ui.label>
                <x-ui.textarea wire:model="description" rows="6" placeholder="Please provide detailed information about the issue..." />
                <x-ui.error name="description" />
                <p class="mt-1 text-sm text-gray-500">Maximum 2000 characters</p>
            </div>

            <!-- File Attachments -->
            <div>
                <x-ui.label>Attachments (Optional)</x-ui.label>
                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6">
                    <div class="text-center">
                        <x-ui.icon name="document-plus" class="mx-auto h-12 w-12 text-gray-400" />
                        <div class="mt-4">
                            <label for="attachments" class="cursor-pointer">
                                <span class="mt-2 block text-sm font-medium text-gray-900 dark:text-white">
                                    Upload files
                                </span>
                                <span class="mt-1 block text-sm text-gray-500">
                                    PNG, JPG, PDF, DOC, DOCX, TXT up to 10MB each
                                </span>
                            </label>
                            <input id="attachments"
                                   type="file"
                                   wire:model="attachments"
                                   multiple
                                   accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt"
                                   class="sr-only">
                        </div>
                    </div>
                </div>

                <!-- Display uploaded files -->
                @if($attachments)
                    <div class="mt-4 space-y-2">
                        @foreach($attachments as $index => $attachment)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center">
                                    <x-ui.icon name="document" class="w-5 h-5 text-gray-400 mr-3" />
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $attachment->getClientOriginalName() }}</span>
                                    <span class="text-xs text-gray-500 ml-2">({{ number_format($attachment->getSize() / 1024, 1) }} KB)</span>
                                </div>
                                <x-ui.button variant="ghost" size="sm" wire:click="removeAttachment({{ $index }})">
                                    <x-ui.icon name="x-mark" class="w-4 h-4 text-red-600" />
                                </x-ui.button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <button type="button" wire:click="resetForm"
                        class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:w-auto sm:text-sm">
                    Reset
                </button>
                <button type="submit" wire:target="submit" wire:loading.attr="disabled"
                        class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 disabled:opacity-70 disabled:cursor-not-allowed sm:w-auto sm:text-sm">
                    <span wire:loading.remove wire:target="submit">Create Ticket</span>
                    <span wire:loading wire:target="submit" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Creating...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
