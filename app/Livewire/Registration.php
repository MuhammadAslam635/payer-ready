<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\State;
use App\Models\Specialty;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rules;
use App\Traits\RegistrationTrait;

#[Layout('layouts.guest')]
class Registration extends Component
{
    use RegistrationTrait;
    public function mount($userType = 'doctor')
    {
        $this->userType = $userType;
    }

    public function render()
    {
        $states = State::orderBy('name')->get();
        $specialties = Specialty::orderBy('name')->get();

        return view('livewire.registration', compact('states', 'specialties'));
    }
}
