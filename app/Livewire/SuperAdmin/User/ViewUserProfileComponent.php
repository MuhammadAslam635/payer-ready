<?php

namespace App\Livewire\SuperAdmin\User;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\DoctorProfile;
use App\Models\PracticeLocation;
use App\Models\Specialty;
use App\Models\State;
use App\Traits\HasToast;

#[Title('User Profile')]
#[Layout('layouts.dashboard')]
class ViewUserProfileComponent extends Component
{
    use HasToast;

    public $userId;
    public $user;
    public $doctorProfile;
    public $practiceLocations = [];
    public $specialties = [];
    public $states = [];
    public $activeTab = 'information';
    
    public function mount($userId)
    {
        $this->userId = $userId;
        $this->user = User::with(['doctorProfile'])->findOrFail($userId);
        $this->doctorProfile = $this->user->doctorProfile;
        $this->specialties = Specialty::orderBy('name')->get();
        $this->states = State::orderBy('name')->get();
        $this->loadPracticeLocations();
    }

    public function loadPracticeLocations()
    {
        $this->practiceLocations = PracticeLocation::where('user_id', $this->userId)->get();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.super-admin.user.view-user-profile-component');
    }
}
