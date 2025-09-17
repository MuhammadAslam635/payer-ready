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
                <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="cv" />
                @error('cv')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
            </div>
        </div>

        <!-- Professional License (copy) -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                <x-ui.label>Professional License (copy)</x-ui.label>
                <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="professionalLicense" />
                @error('professionalLicense')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
            </div>
        </div>

        <!-- Picture ID (Driver's License or Passport) -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                <x-ui.label>Picture ID (Driver's License or Passport)</x-ui.label>
                <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="pictureId" />
                @error('pictureId')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
            </div>
        </div>

        <!-- Social Security Card (copy) -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                <x-ui.label>Social Security Card (copy)</x-ui.label>
                <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="socialSecurityCard" />
                @error('socialSecurityCard')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
            </div>
        </div>

        <!-- Certificate of Liability Insurance -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                    <x-ui.label>Certificate of Liability Insurance</x-ui.label>
                    <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="certificateOfLiabilityInsurance" />
                @error('certificateOfLiabilityInsurance')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
            </div>
        </div>

        <!-- Copies of Diplomas/Certifications -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                <x-ui.label>Copies of Diplomas/Certifications</x-ui.label>
                <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="copiesOfDiplomasCertifications" />
                @error('copiesOfDiplomasCertifications')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
            </div>
        </div>

        <!-- State Credentialing Application -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                <x-ui.label>State Credentialing Application</x-ui.label>
                    <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="stateCredentialingApplication" />
                @error('stateCredentialingApplication')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
            </div>
        </div>

        <!-- Passport Style Photo -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                <x-ui.label>Passport Style Photo</x-ui.label>
                <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="passportStylePhoto" />
                @error('passportStylePhoto')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
            </div>
        </div>

        <!-- ECFMG Certificate -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                <x-ui.label>ECFMG Certificate</x-ui.label>
                <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="ecfmgCertificate" />
                @error('ecfmgCertificate')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
            </div>
        </div>

        <!-- Board Certificate -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                    <x-ui.label>Board Certificate</x-ui.label>
                    <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="boardCertificate" />
                @error('boardCertificate')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
            </div>
        </div>

        <!-- Procedure Log -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                    <x-ui.label>Procedure Log</x-ui.label>
                    <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="procedureLog" />
                @error('procedureLog')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
            </div>
        </div>

        <!-- CMEs/CEs (copy) -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                <x-ui.label>CMEs/CEs (copy)</x-ui.label>
                <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="cmeCs" />
                @error('cmeCs')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
            </div>
        </div>

        <!-- Immunization / Shot Records -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                <x-ui.label>Immunization / Shot Records</x-ui.label>
                <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="immunizationShotRecords" />
                @error('immunizationShotRecords')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
            </div>
        </div>

        <!-- ACLS/BLS Certificate -->
        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex flex-col gap-2">
                <x-ui.label>ACLS/BLS Certificate</x-ui.label>
                <x-ui.description>PDF, JPG, or PNG</x-ui.description>
                <x-ui.input type="file" wire:model.live="aclsBlsCertificate" />
                @error('aclsBlsCertificate')
                    <x-ui.error>{{ $message }}</x-ui.error>
                @enderror
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
