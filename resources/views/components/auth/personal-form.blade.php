<!-- Step 2: Personal & Contact Information -->
<div>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-text-primary">
            Your Personal & Contact Information
        </h2>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            Optional
        </span>
    </div>
    <p class="text-text-secondary mb-8">
        This information helps with identification and verification. You can skip this step and add it later.
    </p>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Middle Name -->
        <div class="lg:col-span-1">
            <label for="middleName" class="block text-sm font-medium text-text-primary mb-2">
                Middle Name
            </label>
            <input type="text"
                   id="middleName"
                   wire:model="middleName"
                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                   placeholder="Middle name or initial">
        </div>

        <!-- Date of Birth -->
        <div class="lg:col-span-1">
            <label for="dateOfBirth" class="block text-sm font-medium text-text-primary mb-2">
                Date of Birth *
            </label>
            <input type="date"
                   id="dateOfBirth"
                   wire:model="dateOfBirth"
                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('dateOfBirth') border-error-500 @enderror">
            <x-ui.error name="dateOfBirth" />
        </div>

        <!-- Social Security Number -->
        <div class="lg:col-span-1">
            <label for="ssn" class="block text-sm font-medium text-text-primary mb-2">
                Social Security Number *
            </label>
            <div class="relative">
                <input type="password"
                       id="ssn"
                       wire:model="ssn"
                       class="w-full px-3 py-2 pr-10 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('ssn') border-error-500 @enderror"
                       placeholder="XXX-XX-XXXX">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg class="w-5 h-5 text-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-text-tertiary mt-1">Your SSN is encrypted and stored securely.</p>
            <x-ui.error name="ssn" />
        </div>

        <!-- Phone Number -->
        <div class="lg:col-span-1">
            <label for="phoneNumber" class="block text-sm font-medium text-text-primary mb-2">
                Phone Number *
            </label>
            <input type="tel"
                   id="phoneNumber"
                   wire:model="phoneNumber"
                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('phoneNumber') border-error-500 @enderror"
                   placeholder="(555) 123-4567">
            <x-ui.error name="phoneNumber" />
        </div>

        <!-- Home Address -->
        <div class="lg:col-span-2">
            <label for="homeAddress" class="block text-sm font-medium text-text-primary mb-2">
                Home Address *
            </label>
            <textarea id="homeAddress"
                      wire:model="homeAddress"
                      rows="2"
                      class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('homeAddress') border-error-500 @enderror"
                      placeholder="123 Maple St, Anytown, USA"></textarea>
            <x-ui.error name="homeAddress" />
        </div>

        <!-- Practice Address -->
        <div class="lg:col-span-2">
            <label for="practiceAddress" class="block text-sm font-medium text-text-primary mb-2">
                Practice Address
            </label>
            <textarea id="practiceAddress"
                      wire:model="practiceAddress"
                      rows="2"
                      class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                      placeholder="456 Oak Ave, Anytown, USA"></textarea>
        </div>

        <!-- NPI Number -->
        <div class="lg:col-span-1">
            <label for="npiNumber" class="block text-sm font-medium text-text-primary mb-2">
                NPI Number *
            </label>
            <input type="text"
                   id="npiNumber"
                   wire:model="npiNumber"
                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('npiNumber') border-error-500 @enderror"
                   placeholder="1234567890">
            <x-ui.error name="npiNumber" />
        </div>

        <div class="lg:col-span-1"></div>

        <!-- CAQH/PECOS Information Section -->
        <div class="lg:col-span-2 mt-6">
            <div class="bg-primary-50 border border-primary-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <svg class="w-5 h-5 text-primary-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-primary-800">Optional Information</h3>
                        <p class="text-sm text-primary-700 mt-1">Don't have the provider's CAQH or PECOS logins handy? No problem. You can skip these for now and add them later from your dashboard.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CAQH ID -->
        <div class="lg:col-span-1">
            <label for="caqhId" class="block text-sm font-medium text-text-primary mb-2">
                CAQH ID
            </label>
            <input type="text"
                   id="caqhId"
                   wire:model="caqhId"
                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                   placeholder="12345678">
        </div>

        <div class="lg:col-span-1"></div>

        <!-- CAQH Login -->
        <div class="lg:col-span-1">
            <label for="caqhLogin" class="block text-sm font-medium text-text-primary mb-2">
                CAQH Login
            </label>
            <input type="text"
                   id="caqhLogin"
                   wire:model="caqhLogin"
                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                   placeholder="CAQH username">
        </div>

        <!-- CAQH Password -->
        <div class="lg:col-span-1">
            <label for="caqhPassword" class="block text-sm font-medium text-text-primary mb-2">
                CAQH Password
            </label>
            <input type="password"
                   id="caqhPassword"
                   wire:model="caqhPassword"
                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                   placeholder="CAQH password">
        </div>

        <!-- PECOS Login -->
        <div class="lg:col-span-1">
            <label for="pecosLogin" class="block text-sm font-medium text-text-primary mb-2">
                PECOS Login
            </label>
            <input type="text"
                   id="pecosLogin"
                   wire:model="pecosLogin"
                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                   placeholder="PECOS username">
        </div>

        <!-- PECOS Password -->
        <div class="lg:col-span-1">
            <label for="pecosPassword" class="block text-sm font-medium text-text-primary mb-2">
                PECOS Password
            </label>
            <input type="password"
                   id="pecosPassword"
                   wire:model="pecosPassword"
                   class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                   placeholder="PECOS password">
        </div>
    </div>
</div>
