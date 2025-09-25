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
            <x-ui.label>Middle Name</x-ui.label>
            <x-ui.input wire:model="middleName" placeholder="Middle name or initial" />
            <x-ui.error name="middleName" />
        </div>

        <!-- Date of Birth -->
        <div class="lg:col-span-1">
            <x-ui.label>Date of Birth *</x-ui.label>
            <x-ui.input type="date" wire:model="dateOfBirth" autocomplete="off" />
            <x-ui.error name="dateOfBirth" />
        </div>

        <!-- Social Security Number -->
        <div class="lg:col-span-1">
            <x-ui.label>Social Security Number *</x-ui.label>
            <x-ui.input type="text" wire:model="ssn" placeholder="123-456-7890" />
            <x-ui.error name="ssn" />
        </div>

        <!-- Phone Number -->
        <div class="lg:col-span-1">
            <x-ui.label>Phone Number *</x-ui.label>
            <x-ui.input type="tel" wire:model="phoneNumber" placeholder="+1 (555) 123-4567" />
            <x-ui.error name="phoneNumber" />
        </div>
        <!-- Home Address -->
        <div class="lg:col-span-2">
            <x-ui.label>Home Address *</x-ui.label>
            <x-ui.textarea wire:model="homeAddress" placeholder="123 Maple St, Anytown, USA" />
            <x-ui.error name="homeAddress" />
        </div>

        <!-- Practice Address -->
        <div class="lg:col-span-2">
            <x-ui.label>Practice Address</x-ui.label>
            <x-ui.textarea wire:model="practiceAddress" placeholder="456 Oak Ave, Anytown, USA" />
            <x-ui.error name="practiceAddress" />
        </div>

        <!-- NPI Number -->
        <div class="lg:col-span-1">
            <x-ui.label>NPI Number *</x-ui.label>
            <x-ui.input type="text" wire:model="npiNumber" placeholder="1234567890" />
            <x-ui.error name="npiNumber" />
        </div>

        <div class="lg:col-span-1"></div>
    </div>

    <!-- CAQH/PECOS Information Section -->
    <div class="lg:col-span-2 mt-6">
        <div class="bg-primary-50 border border-primary-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <svg class="w-5 h-5 text-primary-600 mt-0.5 mr-3" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-text-primary">Optional Information</h3>
                    <p class="text-sm text-primary-700 mt-1">Don't have the provider's CAQH or PECOS logins handy?
                        No problem. You can skip these for now and add them later from your dashboard.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CAQH ID -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="lg:col-span-1">
        <x-ui.label>CAQH ID</x-ui.label>
        <x-ui.input type="text" wire:model="caqhId" placeholder="12345678" />
        <x-ui.error name="caqhId" />
    </div>
    <div class="lg:col-span-1">
        <x-ui.label>CAQH Login</x-ui.label>
        <x-ui.input type="text" wire:model="caqhLogin" placeholder="CAQH username" />
        <x-ui.error name="caqhLogin" />
    </div>

    <!-- CAQH Password -->
    <div class="lg:col-span-1">
        <x-ui.label>CAQH Password</x-ui.label>
        <x-ui.input type="password" wire:model="caqhPassword" placeholder="CAQH password" />
        <x-ui.error name="caqhPassword" />
    </div>

    <!-- PECOS Login -->
    <div class="lg:col-span-1">
        <x-ui.label>PECOS Login</x-ui.label>
        <x-ui.input type="text" wire:model="pecosLogin" placeholder="PECOS username" />
        <x-ui.error name="pecosLogin" />
    </div>

    <!-- PECOS Password -->
    <div class="lg:col-span-1">
        <x-ui.label>PECOS Password</x-ui.label>
        <x-ui.input type="password" wire:model="pecosPassword" placeholder="PECOS password" />
            <x-ui.error name="pecosPassword" />
        </div>
    </div>
</div>
</div>
