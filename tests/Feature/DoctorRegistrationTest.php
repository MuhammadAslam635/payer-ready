<?php

use App\Livewire\Registration;
use App\Models\State;
use App\Models\Specialty;
use Livewire\Livewire;

test('doctor registration page can be rendered', function () {
    $response = $this->get('/doctor-register');
    $response->assertStatus(200);
});

test('registration component initializes with correct user type', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor']);
    $component->assertSet('userType', 'doctor');
});

test('email field accepts valid email addresses', function () {
    // Seed required data
    $this->seed([
        \Database\Seeders\StatesSeeder::class,
        \Database\Seeders\SpecialtiesSeeder::class,
    ]);

    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('name', 'John Smith')
        ->set('email', 'john.smith@clinic.com')
        ->set('organizationName', 'Smith Medical Clinic')
        ->set('primarySpecialty', Specialty::first()->id)
        ->set('primaryState', State::first()->id)
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('nextStep');

    $component->assertHasNoErrors('email');
});

test('email field rejects invalid email formats', function () {
    // Seed required data
    $this->seed([
        \Database\Seeders\StatesSeeder::class,
        \Database\Seeders\SpecialtiesSeeder::class,
    ]);

    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('name', 'John Smith')
        ->set('email', 'invalid-email')
        ->set('organizationName', 'Smith Medical Clinic')
        ->set('primarySpecialty', Specialty::first()->id)
        ->set('primaryState', State::first()->id)
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('nextStep');

    $component->assertHasErrors('email');
});

test('email field does not accept date values', function () {
    // Seed required data
    $this->seed([
        \Database\Seeders\StatesSeeder::class,
        \Database\Seeders\SpecialtiesSeeder::class,
    ]);

    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('name', 'John Smith')
        ->set('email', '2024-01-01')
        ->set('organizationName', 'Smith Medical Clinic')
        ->set('primarySpecialty', Specialty::first()->id)
        ->set('primaryState', State::first()->id)
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('nextStep');

    $component->assertHasErrors('email');
});

test('step 1 validation requires all mandatory fields', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->call('nextStep');

    $component->assertHasErrors(['name', 'email', 'organizationName', 'password']);
});

test('step 1 validation passes with valid data', function () {
    // Seed required data
    $this->seed([
        \Database\Seeders\StatesSeeder::class,
        \Database\Seeders\SpecialtiesSeeder::class,
    ]);

    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('name', 'John Smith')
        ->set('email', 'john.smith@clinic.com')
        ->set('organizationName', 'Smith Medical Clinic')
        ->set('primarySpecialty', Specialty::first()->id)
        ->set('primaryState', State::first()->id)
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('nextStep');

    $component->assertHasNoErrors();
    $component->assertSet('currentStep', 2);
});

test('date of birth field accepts valid dates', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 2)
        ->set('dateOfBirth', '1990-01-01')
        ->call('nextStep');

    $component->assertHasNoErrors('dateOfBirth');
});

test('date of birth field rejects future dates', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 2)
        ->set('dateOfBirth', '2025-01-01')
        ->call('nextStep');

    $component->assertHasErrors('dateOfBirth');
});

test('password confirmation must match password', function () {
    // Seed required data
    $this->seed([
        \Database\Seeders\StatesSeeder::class,
        \Database\Seeders\SpecialtiesSeeder::class,
    ]);

    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('name', 'John Smith')
        ->set('email', 'john.smith@clinic.com')
        ->set('organizationName', 'Smith Medical Clinic')
        ->set('primarySpecialty', Specialty::first()->id)
        ->set('primaryState', State::first()->id)
        ->set('password', 'password123')
        ->set('password_confirmation', 'different_password')
        ->call('nextStep');

    $component->assertHasErrors('password_confirmation');
});

test('can navigate between steps', function () {
    // Seed required data
    $this->seed([
        \Database\Seeders\StatesSeeder::class,
        \Database\Seeders\SpecialtiesSeeder::class,
    ]);

    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('name', 'John Smith')
        ->set('email', 'john.smith@clinic.com')
        ->set('organizationName', 'Smith Medical Clinic')
        ->set('primarySpecialty', Specialty::first()->id)
        ->set('primaryState', State::first()->id)
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('nextStep')
        ->assertSet('currentStep', 2)
        ->call('prevStep')
        ->assertSet('currentStep', 1);
});

test('can skip optional steps', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 2)
        ->call('skipStep')
        ->assertSet('currentStep', 3);
});

test('references array initializes with correct structure', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor']);
    
    $references = $component->get('references');
    
    expect($references)->toHaveCount(2);
    expect($references[0])->toHaveKeys(['name', 'title', 'facility_address', 'phone', 'email', 'relationship']);
    expect($references[1])->toHaveKeys(['name', 'title', 'facility_address', 'phone', 'email', 'relationship']);
});

test('reference email validation works correctly', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 4)
        ->set('references.0.name', 'Dr. Jane Doe')
        ->set('references.0.title', 'Senior Doctor')
        ->set('references.0.email', 'invalid-email')
        ->call('nextStep');

    $component->assertHasErrors('references.0.email');
});

test('valid reference email passes validation', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 4)
        ->set('references.0.name', 'Dr. Jane Doe')
        ->set('references.0.title', 'Senior Doctor')
        ->set('references.0.relationship', 'Colleague')
        ->set('references.0.email', 'jane.doe@hospital.com')
        ->call('nextStep');

    $component->assertHasNoErrors('references.0.email');
});