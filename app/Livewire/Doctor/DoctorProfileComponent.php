<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\DoctorProfile;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasToast;

#[Title('Doctor Profile')]
#[Layout('layouts.dashboard')]
class DoctorProfileComponent extends Component
{
    use HasToast;

    public $editing = false;
    public $doctorProfile;
    public $specialties = [];
    public $showEditForm = false;

    // Form fields - User table fields
    public $name = '';
    public $middle_name = '';
    public $email = '';
    public $phone = '';
    public $date_of_birth = '';
    public $is_active = true;
    public $npi_number = '';
    public $dea_number = '';
    public $dea_expiration_date = '';
    public $caqh_id = '';
    public $caqh_login = '';
    public $caqh_password = '';
    public $pecos_login = '';
    public $pecos_password = '';

    // Doctor Profile fields
    public $status = 'active';
    public $primary_specialty_id = '';
    public $experience_years = '';
    public $board_certified = false;
    public $board_certification_date = '';
    public $bio = '';

    public function mount()
    {
        $this->loadProfile();
        $this->specialties = Specialty::orderBy('name')->get();
    }

    public function loadProfile()
    {
        $user = Auth::user();
        $this->doctorProfile = $user->doctorProfile;

        // Load user data
        $this->name = $user->name ?? '';
        $this->middle_name = $user->middle_name ?? '';
        $this->email = $user->email ?? '';
        $this->phone = $user->phone ?? '';
        $this->date_of_birth = $user->date_of_birth;
        $this->is_active = $user->is_active ?? true;
        $this->npi_number = $user->npi_number ?? '';
        $this->dea_number = $user->dea_number ?? '';
        $this->dea_expiration_date = $user->dea_expiration_date;
        $this->caqh_id = $user->caqh_id ?? '';
        $this->caqh_login = $user->caqh_login ?? '';
        $this->caqh_password = $user->caqh_password ?? '';
        $this->pecos_login = $user->pecos_login ?? '';
        $this->pecos_password = $user->pecos_password ?? '';

        // Load doctor profile data
        if ($this->doctorProfile) {
            $this->editing = true;
            $this->status = $this->doctorProfile->status ?? 'active';
            $this->primary_specialty_id = $this->doctorProfile->primary_specialty_id ?? '';
            $this->experience_years = $this->doctorProfile->experience_years ?? '';
            $this->board_certified = $this->doctorProfile->board_certified ?? false;
            $this->board_certification_date = $this->doctorProfile->board_certification_date ?
                $this->doctorProfile->board_certification_date->format('Y-m-d') : '';
            $this->bio = $this->doctorProfile->bio ?? '';
        }
    }


    public function render()
    {
        return view('livewire.doctor.doctor-profile-component');
    }
}
