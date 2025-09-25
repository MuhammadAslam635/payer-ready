<?php

use App\Livewire\Registration;
use Livewire\Livewire;

test('validation errors are properly displayed for missing relationship field', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 4)
        ->set('references.0.name', 'Dr. Jane Doe')
        ->set('references.0.title', 'Senior Doctor')
        ->set('references.0.email', 'valid@email.com')
        // Missing relationship field - should trigger validation error
        ->call('nextStep');

    $component->assertHasErrors('references.0.relationship');
});

test('validation errors are properly displayed for invalid email', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 4)
        ->set('references.0.name', 'Dr. Jane Doe')
        ->set('references.0.title', 'Senior Doctor')
        ->set('references.0.relationship', 'Colleague')
        ->set('references.0.email', 'invalid-email')
        ->call('nextStep');

    $component->assertHasErrors('references.0.email');
});

test('validation passes with all required fields filled correctly', function () {
    $component = Livewire::test(Registration::class, ['userType' => 'doctor'])
        ->set('currentStep', 4)
        ->set('references.0.name', 'Dr. Jane Doe')
        ->set('references.0.title', 'Senior Doctor')
        ->set('references.0.relationship', 'Colleague')
        ->set('references.0.email', 'valid@email.com')
        ->set('references.0.phone', '123-456-7890')
        ->set('references.0.facility_address', '123 Main St')
        ->call('nextStep');

    $component->assertHasNoErrors();
    $component->assertSet('currentStep', 5);
});