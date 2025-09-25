@props(['userType', 'states' => [], 'specialties' => [], 'errors' => null])

<!-- Step 1: Organization Core Profile -->
<div>
    <h2 class="text-2xl font-bold text-text-primary mb-6">
        Create Your Organization Account & Profile
    </h2>
    <p class="text-text-secondary mb-8">
        Let's start by creating your secure account and gathering some basic information for your organization profile.
    </p>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Full Legal Name -->
        <div class="lg:col-span-1">
            <x-ui.label>Full Name *</x-ui.label>
            <x-ui.input wire:model="name" placeholder="e.g., John B. Smith, MD" />
           <x-ui.error name="name" />

        </div>

        <!-- Primary Email -->
        <div class="lg:col-span-1">
            <x-ui.label>Primary Email *</x-ui.label>
            <x-ui.input wire:model="email" type="email" autocomplete="username"
                placeholder="e.g., admin@organization.com" />
            <x-ui.error name="email" />
        </div>

        <!-- Business Name -->
        <div class="lg:col-span-2">
            <x-ui.label>Business Name *</x-ui.label>
            <x-ui.input wire:model="organizationName" placeholder="e.g., Oakside Medical Group" />
            <x-ui.error name="organizationName" />
        </div>

        <!-- Primary State of Practice -->
        <div class="lg:col-span-1">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                <div class="lg:col-span-2">
                    <x-ui.label>Primary State of Practice *</x-ui.label>
                    <x-ui.select wire:model="primaryState" icon="map-pin" iconPosition="right" searchable
                        :invalid="$errors->has('primaryState')">
                        <x-ui.select.option value="">Select a state...</x-ui.select.option>
                        @foreach ($states as $state)
                            <x-ui.select.option value="{{ $state->id }}">{{ $state->name }}</x-ui.select.option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.error name ="primaryState" />
                </div>
                <div class="col-span-1">
                    <x-ui.label>Taxnomy Code</x-ui.label>
                    <x-ui.input wire:model="taxnomy_code" placeholder="Enter taxnomy code" />
                    <x-ui.error name="taxnomy_code" />
                </div>
            </div>
        </div>


        <div class="lg:col-span-1">
            <x-ui.label>Primary Specialty *</x-ui.label>
            <x-ui.select wire:model="primarySpecialty" searchable icon="puzzle-piece" iconPosition="right"
                :invalid="$errors->has('primarySpecialty')">
                <x-ui.select.option value="">Choose a specialty...</x-ui.select.option>
                @foreach ($specialties as $specialty)
                    <x-ui.select.option value="{{ $specialty->id }}">{{ $specialty->name }}</x-ui.select.option>
                @endforeach
            </x-ui.select>
            <x-ui.error name="primarySpecialty" />
        </div>



        <!-- Password -->
        <div class="lg:col-span-1">
            <x-ui.label>Password *</x-ui.label>
            <x-ui.input wire:model="password" type="password" placeholder="Create a strong password" revealable />
            <x-ui.error name="password" />
        </div>

        <!-- Password Confirmation -->
        <div class="lg:col-span-1">
            <x-ui.label>Confirm Password *</x-ui.label>
            <x-ui.input wire:model="password_confirmation" type="password" placeholder="Confirm your password"
                revealable />
            <x-ui.error name="password_confirmation" />
        </div>
    </div>
</div>
