<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex gap-8">
            <!-- Smart Checklist Sidebar -->
            <div class="w-80 bg-white rounded-xl shadow-sm border border-border p-6 h-fit">
                <h3 class="text-lg font-bold text-text-primary mb-6">Your Smart Checklist</h3>
                <div class="space-y-3">
                    <!-- Step 1: Welcome & Core Profile -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer {{ $currentStep >= 1 ? 'bg-success-50' : 'bg-gray-50' }}"
                         wire:click="goToStep(1)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $currentStep > 1 ? 'bg-success-500 text-white' : ($currentStep == 1 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500') }}">
                            @if($currentStep > 1)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                1
                            @endif
                        </div>
                        <span class="font-medium text-text-primary">Welcome & Core Profile</span>
                    </div>

                    {{-- <!-- Step 2: Personal & Contact -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer {{ $currentStep >= 2 ? 'bg-success-50' : 'bg-gray-50' }}"
                         wire:click="goToStep(2)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $currentStep > 2 ? 'bg-success-500 text-white' : ($currentStep == 2 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500') }}">
                            @if($currentStep > 2)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                2
                            @endif
                        </div>
                        <span class="font-medium text-text-primary">Personal & Contact</span>
                    </div>

                    <!-- Step 3: Credentials & Licenses -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer {{ $currentStep >= 3 ? 'bg-success-50' : 'bg-gray-50' }}"
                         wire:click="goToStep(3)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $currentStep > 3 ? 'bg-success-500 text-white' : ($currentStep == 3 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500') }}">
                            @if($currentStep > 3)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                3
                            @endif
                        </div>
                        <span class="font-medium text-text-primary">Credentials & Licenses</span>
                    </div>

                    <!-- Step 4: Professional History -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer {{ $currentStep >= 4 ? 'bg-success-50' : 'bg-gray-50' }}"
                         wire:click="goToStep(4)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $currentStep > 4 ? 'bg-success-500 text-white' : ($currentStep == 4 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500') }}">
                            @if($currentStep > 4)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                4
                            @endif
                        </div>
                        <span class="font-medium text-text-primary">Professional History</span>
                    </div>

                    <!-- Step 5: Insurance & Attestation -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer {{ $currentStep >= 5 ? 'bg-success-50' : 'bg-gray-50' }}"
                         wire:click="goToStep(5)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $currentStep > 5 ? 'bg-success-500 text-white' : ($currentStep == 5 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500') }}">
                            @if($currentStep > 5)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                5
                            @endif
                        </div>
                        <span class="font-medium text-text-primary">Insurance & Attestation</span>
                    </div>

                    <!-- Step 6: Document Upload -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer {{ $currentStep >= 6 ? 'bg-success-50' : 'bg-gray-50' }}"
                         wire:click="goToStep(6)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $currentStep > 6 ? 'bg-success-500 text-white' : ($currentStep == 6 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500') }}">
                            @if($currentStep > 6)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                6
                            @endif
                        </div>
                        <span class="font-medium text-text-primary">Document Upload</span>
                    </div>

                    <!-- Step 7: Review & E-Sign -->
                    <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer {{ $currentStep >= 7 ? 'bg-success-50' : 'bg-gray-50' }}"
                         wire:click="goToStep(7)">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $currentStep > 7 ? 'bg-success-500 text-white' : ($currentStep == 7 ? 'bg-primary-500 text-white' : 'bg-gray-300 text-gray-500') }}">
                            @if($currentStep > 7)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                7
                            @endif
                        </div>
                        <span class="font-medium text-text-primary">Review & E-Sign</span>
                    </div> --}}
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow-sm border border-border p-8">
                    <!-- Optional Information Banner -->
                    @if($currentStep != 7)
                        <div class="bg-primary-50 border border-primary-200 rounded-lg p-4 mb-6">
                            <div class="flex">
                                <svg class="w-5 h-5 text-primary-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h3 class="text-sm font-medium text-primary-800">Optional Information</h3>
                                    <p class="text-sm text-primary-700 mt-1">Don't have the details handy? No problem. You can skip these for now and add them later from your dashboard.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Step Content -->
                    <div class="min-h-96">
                        @if($currentStep == 1)
                            <x-auth.organization-sign-up-form :userType="$userType" :specialties="$specialties" :states="$states" :errors="$errors" />
                        @endif
                        {{-- @elseif($currentStep == 2)
                            <x-auth.personal-form :userType="$userType" />
                        @elseif($currentStep == 3)
                            <x-auth.cred-license-form :userType="$userType" :stateLicenses="$stateLicenses" :states="$states" :educations="$educations" />
                        @elseif($currentStep == 4)
                            <x-auth.history-form :userType="$userType" :workHistory="$workHistory" :references="$references" />
                        @elseif($currentStep == 5)
                            <x-auth.insurance-form :userType="$userType" />
                        @elseif($currentStep == 6)
                            <x-auth.document-from
                                :userType="$userType"
                                :cv="$cv"
                                :professionalLicense="$professionalLicense"
                                :pictureId="$pictureId"
                                :socialSecurityCard="$socialSecurityCard"
                                :certificateOfLiabilityInsurance="$certificateOfLiabilityInsurance"
                                :copiesOfDiplomasCertifications="$copiesOfDiplomasCertifications"
                                :stateCredentialingApplication="$stateCredentialingApplication"
                                :passportStylePhoto="$passportStylePhoto"
                                :ecfmgCertificate="$ecfmgCertificate"
                                :boardCertificate="$boardCertificate"
                                :procedureLog="$procedureLog"
                                :cmeCs="$cmeCs"
                                :immunizationShotRecords="$immunizationShotRecords"
                                :aclsBlsCertificate="$aclsBlsCertificate"
                            />
                        @elseif($currentStep == 7)
                            <x-auth.review-sign-form :userType="$userType" :name="$name" :email="$email"
                             :organizationName="$organizationName" :primarySpecialty="$primarySpecialty"
                             :primaryState="$primaryState" :specialties="$specialties"
                              :dateOfBirth="$dateOfBirth" :ssn="$ssn" :homeAddress="$homeAddress"
                              :practiceAddress="$practiceAddress" :phoneNumber="$phoneNumber"
                              :npiNumber="$npiNumber" :caqhId="$caqhId" :caqhLogin="$caqhLogin"
                              :caqhPassword="$caqhPassword" :pecosLogin="$pecosLogin" :pecosPassword="$pecosPassword"
                               :stateLicenses="$stateLicenses" :educations="$educations" :deaNumber="$deaNumber"
                               :deaExpiration="$deaExpiration" :workHistory="$workHistory" :references="$references"
                               :insuranceCarrier="$insuranceCarrier" :policyNumber="$policyNumber"
                               :coverageAmount="$coverageAmount" :policyEffectiveDate="$policyEffectiveDate"
                                :policyExpirationDate="$policyExpirationDate" :licenseSuspended="$licenseSuspended"
                                 :felonyConviction="$felonyConviction" :malpracticeClaims="$malpracticeClaims"
                                 :states="$states" />
                        @endif --}}
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center mt-8 pt-6 border-t border-border">
                        <div></div>

                        <div class="flex items-center gap-4">
                            <x-ui.button type="button" wire:click="submitForm"
                                    wire:loading.attr="disabled"
                                    wire:target="submitForm"
                                    wire:loading.class="opacity-50 cursor-not-allowed"
                                    x-on:click="setTimeout(() => window.scrollTo({top: 0, behavior: 'smooth'}), 100)"
                                    class="px-8 py-3 bg-success-600 hover:bg-success-700 text-white font-semibold rounded-lg transition-colors">
                                <span wire:loading.remove wire:target="submitForm">Submit</span>
                                <span wire:loading wire:target="submitForm" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Submitting...
                                </span>
                            </x-ui.button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
