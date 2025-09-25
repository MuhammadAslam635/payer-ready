@props(['userType', 'states' => [], 'specialties' => [], 'errors' => null])


<!-- Step 1: Core Profile -->
<div>
    <h2 class="text-2xl font-bold text-text-primary mb-6">
        Create Your Account & Profile
    </h2>
    <p class="text-text-secondary mb-8">
        Let's start by creating your secure account and gathering some basic information for your
        {{ $userType === 'doctor' ? 'provider' : 'organization' }} profile.
    </p>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Full Legal Name -->
        <div class="lg:col-span-1">
            <x-ui.label>Full Name *</x-ui.label>
            <x-ui.input wire:model="name" placeholder="e.g., John B. Smith, MD" :invalid="$errors && $errors->has('name')" />
            <x-ui.error name="name" />
        </div>

        <!-- Primary Email -->
        <div class="lg:col-span-1">
            <x-ui.label>Primary Email *</x-ui.label>
            <x-ui.input wire:model="email" type="email" autocomplete="username"
                placeholder="e.g., john.smith@practice.com" :invalid="$errors && $errors->has('email')" />
            <x-ui.error name="email" />
        </div>



        <!-- Business Name (for doctors) -->
        <div class="lg:col-span-2">
            <x-ui.label>Business Name *</x-ui.label>
            <x-ui.input wire:model="organizationName" placeholder="e.g., Oakside Medical Group" :invalid="$errors && $errors->has('organizationName')" />
            <x-ui.error name="organizationName" />
        </div>



        <div class="lg:col-span-1">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                <div class="col-span-2">
                    <x-ui.label>Primary Specialty *</x-ui.label>
                    <x-ui.select wire:model="primarySpecialty" icon="puzzle-piece" iconPosition="right" searchable
                        :invalid="$errors->has('primarySpecialty')" placeholder="Select a specialty...">
                        <x-ui.select.option value="">Select a specialty...</x-ui.select.option>
                        @foreach ($specialties as $specialty)
                            <x-ui.select.option value="{{ $specialty->id }}">{{ $specialty->name }}</x-ui.select.option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.error name="primarySpecialty" />
                </div>
                <div class="col-span-1">
                    <x-ui.label>Taxonomy Code</x-ui.label>
                    <x-ui.input wire:model="taxnomy_code" placeholder="e.g., 123456789" :invalid="$errors->has('taxnomy_code')" />
                    <x-ui.error name="taxnomy_code" />
                </div>
            </div>
        </div>



        <!-- Primary State of Practice -->
        <div class="lg:col-span-1">
            <x-ui.label>Primary State of Practice *</x-ui.label>
            <x-ui.select wire:model="primaryState" icon="map-pin" iconPosition="right" searchable :invalid="$errors->has('primaryState')"
                placeholder="Select a state of practice...">
                <x-ui.select.option value="">Select a state of practice...</x-ui.select.option>
                @foreach ($states as $state)
                    <x-ui.select.option value="{{ $state->id }}">{{ $state->name }}</x-ui.select.option>
                @endforeach
            </x-ui.select>
            <x-ui.error name="primaryState" />
        </div>

        <!-- Password -->
        <div class="lg:col-span-1">
            <x-ui.label>Password *</x-ui.label>
            <div class="relative">
                <x-ui.input wire:model="password" placeholder="Create a strong password" type="password"
                    :invalid="$errors->has('password')" revealable />
                <p class="text-sm text-text-tertiary mt-1">Must be at least 8 characters.</p>
            </div>
            <x-ui.error name="password" />
        </div>

        <!-- Confirm Password -->
        <div class="lg:col-span-1">
            <x-ui.label>Confirm Password *</x-ui.label>
            <x-ui.input wire:model="password_confirmation" type="password" placeholder="Re-enter your password"
                :invalid="$errors->has('password_confirmation')" revealable />
            <x-ui.error name="password_confirmation" />
        </div>
    </div>
</div>
