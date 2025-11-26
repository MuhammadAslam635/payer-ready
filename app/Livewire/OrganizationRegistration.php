<?php

namespace App\Livewire;

use Livewire\Component;
use App\Traits\RegistrationTrait;
use App\Models\State;
use App\Models\Specialty;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')]
class OrganizationRegistration extends Component
{
    use RegistrationTrait;
    
    public function mount($userType = 'organization')
    {
        $this->userType = $userType;
    }

    public function hydrate()
    {
        // Ensure arrays are always arrays after Livewire deserializes
        $this->initializeArrayProperties();
    }

    public function render()
    {
        $states = State::orderBy('name')->get();
        $specialties = Specialty::orderBy('name')->get();

        return view('livewire.organization-registration', compact('states', 'specialties'));
    }
}
