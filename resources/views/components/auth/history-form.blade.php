<!-- Step 4: Professional History & References -->
<div>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-text-primary">
            Professional History & References
        </h2>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            Optional
        </span>
    </div>
    <p class="text-text-secondary mb-8">
        Provide your work history and peer references. You can skip this step and add it later.
    </p>

    <!-- Work History Section -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-text-primary mb-4">Work History</h3>

        @foreach($workHistory as $index => $work)
            <div class="bg-gray-50 rounded-lg p-6 mb-4 border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-medium text-text-primary">Position {{ $index + 1 }}</h4>
                    @if($index > 0)
                        <button type="button"
                                wire:click="removeWorkHistory({{ $index }})"
                                class="text-error-600 hover:text-error-700 text-sm">
                            Remove
                        </button>
                    @endif
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <!-- Practice/Hospital Name -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div>
                            <label for="work_{{ $index }}_practice_name" class="block text-sm font-medium text-text-primary mb-2">
                                Practice/Hospital Name @if($index == 0)*@endif
                            </label>
                            <input type="text"
                                   id="work_{{ $index }}_practice_name"
                                   wire:model="workHistory.{{ $index }}.practice_name"
                                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('workHistory.'.$index.'.practice_name') border-error-500 @enderror"
                                   placeholder="Practice or hospital name">
                            <x-ui.error name="workHistory.{{ $index }}.practice_name" />
                        </div>

                        <div>
                            <label for="work_{{ $index }}_position" class="block text-sm font-medium text-text-primary mb-2">
                                Position/Title @if($index == 0)*@endif
                            </label>
                            <input type="text"
                                   id="work_{{ $index }}_position"
                                   wire:model="workHistory.{{ $index }}.position"
                                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('workHistory.'.$index.'.position') border-error-500 @enderror"
                                   placeholder="e.g., Staff Physician, Partner">
                            <x-ui.error name="workHistory.{{ $index }}.position" />
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="work_{{ $index }}_address" class="block text-sm font-medium text-text-primary mb-2">
                            Address
                        </label>
                        <textarea id="work_{{ $index }}_address"
                                  wire:model="workHistory.{{ $index }}.address"
                                  rows="2"
                                  class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                  placeholder="Street address, City, State, ZIP"></textarea>
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div>
                            <label for="work_{{ $index }}_start_date" class="block text-sm font-medium text-text-primary mb-2">
                                Start Date
                            </label>
                            <input type="date"
                                   id="work_{{ $index }}_start_date"
                                   wire:model="workHistory.{{ $index }}.start_date"
                                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="work_{{ $index }}_end_date" class="block text-sm font-medium text-text-primary mb-2">
                                End Date
                            </label>
                            <input type="date"
                                   id="work_{{ $index }}_end_date"
                                   wire:model="workHistory.{{ $index }}.end_date"
                                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <button type="button"
                wire:click="addWorkHistory"
                class="flex items-center text-primary-600 hover:text-primary-700 font-medium mb-8">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Position
        </button>
    </div>

    <!-- Peer References Section -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-text-primary mb-4">Peer References</h3>

        @foreach($references as $index => $reference)
            <div class="bg-gray-50 rounded-lg p-6 mb-4 border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-medium text-text-primary">Reference {{ $index + 1 }}</h4>
                    @if($index > 1)
                        <button type="button"
                                wire:click="removeReference({{ $index }})"
                                class="text-error-600 hover:text-error-700 text-sm">
                            Remove
                        </button>
                    @endif
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <!-- Name and Title -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div>
                            <label for="ref_{{ $index }}_full_name" class="block text-sm font-medium text-text-primary mb-2">
                                Full Name @if($index < 2)*@endif
                            </label>
                            <input type="text"
                                   id="ref_{{ $index }}_full_name"
                                   wire:model="references.{{ $index }}.full_name"
                                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('references.'.$index.'.full_name') border-error-500 @enderror"
                                   placeholder="Dr. Jane Smith">
                            <x-ui.error name="references.{{ $index }}.full_name" />
                        </div>

                        <div>
                            <label for="ref_{{ $index }}_title" class="block text-sm font-medium text-text-primary mb-2">
                                Title @if($index < 2)*@endif
                            </label>
                            <input type="text"
                                   id="ref_{{ $index }}_title"
                                   wire:model="references.{{ $index }}.title"
                                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('references.'.$index.'.title') border-error-500 @enderror"
                                   placeholder="Chief of Medicine, Partner">
                            <x-ui.error name="references.{{ $index }}.title" />
                        </div>
                    </div>

                    <!-- Facility/Work Address -->
                    <div>
                        <label for="ref_{{ $index }}_facility_address" class="block text-sm font-medium text-text-primary mb-2">
                            Facility/Work Address
                        </label>
                        <textarea id="ref_{{ $index }}_facility_address"
                                  wire:model="references.{{ $index }}.facility_address"
                                  rows="2"
                                  class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                  placeholder="Hospital or practice address"></textarea>
                    </div>

                    <!-- Phone and Email -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div>
                            <label for="ref_{{ $index }}_phone" class="block text-sm font-medium text-text-primary mb-2">
                                Phone
                            </label>
                            <input type="tel"
                                   id="ref_{{ $index }}_phone"
                                   wire:model="references.{{ $index }}.phone"
                                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="(555) 123-4567">
                        </div>

                        <div>
                            <label for="ref_{{ $index }}_email" class="block text-sm font-medium text-text-primary mb-2">
                                Email
                            </label>
                            <input type="email"
                                   id="ref_{{ $index }}_email"
                                   wire:model="references.{{ $index }}.email"
                                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="reference@hospital.com">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <button type="button"
                wire:click="addReference"
                class="flex items-center text-primary-600 hover:text-primary-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Reference
        </button>
    </div>
</div>
