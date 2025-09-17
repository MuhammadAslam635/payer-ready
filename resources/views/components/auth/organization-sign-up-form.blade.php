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
            @if($errors && $errors->has('name'))
                <span class="text-error-600 text-sm mt-1">{{ $errors->first('name') }}</span>
            @endif

        </div>

        <!-- Primary Email -->
        <div class="lg:col-span-1">
            <x-ui.label>Primary Email *</x-ui.label>
            <x-ui.input wire:model="email" placeholder="e.g., admin@organization.com" />
            @if($errors && $errors->has('email'))
                <span class="text-error-600 text-sm mt-1">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <!-- Business Name -->
        <div class="lg:col-span-2">
            <x-ui.label>Business Name *</x-ui.label>
            <x-ui.input wire:model="organizationName" placeholder="e.g., Oakside Medical Group" />
            @if($errors && $errors->has('organizationName'))
                <span class="text-error-600 text-sm mt-1">{{ $errors->first('organizationName') }}</span>
            @endif
        </div>

        <!-- Primary State of Practice -->
        <div class="lg:col-span-1">
            <x-ui.label>Primary State of Practice *</x-ui.label>
            <x-ui.select wire:model="primaryState">
                <x-ui.select.option value="">Select a state...</x-ui.select.option>
                @foreach ($states as $state)
                    <x-ui.select.option value="{{ $state->code }}">{{ $state->name }}</x-ui.select.option>
                @endforeach
            </x-ui.select>
            @if($errors && $errors->has('primaryState'))
                <span class="text-error-600 text-sm mt-1">{{ $errors->first('primaryState') }}</span>
            @endif
        </div>

        @if($userType === 'doctor')
        <!-- Primary Specialty (only for doctors) -->
        <div class="lg:col-span-1">
            <x-ui.label>Primary Specialty *</x-ui.label>
            <x-ui.select wire:model="primarySpecialty">
                <x-ui.select.option value="">Choose a specialty...</x-ui.select.option>
                @foreach ($specialties as $specialty)
                    <x-ui.select.option value="{{ $specialty->id }}">{{ $specialty->name }}</x-ui.select.option>
                @endforeach
            </x-ui.select>
            @if($errors && $errors->has('primarySpecialty'))
                <span class="text-error-600 text-sm mt-1">{{ $errors->first('primarySpecialty') }}</span>
            @endif
        </div>

        <!-- Taxonomy Code (optional for doctors) -->
        <div class="lg:col-span-1">
            <x-ui.label>Taxonomy Code</x-ui.label>
            <x-ui.input wire:model="taxonomyCode" placeholder="e.g., 207Q00000X" />
            @if($errors && $errors->has('taxonomyCode'))
                <span class="text-error-600 text-sm mt-1">{{ $errors->first('taxonomyCode') }}</span>
            @endif
        </div>
        @endif

        <!-- Password -->
        <div class="lg:col-span-1">
            <x-ui.label>Password *</x-ui.label>
            <x-ui.input wire:model="password" type="password" placeholder="Create a strong password" revealable />
            @if($errors && $errors->has('password'))
                <span class="text-error-600 text-sm mt-1">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <!-- Password Confirmation -->
        <div class="lg:col-span-2">
            <x-ui.label>Confirm Password *</x-ui.label>
            <x-ui.input wire:model="password_confirmation" type="password" placeholder="Confirm your password" revealable />
            @if($errors && $errors->has('password_confirmation'))
                <span class="text-error-600 text-sm mt-1">{{ $errors->first('password_confirmation') }}</span>
            @endif
        </div>
    </div>
</div>
