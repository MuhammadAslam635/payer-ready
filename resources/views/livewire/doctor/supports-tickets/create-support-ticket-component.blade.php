<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-900">Create Support Ticket</h1>
                <p class="text-gray-600 dark:text-gray-600 mt-1">Submit a new support request to our team</p>
            </div>
            <x-ui.button
                as="a"
                href="{{ route('doctor.all_support_tickets') }}"
                wire:navigate
                variant="ghost"
                icon="arrow-left"
                class="!px-4">
                Back to Tickets
            </x-ui.button>
        </div>
    </div>


    <!-- Create Ticket Form -->
    <div class="bg-white dark:bg-white rounded-lg shadow-sm border border-gray-200 dark:border-gray-200">
        <form wire:submit.prevent="submit" class="p-6 space-y-6">
            <!-- Subject -->
            <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                    Subject <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="subject"
                       wire:model="subject"
                       placeholder="Brief description of your issue"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:text-gray-900 @error('subject') border-red-500 @enderror">
                @error('subject')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Priority and Category Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        Priority <span class="text-red-500">*</span>
                    </label>
                    <select id="priority"
                            wire:model="priority"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:text-gray-900 @error('priority') border-red-500 @enderror">
                        <option value="low">Low - General inquiry</option>
                        <option value="medium">Medium - Standard issue</option>
                        <option value="high">High - Urgent issue</option>
                        <option value="urgent">Urgent - Critical issue</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select id="category"
                            wire:model="category"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:text-gray-900 @error('category') border-red-500 @enderror">
                        <option value="general">General Support</option>
                        <option value="technical">Technical Issue</option>
                        <option value="billing">Billing & Payments</option>
                        <option value="account">Account Management</option>
                        <option value="payer_enrollment">Payer Enrollment</option>
                        <option value="credentialing">Credentialing</option>
                        <option value="feature_request">Feature Request</option>
                        <option value="bug_report">Bug Report</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea id="description"
                          wire:model="description"
                          rows="6"
                          placeholder="Please provide detailed information about your issue, including steps to reproduce if applicable..."
                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-white dark:text-gray-900 @error('description') border-red-500 @enderror"></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">{{ strlen($description) }}/2000 characters</p>
            </div>

            <!-- File Attachments -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                    Attachments (Optional)
                </label>
                <div class="border-2 border-dashed border-gray-300 dark:border-gray-200 rounded-lg p-6 text-center">
                    <input type="file"
                           wire:model="attachments"
                           multiple
                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt"
                           class="hidden"
                           id="file-upload">
                    <label for="file-upload" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="mt-2">
                            <span class="text-blue-600 hover:text-blue-500 font-medium">Click to upload files</span>
                            <span class="text-gray-500"> or drag and drop</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, PDF, DOC up to 10MB each</p>
                    </label>
                </div>

                <!-- Display selected files -->
                @if(!empty($attachments))
                    <div class="mt-4 space-y-2">
                        @foreach($attachments as $index => $attachment)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-100 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700 dark:text-gray-700">{{ $attachment->getClientOriginalName() }}</span>
                                    <span class="text-xs text-gray-500 ml-2">({{ number_format($attachment->getSize() / 1024, 1) }} KB)</span>
                                </div>
                                <x-ui.button
                                    type="button"
                                    variant="ghost"
                                    size="sm"
                                    squared
                                    icon="x-mark"
                                    class="text-red-600 hover:text-red-800"
                                    wire:click="removeAttachment({{ $index }})" />
                            </div>
                        @endforeach
                    </div>
                @endif

                @error('attachments.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-200 justify-end">
                <x-ui.button
                    type="submit"
                    color="teal"
                    variant="primary"
                    class="flex-1 sm:flex-none"
                    wire:loading.attr="disabled"
                    wire:target="submit">
                    <span wire:loading.remove wire:target="submit">Create Ticket</span>
                    <span wire:loading wire:target="submit">Creating...</span>
                </x-ui.button>

                <x-ui.button
                    type="button"
                    variant="outline"
                    color="slate"
                    class="flex-1 sm:flex-none"
                    wire:click="resetForm">
                    Reset Form
                </x-ui.button>
            </div>
        </form>
    </div>

    <!-- Help Section -->
    <div class="mt-6 bg-blue-50 dark:bg-blue-50 border border-blue-200 dark:border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-medium text-blue-900 dark:text-blue-900 mb-2">Need Help?</h3>
        <div class="text-sm text-blue-800 dark:text-blue-800 space-y-2">
            <p><strong>Before creating a ticket:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4">
                <li>Check if your issue is already resolved in our FAQ</li>
                <li>Provide as much detail as possible about your issue</li>
                <li>Include screenshots or error messages if applicable</li>
                <li>Mention the steps you've already tried to resolve the issue</li>
            </ul>
            <p class="mt-3"><strong>Response Times:</strong></p>
            <ul class="list-disc list-inside space-y-1 ml-4">
                <li>Urgent: Within 2 hours</li>
                <li>High: Within 4 hours</li>
                <li>Medium: Within 24 hours</li>
                <li>Low: Within 48 hours</li>
            </ul>
        </div>
    </div>
</div>
