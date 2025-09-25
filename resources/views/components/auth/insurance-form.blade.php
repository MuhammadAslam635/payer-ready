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
                <x-ui.input
                    label="Insurance Carrier *"
                    name="insuranceCarrier"
                    wire:model="insuranceCarrier"
                    placeholder="e.g., The Doctors Company"
                    required />
            </div>

            <!-- Policy Number -->
            <div>
                <x-ui.input
                    label="Policy Number *"
                    name="policyNumber"
                    wire:model="policyNumber"
                    placeholder="Policy number"
                    required />
            </div>

            <!-- Coverage Amount -->
            <div>
                <x-ui.input
                    label="Coverage Amount (per occurrence/aggregate) *"
                    name="coverageAmount"
                    type="number"
                    wire:model="coverageAmount"
                    placeholder="1000000"
                    min="0"
                    step="1"/>
                <p class="text-xs text-gray-500 mt-1">Enter amount in dollars (e.g., 1000000 for $1,000,000)</p>
                <x-ui.error name="coverageAmount" />
            </div>

            <!-- Policy Effective Date -->
            <div>
                <x-ui.input
                    label="Policy Effective Date"
                    name="policyEffectiveDate"
                    type="date"
                    wire:model="policyEffectiveDate" />
            </div>

            <!-- Policy Expiration Date -->
            <div class="lg:col-span-1">
                <x-ui.input
                    label="Policy Expiration Date"
                    name="policyExpirationDate"
                    type="date"
                    wire:model="policyExpirationDate" />
            </div>
        </div>
    </div>

    <!-- Attestation Questions Section -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-text-primary mb-6">Attestation Questions</h3>

        <div class="space-y-6">
            <!-- License Suspension Question -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input 
                        type="checkbox" 
                        wire:model="licenseSuspended"
                        class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                    />
                    <span class="text-sm text-text-primary">
                        Has the provider's license ever been suspended, revoked, or restricted? *
                    </span>
                </label>
                <x-ui.error name="licenseSuspended" />
            </div>

            <!-- Felony Conviction Question -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input 
                        type="checkbox" 
                        wire:model="felonyConviction"
                        class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                    />
                    <span class="text-sm text-text-primary">
                        Has the provider ever been convicted of a felony? *
                    </span>
                </label>
                <x-ui.error name="felonyConviction" />
            </div>

            <!-- Malpractice Claims Question -->
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input 
                        type="checkbox" 
                        wire:model="malpracticeClaims"
                        class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
                    />
                    <span class="text-sm text-text-primary">
                        Has the provider ever had any malpractice claims or settlements? *
                    </span>
                </label>
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
