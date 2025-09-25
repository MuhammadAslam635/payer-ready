@php
    $uploadGuideText = "Upload Guide: Please ensure all documents are clear, legible, and in the correct format. Maximum file size is 10MB unless otherwise specified.";
    
    // File type descriptions array
    $fileTypeDescriptions = [
        'cv' => 'PDF, DOC, DOCX',
        'professionalLicense' => 'PDF, JPG, JPEG, PNG',
        'pictureId' => 'JPG, JPEG, PNG',
        'socialSecurityCard' => 'PDF, JPG, JPEG, PNG',
        'certificateOfLiabilityInsurance' => 'PDF, JPG, JPEG, PNG',
        'copiesOfDiplomasCertifications' => 'PDF, JPG, JPEG, PNG',
        'stateCredentialingApplication' => 'PDF, JPG, JPEG, PNG',
        'passportStylePhoto' => 'JPG, JPEG, PNG',
        'ecfmgCertificate' => 'PDF, JPG, JPEG, PNG',
        'boardCertificate' => 'PDF, JPG, JPEG, PNG',
        'procedureLog' => 'PDF, DOC, DOCX, XLS, XLSX',
        'cmeCs' => 'PDF, DOC, DOCX',
        'immunizationShotRecords' => 'PDF, JPG, JPEG, PNG',
        'aclsBlsCertificate' => 'PDF, JPG, JPEG, PNG',
    ];
@endphp

<!-- Step 6: Document Upload -->
<div>
    <h2 class="text-2xl font-bold text-text-primary mb-6">
        Document Upload
    </h2>
    <p class="text-text-secondary mb-8">
        Securely upload the provider's required documents for verification.
    </p>

    <!-- Good to Know Section -->
    <div class="bg-primary-50 border border-primary-200 rounded-lg p-4 mb-8">
        <div class="flex">
            <svg class="w-5 h-5 text-primary-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-primary-800">Good to know</h3>
                <p class="text-sm text-primary-700 mt-1">To make onboarding faster, all document uploads are optional. You can easily add any missing documents later from the provider's profile in the dashboard.</p>
            </div>
        </div>
    </div>

    <!-- Document Upload Grid -->
    <div class="space-y-6">
        <!-- Curriculum Vitae (CV) -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                <x-ui.label>Curriculum Vitae (CV)</x-ui.label>
                <x-ui.description>{{ $fileTypeDescriptions['cv'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                <x-ui.input type="file" wire:model.live="cv" />
                @if($cv)
                    <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-green-700">✓ File uploaded: {{ $cv->getClientOriginalName() }}</span>
                            @if($cv->temporaryUrl())
                                <a href="{{ $cv->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                            @endif
                        </div>
                    </div>
                @endif
                <x-ui.error name="cv" />
            </div>
        </div>

        <!-- Professional License (copy) -->
        <div class="mb-4">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col gap-2">
                    <x-ui.label>Professional License (copy)</x-ui.label>
                    <x-ui.description>{{ $fileTypeDescriptions['professionalLicense'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                    <x-ui.input type="file" wire:model.live="professionalLicense" />
                    @if($professionalLicense)
                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">✓ File uploaded: {{ $professionalLicense->getClientOriginalName() }}</span>
                                @if($professionalLicense->temporaryUrl())
                                    <a href="{{ $professionalLicense->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <x-ui.error name="professionalLicense" />
                </div>
            </div>
        </div>

        <!-- Picture ID (Driver's License or Passport) -->
        <div class="mb-4">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col gap-2">
                    <x-ui.label>Picture ID (Driver's License or Passport)</x-ui.label>
                    <x-ui.description>{{ $fileTypeDescriptions['pictureId'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                    <x-ui.input type="file" wire:model.live="pictureId" />
                    @if($pictureId)
                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">✓ File uploaded: {{ $pictureId->getClientOriginalName() }}</span>
                                @if($pictureId->temporaryUrl())
                                    <a href="{{ $pictureId->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <x-ui.error name="pictureId" />
                </div>
            </div>
        </div>

        <!-- Social Security Card (copy) -->
        <div class="mb-4">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col gap-2">
                    <x-ui.label>Social Security Card (copy)</x-ui.label>
                    <x-ui.description>{{ $fileTypeDescriptions['socialSecurityCard'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                    <x-ui.input type="file" wire:model.live="socialSecurityCard" />
                    @if($socialSecurityCard)
                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">✓ File uploaded: {{ $socialSecurityCard->getClientOriginalName() }}</span>
                                @if($socialSecurityCard->temporaryUrl())
                                    <a href="{{ $socialSecurityCard->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <x-ui.error name="socialSecurityCard" />
                </div>
            </div>
        </div>

        <!-- Certificate of Liability Insurance -->
        <div class="mb-4">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col gap-2">
                    <x-ui.label>Certificate of Liability Insurance</x-ui.label>
                    <x-ui.description>{{ $fileTypeDescriptions['certificateOfLiabilityInsurance'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                    <x-ui.input type="file" wire:model.live="certificateOfLiabilityInsurance" />
                    @if($certificateOfLiabilityInsurance)
                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">✓ File uploaded: {{ $certificateOfLiabilityInsurance->getClientOriginalName() }}</span>
                                @if($certificateOfLiabilityInsurance->temporaryUrl())
                                    <a href="{{ $certificateOfLiabilityInsurance->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <x-ui.error name="certificateOfLiabilityInsurance" />
                </div>
            </div>
        </div>

        <!-- Copies of Diplomas/Certifications -->
        <div class="mb-4">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col gap-2">
                    <x-ui.label>Copies of Diplomas/Certifications</x-ui.label>
                    <x-ui.description>{{ $fileTypeDescriptions['copiesOfDiplomasCertifications'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                    <x-ui.input type="file" wire:model.live="copiesOfDiplomasCertifications" />
                    @if($copiesOfDiplomasCertifications)
                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">✓ File uploaded: {{ $copiesOfDiplomasCertifications->getClientOriginalName() }}</span>
                                @if($copiesOfDiplomasCertifications->temporaryUrl())
                                    <a href="{{ $copiesOfDiplomasCertifications->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <x-ui.error name="copiesOfDiplomasCertifications" />
                </div>
            </div>
        </div>

        <!-- State Credentialing Application -->
        <div class="mb-4">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col gap-2">
                    <x-ui.label>State Credentialing Application</x-ui.label>
                    <x-ui.description>{{ $fileTypeDescriptions['stateCredentialingApplication'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                    <x-ui.input type="file" wire:model.live="stateCredentialingApplication" />
                    @if($stateCredentialingApplication)
                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">✓ File uploaded: {{ $stateCredentialingApplication->getClientOriginalName() }}</span>
                                @if($stateCredentialingApplication->temporaryUrl())
                                    <a href="{{ $stateCredentialingApplication->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <x-ui.error name="stateCredentialingApplication" />
                </div>
            </div>
        </div>

        <!-- Passport Style Photo -->
        <div class="mb-4">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col gap-2">
                    <x-ui.label>Passport Style Photo</x-ui.label>
                    <x-ui.description>{{ $fileTypeDescriptions['passportStylePhoto'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                    <x-ui.input type="file" wire:model.live="passportStylePhoto" />
                    @if($passportStylePhoto)
                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">✓ File uploaded: {{ $passportStylePhoto->getClientOriginalName() }}</span>
                                @if($passportStylePhoto->temporaryUrl())
                                    <a href="{{ $passportStylePhoto->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <x-ui.error name="passportStylePhoto" />
                </div>
            </div>
        </div>

        <!-- ECFMG Certificate -->
        <div class="mb-4">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col gap-2">
                    <x-ui.label>ECFMG Certificate</x-ui.label>
                    <x-ui.description>{{ $fileTypeDescriptions['ecfmgCertificate'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                    <x-ui.input type="file" wire:model.live="ecfmgCertificate" />
                    @if($ecfmgCertificate)
                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">✓ File uploaded: {{ $ecfmgCertificate->getClientOriginalName() }}</span>
                                @if($ecfmgCertificate->temporaryUrl())
                                    <a href="{{ $ecfmgCertificate->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <x-ui.error name="ecfmgCertificate" />
                </div>
            </div>
        </div>

        <!-- Board Certificate -->
        <div class="mb-4">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col gap-2">
                    <x-ui.label>Board Certificate</x-ui.label>
                    <x-ui.description>{{ $fileTypeDescriptions['boardCertificate'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                    <x-ui.input type="file" wire:model.live="boardCertificate" />
                    @if($boardCertificate)
                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">✓ File uploaded: {{ $boardCertificate->getClientOriginalName() }}</span>
                                @if($boardCertificate->temporaryUrl())
                                    <a href="{{ $boardCertificate->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <x-ui.error name="boardCertificate" />
                </div>
            </div>
        </div>

        <!-- Procedure Log -->
        <div class="mb-4">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col gap-2">
                    <x-ui.label>Procedure Log</x-ui.label>
                    <x-ui.description>{{ $fileTypeDescriptions['procedureLog'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                    <x-ui.input type="file" wire:model.live="procedureLog" />
                    @if($procedureLog)
                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">✓ File uploaded: {{ $procedureLog->getClientOriginalName() }}</span>
                                @if($procedureLog->temporaryUrl())
                                    <a href="{{ $procedureLog->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <x-ui.error name="procedureLog" />
                </div>
            </div>
        </div>

        <!-- CME Cs -->
        <div class="mb-4">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col gap-2">
                    <x-ui.label>CMEs/CEs (copy)</x-ui.label>
                    <x-ui.description>{{ $fileTypeDescriptions['cmeCs'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                    <x-ui.input type="file" wire:model.live="cmeCs" />
                    @if($cmeCs)
                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">✓ File uploaded: {{ $cmeCs->getClientOriginalName() }}</span>
                                @if($cmeCs->temporaryUrl())
                                    <a href="{{ $cmeCs->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <x-ui.error name="cmeCs" />
                </div>
            </div>
        </div>

        <!-- Immunization Shot Records -->
        <div class="mb-4">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col gap-2">
                    <x-ui.label>Immunization / Shot Records</x-ui.label>
                    <x-ui.description>{{ $fileTypeDescriptions['immunizationShotRecords'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                    <x-ui.input type="file" wire:model.live="immunizationShotRecords" />
                    @if($immunizationShotRecords)
                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">✓ File uploaded: {{ $immunizationShotRecords->getClientOriginalName() }}</span>
                                @if($immunizationShotRecords->temporaryUrl())
                                    <a href="{{ $immunizationShotRecords->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <x-ui.error name="immunizationShotRecords" />
                </div>
            </div>
        </div>

        <!-- ACLS/BLS Certificate -->
        <div class="mb-4">
            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                <div class="flex flex-col gap-2">
                    <x-ui.label>ACLS/BLS Certificate</x-ui.label>
                    <x-ui.description>{{ $fileTypeDescriptions['aclsBlsCertificate'] ?? 'PDF, JPG, JPEG, PNG' }}</x-ui.description>
                    <x-ui.input type="file" wire:model.live="aclsBlsCertificate" />
                    @if($aclsBlsCertificate)
                        <div class="mt-2 p-2 bg-green-50 border border-green-200 rounded-md">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-green-700">✓ File uploaded: {{ $aclsBlsCertificate->getClientOriginalName() }}</span>
                                @if($aclsBlsCertificate->temporaryUrl())
                                    <a href="{{ $aclsBlsCertificate->temporaryUrl() }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Preview</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <x-ui.error name="aclsBlsCertificate" />
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Instructions -->
    <div class="mt-8 bg-gray-50 border border-gray-200 rounded-lg p-6">
        <h4 class="text-sm font-medium text-text-primary mb-2">Upload Guidelines</h4>
        <ul class="text-sm text-text-secondary space-y-1">
            <li>• Accepted formats: PDF, JPG, PNG</li>
            <li>• Maximum file size: 10MB per document</li>
            <li>• Ensure documents are clear and readable</li>
            <li>• All uploaded documents are securely encrypted</li>
        </ul>
    </div>
</div>
