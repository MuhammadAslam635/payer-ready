<?php

use App\Livewire\Registration;
use Livewire\Livewire;

test('step 3 validates invalid DEA number format', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 3)
        ->set('deaNumber', 'INVALID123') // Invalid format
        ->call('nextStep');

    $component->assertHasErrors('deaNumber');
    $component->assertSet('currentStep', 3); // Should not advance
});

test('step 3 validates DEA expiration date in past', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 3)
        ->set('deaNumber', 'AB1234567') // Valid format
        ->set('deaExpiration', '2020-01-01') // Past date
        ->call('nextStep');

    $component->assertHasErrors('deaExpiration');
    $component->assertSet('currentStep', 3); // Should not advance
});

test('step 3 validates incomplete license data', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 3)
        ->set('stateLicenses.0.state', 'CA') // State provided
        ->set('stateLicenses.0.license_number', '') // License number missing
        ->call('nextStep');

    $component->assertHasErrors('stateLicenses.0.license_number');
    $component->assertSet('currentStep', 3); // Should not advance
});

test('step 3 validates missing state when license number provided', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 3)
        ->set('stateLicenses.0.state', '') // State missing
        ->set('stateLicenses.0.license_number', 'LIC123456') // License number provided
        ->call('nextStep');

    $component->assertHasErrors('stateLicenses.0.state');
    $component->assertSet('currentStep', 3); // Should not advance
});

test('step 3 allows skipping when no data provided', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 3)
        ->call('nextStep');

    $component->assertHasNoErrors();
    $component->assertSet('currentStep', 4); // Should advance
});

test('step 3 validates correctly with valid partial data', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 3)
        ->set('deaNumber', 'AB1234567') // Valid format
        ->set('deaExpiration', '2025-12-31') // Future date
        ->call('nextStep');

    $component->assertHasNoErrors();
    $component->assertSet('currentStep', 4); // Should advance
});

test('step 4 validates incomplete work history', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 4)
        ->set('workHistory.0.employer', 'Hospital ABC') // Employer provided
        ->set('workHistory.0.position', '') // Position missing
        ->call('nextStep');

    $component->assertHasErrors('workHistory.0.position');
    $component->assertSet('currentStep', 4); // Should not advance
});

test('step 4 validates missing start date in work history', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 4)
        ->set('workHistory.0.employer', 'Hospital ABC')
        ->set('workHistory.0.position', 'Doctor')
        ->set('workHistory.0.start_date', '') // Start date missing
        ->call('nextStep');

    $component->assertHasErrors('workHistory.0.start_date');
    $component->assertSet('currentStep', 4); // Should not advance
});

test('step 4 validates end date before start date', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 4)
        ->set('workHistory.0.employer', 'Hospital ABC')
        ->set('workHistory.0.position', 'Doctor')
        ->set('workHistory.0.start_date', '2020-01-01')
        ->set('workHistory.0.end_date', '2019-01-01') // End before start
        ->set('workHistory.0.current', false)
        ->call('nextStep');

    $component->assertHasErrors('workHistory.0.end_date');
    $component->assertSet('currentStep', 4); // Should not advance
});

test('step 4 validates incomplete reference data', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 4)
        ->set('references.0.name', 'Dr. Smith') // Name provided
        ->set('references.0.email', '') // Email missing
        ->call('nextStep');

    $component->assertHasErrors('references.0.email');
    $component->assertSet('currentStep', 4); // Should not advance
});

test('step 4 validates invalid reference email', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 4)
        ->set('references.0.name', 'Dr. Smith')
        ->set('references.0.email', 'invalid-email') // Invalid email
        ->set('references.0.relationship', 'Colleague')
        ->call('nextStep');

    $component->assertHasErrors('references.0.email');
    $component->assertSet('currentStep', 4); // Should not advance
});

test('step 4 validates missing relationship in reference', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 4)
        ->set('references.0.name', 'Dr. Smith')
        ->set('references.0.email', 'dr.smith@example.com')
        ->set('references.0.relationship', '') // Relationship missing
        ->call('nextStep');

    $component->assertHasErrors('references.0.relationship');
    $component->assertSet('currentStep', 4); // Should not advance
});

test('step 4 allows skipping when no data provided', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 4)
        ->call('nextStep');

    $component->assertHasNoErrors();
    $component->assertSet('currentStep', 5); // Should advance
});

test('step 5 validates policy expiration before effective date', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 5)
        ->set('policyEffectiveDate', '2024-01-01')
        ->set('policyExpirationDate', '2023-01-01') // Expiration before effective
        ->call('nextStep');

    $component->assertHasErrors('policyExpirationDate');
    $component->assertSet('currentStep', 5); // Should not advance
});

test('step 5 validates invalid coverage amount', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 5)
        ->set('coverageAmount', -1000) // Negative amount
        ->call('nextStep');

    $component->assertHasErrors('coverageAmount');
    $component->assertSet('currentStep', 5); // Should not advance
});

test('step 5 allows skipping when no data provided', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 5)
        ->call('nextStep');

    $component->assertHasNoErrors();
    $component->assertSet('currentStep', 6); // Should advance
});

test('step 5 validates correctly with valid partial data', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 5)
        ->set('insuranceCarrier', 'ABC Insurance')
        ->set('policyNumber', 'POL123456')
        ->set('coverageAmount', 1000000)
        ->set('policyEffectiveDate', '2024-01-01')
        ->set('policyExpirationDate', '2025-01-01')
        ->call('nextStep');

    $component->assertHasNoErrors();
    $component->assertSet('currentStep', 6); // Should advance
});

test('step 6 allows skipping when no documents uploaded', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 6)
        ->call('nextStep');

    $component->assertHasNoErrors();
    $component->assertSet('currentStep', 7); // Should advance
});