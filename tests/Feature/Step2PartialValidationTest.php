<?php

use App\Livewire\Registration;
use Livewire\Livewire;

test('step 2 validates invalid date of birth when provided', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 2)
        ->set('dateOfBirth', '2030-01-01') // Future date - invalid
        ->call('nextStep');

    $component->assertHasErrors('dateOfBirth');
});

test('step 2 validates invalid SSN format when provided', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 2)
        ->set('ssn', '123456789') // Wrong format - should be XXX-XX-XXXX
        ->call('nextStep');

    $component->assertHasErrors('ssn');
});

test('step 2 validates invalid NPI number when provided', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 2)
        ->set('npiNumber', '12345') // Too short - should be 10 digits
        ->call('nextStep');

    $component->assertHasErrors('npiNumber');
});

test('step 2 validates invalid phone number when provided', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 2)
        ->set('phoneNumber', 'invalid-phone') // Invalid format
        ->call('nextStep');

    $component->assertHasErrors('phoneNumber');
});

test('step 2 allows skipping when no data is provided', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 2)
        ->call('nextStep');

    $component->assertHasNoErrors();
    $component->assertSet('currentStep', 3);
});

test('step 2 validates correctly with valid partial data', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 2)
        ->set('dateOfBirth', '1990-01-01')
        ->set('ssn', '123-45-6789')
        ->set('npiNumber', '1234567890')
        ->call('nextStep');

    $component->assertHasNoErrors();
    $component->assertSet('currentStep', 3);
});

test('step 2 validates mixed valid and invalid data', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 2)
        ->set('dateOfBirth', '1990-01-01') // Valid
        ->set('ssn', 'invalid-ssn') // Invalid
        ->set('npiNumber', '1234567890') // Valid
        ->call('nextStep');

    $component->assertHasErrors('ssn');
    $component->assertHasNoErrors(['dateOfBirth', 'npiNumber']);
});