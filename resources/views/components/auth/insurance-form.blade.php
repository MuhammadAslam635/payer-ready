<!-- Step 5: Insurance & Attestation -->
<div>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-text-primary">
            Insurance & Attestation
        </h2>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            Optional
        </span>
    </div>
    <p class="text-text-secondary mb-8">
        Provide your malpractice insurance details and answer disclosure questions. You can skip this step and add it later.
    </p>

    <!-- Malpractice Insurance Section -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-text-primary mb-6">Malpractice Insurance</h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Insurance Carrier -->
            <div>
                <label for="insuranceCarrier" class="block text-sm font-medium text-text-primary mb-2">
                    Insurance Carrier *
                </label>
                <input type="text"
                       id="insuranceCarrier"
                       wire:model="insuranceCarrier"
                       class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('insuranceCarrier') border-error-500 @enderror"
                       placeholder="e.g., The Doctors Company">
                <x-ui.error name="insuranceCarrier" />
            </div>

            <!-- Policy Number -->
            <div>
                <label for="policyNumber" class="block text-sm font-medium text-text-primary mb-2">
                    Policy Number *
                </label>
                <input type="text"
                       id="policyNumber"
                       wire:model="policyNumber"
                       class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('policyNumber') border-error-500 @enderror"
                       placeholder="Policy number">
                <x-ui.error name="policyNumber" />
            </div>

            <!-- Coverage Amount -->
            <div>
                <label for="coverageAmount" class="block text-sm font-medium text-text-primary mb-2">
                    Coverage Amount (per occurrence/aggregate) *
                </label>
                <input type="text"
                       id="coverageAmount"
                       wire:model="coverageAmount"
                       class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('coverageAmount') border-error-500 @enderror"
                       placeholder="$1,000,000 / $3,000,000">
                <x-ui.error name="coverageAmount" />
            </div>

            <!-- Policy Effective Date -->
            <div>
                <label for="policyEffectiveDate" class="block text-sm font-medium text-text-primary mb-2">
                    Policy Effective Date
                </label>
                <input type="date"
                       id="policyEffectiveDate"
                       wire:model="policyEffectiveDate"
                       class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>

            <!-- Policy Expiration Date -->
            <div class="lg:col-span-1">
                <label for="policyExpirationDate" class="block text-sm font-medium text-text-primary mb-2">
                    Policy Expiration Date
                </label>
                <input type="date"
                       id="policyExpirationDate"
                       wire:model="policyExpirationDate"
                       class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
        </div>
    </div>

    <!-- Attestation Questions Section -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-text-primary mb-6">Attestation Questions</h3>

        <div class="space-y-6">
            <!-- License Suspension Question -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-sm font-medium text-text-primary mb-4">
                    Has the provider's medical license ever been suspended, revoked, or restricted? *
                </label>
                <div class="flex items-center gap-6">
                    <label class="flex items-center">
                        <input type="radio"
                               wire:model="licenseSuspended"
                               value="1"
                               class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('licenseSuspended') border-error-500 @enderror">
                        <span class="ml-2 text-sm text-text-primary">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio"
                               wire:model="licenseSuspended"
                               value="0"
                               class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('licenseSuspended') border-error-500 @enderror">
                        <span class="ml-2 text-sm text-text-primary">No</span>
                    </label>
                </div>
                <x-ui.error name="licenseSuspended" />
            </div>

            <!-- Felony Conviction Question -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-sm font-medium text-text-primary mb-4">
                    Has the provider ever been convicted of a felony? *
                </label>
                <div class="flex items-center gap-6">
                    <label class="flex items-center">
                        <input type="radio"
                               wire:model="felonyConviction"
                               value="1"
                               class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('felonyConviction') border-error-500 @enderror">
                        <span class="ml-2 text-sm text-text-primary">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio"
                               wire:model="felonyConviction"
                               value="0"
                               class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('felonyConviction') border-error-500 @enderror">
                        <span class="ml-2 text-sm text-text-primary">No</span>
                    </label>
                </div>
                <x-ui.error name="felonyConviction" />
            </div>

            <!-- Malpractice Claims Question -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="block text-sm font-medium text-text-primary mb-4">
                    Have there been any malpractice claims filed against the provider in the last 5 years? *
                </label>
                <div class="flex items-center gap-6">
                    <label class="flex items-center">
                        <input type="radio"
                               wire:model="malpracticeClaims"
                               value="1"
                               class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('malpracticeClaims') border-error-500 @enderror">
                        <span class="ml-2 text-sm text-text-primary">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio"
                               wire:model="malpracticeClaims"
                               value="0"
                               class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('malpracticeClaims') border-error-500 @enderror">
                        <span class="ml-2 text-sm text-text-primary">No</span>
                    </label>
                </div>
                <x-ui.error name="malpracticeClaims" />
            </div>
        </div>

        <!-- Additional Information Note -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-yellow-800">Important Note</h3>
                    <p class="text-sm text-yellow-700 mt-1">If you answered "Yes" to any of the above questions, you will need to provide additional documentation and explanations during the credentialing process. This does not automatically disqualify the provider.</p>
                </div>
            </div>
        </div>
    </div>
</div>
