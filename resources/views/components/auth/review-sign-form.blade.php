@props([
    'userType', 'name', 'email', 'organizationName', 'primarySpecialty' => '', 'taxonomyCode' => '',
    'primaryState', 'specialties' => [], 'states' => [], 'dateOfBirth' => '', 'ssn' => '', 'homeAddress' => '',
    'practiceAddress' => '', 'phoneNumber' => '', 'npiNumber' => '', 'caqhId' => '',
    'caqhLogin' => '', 'caqhPassword' => '', 'pecosLogin' => '', 'pecosPassword' => '',
    'stateLicenses' => [], 'educations' => [], 'deaNumber' => '', 'deaExpiration' => '',
    'workHistory' => [], 'references' => [], 'insuranceCarrier' => '', 'policyNumber' => '',
    'coverageAmount' => '', 'policyEffectiveDate' => '', 'policyExpirationDate' => '',
    'licenseSuspended' => null, 'felonyConviction' => null, 'malpracticeClaims' => null
])

<!-- Step 7: Final Review & E-Sign -->
<div>
    <h2 class="text-2xl font-bold text-text-primary mb-6">
        Final Review
    </h2>
    <p class="text-text-secondary mb-8">
        Please review all information for accuracy before submitting. You can edit any section by clicking the 'Edit' button.
    </p>

    <!-- Core Profile Section -->
    <div class="bg-white border border-border rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-text-primary">Core Profile</h3>
            <button type="button"
                    wire:click="goToStep(1)"
                    class="text-primary-600 hover:text-primary-700 font-medium">
                Edit
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-text-primary">Full Name:</span>
                <span class="ml-2 text-text-secondary">{{ $name ?: 'Not provided' }}</span>
            </div>
            <div>
                <span class="font-medium text-text-primary">Email:</span>
                <span class="ml-2 text-text-secondary">{{ $email ?: 'Not provided' }}</span>
            </div>
            <div>
                <span class="font-medium text-text-primary">{{ $userType === 'doctor' ? 'Organization Name' : 'Clinic Name' }}:</span>
                <span class="ml-2 text-text-secondary">{{ $organizationName ?: 'Not provided' }}</span>
            </div>
            <div>
                <span class="font-medium text-text-primary">Primary Specialty:</span>
                <span class="ml-2 text-text-secondary">{{ $primarySpecialty ? $specialties->find($primarySpecialty)?->name : 'Not provided' }}</span>
            </div>
            <div>
                <span class="font-medium text-text-primary">Taxonomy Code:</span>
                <span class="ml-2 text-text-secondary">{{ $taxonomyCode ?: 'Not provided' }}</span>
            </div>
            <div>
                <span class="font-medium text-text-primary">Primary State:</span>
                <span class="ml-2 text-text-secondary">{{ $primaryState ? $states->where('code', $primaryState)->first()?->name : 'Not provided' }}</span>
            </div>
        </div>
    </div>

    <!-- Personal & Contact Section -->
    <div class="bg-white border border-border rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-text-primary">Personal & Contact</h3>
            <button type="button"
                    wire:click="goToStep(2)"
                    class="text-primary-600 hover:text-primary-700 font-medium">
                Edit
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-text-primary">Date of Birth:</span>
                <span class="ml-2 text-text-secondary">{{ $dateOfBirth ?: 'Not provided' }}</span>
            </div>
            <div>
                <span class="font-medium text-text-primary">SSN:</span>
                <span class="ml-2 text-text-secondary">{{ $ssn ? '***-**-****' : 'Not provided' }}</span>
            </div>
            <div class="lg:col-span-2">
                <span class="font-medium text-text-primary">Home Address:</span>
                <span class="ml-2 text-text-secondary">{{ $homeAddress ?: 'Not provided' }}</span>
            </div>
            <div class="lg:col-span-2">
                <span class="font-medium text-text-primary">Practice Address:</span>
                <span class="ml-2 text-text-secondary">{{ $practiceAddress ?: 'Not provided' }}</span>
            </div>
            <div>
                <span class="font-medium text-text-primary">Phone:</span>
                <span class="ml-2 text-text-secondary">{{ $phoneNumber ?: 'Not provided' }}</span>
            </div>
            <div>
                <span class="font-medium text-text-primary">NPI:</span>
                <span class="ml-2 text-text-secondary">{{ $npiNumber ?: 'Not provided' }}</span>
            </div>
            @if($caqhId)
                <div>
                    <span class="font-medium text-text-primary">CAQH ID:</span>
                    <span class="ml-2 text-text-secondary">{{ $caqhId }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Credentials Section -->
    <div class="bg-white border border-border rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-text-primary">Credentials</h3>
            <button type="button"
                    wire:click="goToStep(3)"
                    class="text-primary-600 hover:text-primary-700 font-medium">
                Edit
            </button>
        </div>

        @if(count($stateLicenses) > 0 && $stateLicenses[0]['state'])
            <div class="mb-4">
                <h4 class="font-medium text-text-primary mb-2">State Licenses:</h4>
                @foreach($stateLicenses as $license)
                    @if($license['state'])
                        <div class="text-sm text-text-secondary mb-1">
                            {{ $states->where('code', $license['state'])->first()?->name }} - {{ $license['license_number'] ?: 'No number provided' }}
                            @if($license['expiration_date'])
                                (Expires: {{ $license['expiration_date'] }})
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        @if(count($educations) > 0 && $educations[0]['institution'])
            <div class="mb-4">
                <h4 class="font-medium text-text-primary mb-2">Education:</h4>
                @foreach($educations as $education)
                    @if($education['institution'])
                        <div class="text-sm text-text-secondary mb-1">
                            {{ $education['degree'] }} - {{ $education['institution'] }}
                            @if($education['year_completed'])
                                ({{ $education['year_completed'] }})
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        @if($deaNumber)
            <div class="text-sm">
                <span class="font-medium text-text-primary">DEA Number:</span>
                <span class="ml-2 text-text-secondary">{{ $deaNumber }}</span>
                @if($deaExpiration)
                    <span class="text-text-secondary">(Expires: {{ $deaExpiration }})</span>
                @endif
            </div>
        @endif
    </div>

    <!-- Professional History Section -->
    <div class="bg-white border border-border rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-text-primary">Professional History</h3>
            <button type="button"
                    wire:click="goToStep(4)"
                    class="text-primary-600 hover:text-primary-700 font-medium">
                Edit
            </button>
        </div>

        @if(count($workHistory) > 0 && $workHistory[0]['practice_name'])
            <div class="mb-4">
                <h4 class="font-medium text-text-primary mb-2">Work History:</h4>
                @foreach($workHistory as $work)
                    @if($work['practice_name'])
                        <div class="text-sm text-text-secondary mb-2">
                            <strong>{{ $work['position'] }}</strong> at {{ $work['practice_name'] }}
                            @if($work['start_date'] || $work['end_date'])
                                <br><span class="text-xs">{{ $work['start_date'] }} - {{ $work['end_date'] ?: 'Present' }}</span>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        @endif

        @if(count($references) > 0 && $references[0]['full_name'])
            <div>
                <h4 class="font-medium text-text-primary mb-2">References:</h4>
                @foreach($references as $reference)
                    @if($reference['full_name'])
                        <div class="text-sm text-text-secondary mb-1">
                            {{ $reference['full_name'] }}{{ $reference['title'] ? ', ' . $reference['title'] : '' }}
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    <!-- Insurance & Attestation Section -->
    @if($insuranceCarrier || $policyNumber)
        <div class="bg-white border border-border rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-text-primary">Insurance & Attestation</h3>
                <button type="button"
                        wire:click="goToStep(5)"
                        class="text-primary-600 hover:text-primary-700 font-medium">
                    Edit
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 text-sm">
                @if($insuranceCarrier)
                    <div>
                        <span class="font-medium text-text-primary">Insurance Carrier:</span>
                        <span class="ml-2 text-text-secondary">{{ $insuranceCarrier }}</span>
                    </div>
                @endif
                @if($policyNumber)
                    <div>
                        <span class="font-medium text-text-primary">Policy Number:</span>
                        <span class="ml-2 text-text-secondary">{{ $policyNumber }}</span>
                    </div>
                @endif
                @if($coverageAmount)
                    <div>
                        <span class="font-medium text-text-primary">Coverage Amount:</span>
                        <span class="ml-2 text-text-secondary">{{ $coverageAmount }}</span>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- E-Signature Section -->
    <div class="bg-white border border-border rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-text-primary mb-4">E-Signature</h3>

        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <p class="text-sm text-text-secondary">
                By checking the box below, you attest that the information provided is accurate and complete to the best of your knowledge. You authorize PayerReady to use this information to perform credentialing services on your behalf.
            </p>
        </div>

        <!-- Terms Agreement -->
        <div class="mb-6">
            <label class="flex items-start">
                <input type="checkbox"
                       wire:model="agreeToTerms"
                       class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500 mt-1 @error('agreeToTerms') border-error-500 @enderror">
                <span class="ml-2 text-sm text-text-secondary">
                    I agree to the terms and electronically sign this document.
                </span>
            </label>
            @error('agreeToTerms')
                <p class="text-error-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Electronic Signature -->
        <div>
            <label for="eSignature" class="block text-sm font-medium text-text-primary mb-2">
                Type your full name to sign *
            </label>
            <input type="text"
                   id="eSignature"
                   wire:model="eSignature"
                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('eSignature') border-error-500 @enderror"
                   placeholder="Your Full Name">
            @error('eSignature')
                <p class="text-error-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Final Submission Note -->
    <div class="bg-success-50 border border-success-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-success-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-success-800">Ready to Submit</h3>
                <p class="text-sm text-success-700 mt-1">Once you submit your profile, our team will begin the credentialing process. You'll receive email updates throughout the process and can track progress in your dashboard.</p>
            </div>
        </div>
    </div>
</div>
