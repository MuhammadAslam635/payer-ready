<!-- Step 3: Professional Credentials & Licenses -->
<div>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-text-primary">
            Professional Credentials & Licenses
        </h2>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            Optional
        </span>
    </div>
    <p class="text-text-secondary mb-8">
        List your medical licenses and education history. You can skip this step and add it later.
    </p>

    <!-- State Licenses Section -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-text-primary mb-4">State Licenses</h3>

        @foreach($stateLicenses as $index => $license)
            <div class="bg-gray-50 rounded-lg p-6 mb-4 border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-medium text-text-primary">State License {{ $index + 1 }}</h4>
                    @if($index > 0)
                        <button type="button"
                                wire:click="removeStateLicense({{ $index }})"
                                class="text-error-600 hover:text-error-700 text-sm">
                            Remove
                        </button>
                    @endif
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <!-- State -->
                    <div>
                        <label for="stateLicense_{{ $index }}_state" class="block text-sm font-medium text-text-primary mb-2">
                            State @if($index == 0)*@endif
                        </label>
                        <select id="stateLicense_{{ $index }}_state"
                                wire:model="stateLicenses.{{ $index }}.state"
                                class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('stateLicenses.'.$index.'.state') border-error-500 @enderror">
                            <option value="">Select a state...</option>
                            @foreach($states as $state)
                                <option value="{{ $state->code }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                        <x-ui.error name="stateLicenses.{{ $index }}.state" />
                    </div>

                    <!-- License Number -->
                    <div>
                        <label for="stateLicense_{{ $index }}_number" class="block text-sm font-medium text-text-primary mb-2">
                            License Number @if($index == 0)*@endif
                        </label>
                        <input type="text"
                               id="stateLicense_{{ $index }}_number"
                               wire:model="stateLicenses.{{ $index }}.license_number"
                               class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('stateLicenses.'.$index.'.license_number') border-error-500 @enderror"
                               placeholder="License number">
                        <x-ui.error name="stateLicenses.{{ $index }}.license_number" />
                    </div>

                    <!-- Issue Date -->
                    <div>
                        <label for="stateLicense_{{ $index }}_issue" class="block text-sm font-medium text-text-primary mb-2">
                            Issue Date
                        </label>
                        <input type="date"
                               id="stateLicense_{{ $index }}_issue"
                               wire:model="stateLicenses.{{ $index }}.issue_date"
                               class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('stateLicenses.'.$index.'.issue_date') border-error-500 @enderror">
                        <x-ui.error name="stateLicenses.{{ $index }}.issue_date" />
                    </div>

                    <!-- Expiration Date -->
                    <div>
                        <label for="stateLicense_{{ $index }}_expiration" class="block text-sm font-medium text-text-primary mb-2">
                            Expiration Date
                        </label>
                        <input type="date"
                               id="stateLicense_{{ $index }}_expiration"
                               wire:model="stateLicenses.{{ $index }}.expiration_date"
                               class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('stateLicenses.'.$index.'.expiration_date') border-error-500 @enderror">
                        <x-ui.error name="stateLicenses.{{ $index }}.expiration_date" />
                    </div>
                </div>
            </div>
        @endforeach

        <button type="button"
                wire:click="addStateLicense"
                class="flex items-center text-primary-600 hover:text-primary-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Another State License
        </button>
    </div>

    <!-- Education & Training Section -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-text-primary mb-4">Education & Training</h3>

        @foreach($educations as $index => $education)
            <div class="bg-gray-50 rounded-lg p-6 mb-4 border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-medium text-text-primary">Institution {{ $index + 1 }}</h4>
                    @if($index > 0)
                        <button type="button"
                                wire:click="removeEducation({{ $index }})"
                                class="text-error-600 hover:text-error-700 text-sm">
                            Remove
                        </button>
                    @endif
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <!-- Institution -->
                    <div>
                        <label for="education_{{ $index }}_institution" class="block text-sm font-medium text-text-primary mb-2">
                            Institution @if($index == 0)*@endif
                        </label>
                        <input type="text"
                               id="education_{{ $index }}_institution"
                               wire:model="educations.{{ $index }}.institution"
                               class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('educations.'.$index.'.institution') border-error-500 @enderror"
                               placeholder="e.g., Johns Hopkins University">
                        <x-ui.error name="educations.{{ $index }}.institution" />
                    </div>

                    <!-- Degree -->
                    <div>
                        <label for="education_{{ $index }}_degree" class="block text-sm font-medium text-text-primary mb-2">
                            Degree @if($index == 0)*@endif
                        </label>
                        <input type="text"
                               id="education_{{ $index }}_degree"
                               wire:model="educations.{{ $index }}.degree"
                               class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('educations.'.$index.'.degree') border-error-500 @enderror"
                               placeholder="MD, DO, NP">
                        <x-ui.error name="educations.{{ $index }}.degree" />
                    </div>

                    <!-- Year Completed -->
                    <div>
                        <label for="education_{{ $index }}_year" class="block text-sm font-medium text-text-primary mb-2">
                            Year Completed
                        </label>
                        <input type="number"
                               id="education_{{ $index }}_year"
                               wire:model="educations.{{ $index }}.year_completed"
                               class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('educations.'.$index.'.year_completed') border-error-500 @enderror"
                               placeholder="YYYY"
                               min="1950"
                               max="{{ date('Y') + 10 }}">
                        <x-ui.error name="educations.{{ $index }}.year_completed" />
                    </div>
                </div>
            </div>
        @endforeach

        <button type="button"
                wire:click="addEducation"
                class="flex items-center text-primary-600 hover:text-primary-700 font-medium mb-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Education
        </button>
    </div>

    <!-- DEA Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div>
            <label for="deaNumber" class="block text-sm font-medium text-text-primary mb-2">
                DEA Registration Number (if applicable)
            </label>
            <input type="text"
                   id="deaNumber"
                   wire:model="deaNumber"
                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('deaNumber') border-error-500 @enderror"
                   placeholder="AB1234567">
            <x-ui.error name="deaNumber" />
        </div>

        <div>
            <label for="deaExpiration" class="block text-sm font-medium text-text-primary mb-2">
                DEA Expiration Date
            </label>
            <input type="date"
                   id="deaExpiration"
                   wire:model="deaExpiration"
                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('deaExpiration') border-error-500 @enderror">
            <x-ui.error name="deaExpiration" />
        </div>
    </div>
</div>
