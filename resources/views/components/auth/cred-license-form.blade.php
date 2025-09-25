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
                        <x-ui.label for="stateLicense_{{ $index }}_state">
                            State @if($index == 0)*@endif
                        </x-ui.label>
                        <x-ui.select id="stateLicense_{{ $index }}_state"
                                wire:model="stateLicenses.{{ $index }}.state"
                                placeholder="Select a state...">
                            <x-ui.select.option value="">Select a state...</x-ui.select.option>
                            @foreach($states as $state)
                                <x-ui.select.option value="{{ $state->code }}">{{ $state->name }}</x-ui.select.option>
                            @endforeach
                        </x-ui.select>
                        <x-ui.error name="stateLicenses.{{ $index }}.state" />
                    </div>

                    <!-- License Number -->
                    <div>
                        <x-ui.label for="stateLicense_{{ $index }}_number">
                            License Number @if($index == 0)*@endif
                        </x-ui.label>
                        <x-ui.input type="text"
                               id="stateLicense_{{ $index }}_number"
                               wire:model="stateLicenses.{{ $index }}.license_number" />
                        <x-ui.error name="stateLicenses.{{ $index }}.license_number" />
                    </div>

                    <!-- Issue Date -->
                    <div>
                        <x-ui.label for="stateLicense_{{ $index }}_issue">
                            Issue Date
                        </x-ui.label>
                        <x-ui.input type="date"
                               id="stateLicense_{{ $index }}_issue"
                               wire:model="stateLicenses.{{ $index }}.issue_date" />
                        <x-ui.error name="stateLicenses.{{ $index }}.issue_date" />
                    </div>

                    <!-- Expiration Date -->
                    <div>
                        <x-ui.label for="stateLicense_{{ $index }}_expiration">
                            Expiration Date
                        </x-ui.label>
                        <x-ui.input type="date"
                               id="stateLicense_{{ $index }}_expiration"
                               wire:model="stateLicenses.{{ $index }}.expiration_date" />
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
                        <x-ui.label for="education_{{ $index }}_institution">
                            Institution @if($index == 0)*@endif
                        </x-ui.label>
                        <x-ui.input type="text"
                               id="education_{{ $index }}_institution"
                               wire:model="educations.{{ $index }}.institution"
                               placeholder="e.g., Johns Hopkins University" />
                        <x-ui.error name="educations.{{ $index }}.institution" />
                    </div>

                    <!-- Degree -->
                    <div>
                        <x-ui.label for="education_{{ $index }}_degree">
                            Degree @if($index == 0)*@endif
                        </x-ui.label>
                        <x-ui.input type="text"
                               id="education_{{ $index }}_degree"
                               wire:model="educations.{{ $index }}.degree"
                               placeholder="MD, DO, NP" />
                        <x-ui.error name="educations.{{ $index }}.degree" />
                    </div>

                    <!-- Year Completed -->
                    <div>
                        <x-ui.label for="education_{{ $index }}_year">
                            Year Completed
                        </x-ui.label>
                        <x-ui.input type="number"
                               id="education_{{ $index }}_year"
                               wire:model="educations.{{ $index }}.year_completed"
                               placeholder="YYYY"
                               min="1950"
                               max="{{ date('Y') + 10 }}" />
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
            <x-ui.label for="deaNumber">
                DEA Registration Number (if applicable)
            </x-ui.label>
            <x-ui.input type="text"
                   id="deaNumber"
                   wire:model="deaNumber"
                   placeholder="AB1234567" />
            <x-ui.error name="deaNumber" />
        </div>

        <div>
            <x-ui.label for="deaExpiration">
                DEA Expiration Date
            </x-ui.label>
            <x-ui.input type="date"
                   id="deaExpiration"
                   wire:model="deaExpiration" />
            <x-ui.error name="deaExpiration" />
        </div>
    </div>
</div>
