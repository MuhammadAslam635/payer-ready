<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\DoctorProfile;
use App\Models\Specialty;
use App\Models\User;
use App\Models\PracticeLocation;
use App\Models\State;
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
    public $activeTab = 'information';
    
    // Practice Location Modal
    public $showPracticeModal = false;
    public $editingPracticeId = null;
    public $practiceLocations = [];
    public $states = [];
    
    // Practice Location Form
    public $practice_name = '';
    public $practice_address_line_1 = '';
    public $practice_address_line_2 = '';
    public $practice_city = '';
    public $practice_state = '';
    public $practice_zip_code = '';
    public $practice_country = 'US';
    public $practice_specialty = '';
    public $practice_npi_type_1 = '';
    public $practice_npi_type_2 = '';
    public $is_primary_location = false;

    // Form fields - User table fields
    public $name = '';
    public $email = '';
    public $phone = '';
    public $fax_number = '';
    public $date_of_birth = '';
    public $is_active = true;
    public $npi_number = '';
    public $provider_type = '';
    public $ssn_encrypted = '';
    public $taxonomy_code = '';
    public $caqh_id = '';
    public $caqh_login = '';
    public $caqh_password = '';
    public $pecos_login = '';
    public $pecos_password = '';
    public $nppes_login = '';
    public $nppes_password = '';
    public $availity_login = '';
    public $availity_password = '';

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
        $this->states = State::orderBy('name')->get();
        $this->loadPracticeLocations();
    }

    public function loadProfile()
    {
        $user = Auth::user();
        $this->doctorProfile = $user->doctorProfile;

        // Load user data
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->phone = $user->phone ?? '';
        $this->fax_number = $user->fax_number ?? '';
        $this->date_of_birth = $user->date_of_birth;
        $this->is_active = $user->is_active ?? true;
        $this->npi_number = $user->npi_number ?? '';
        $this->provider_type = $user->provider_type ?? '';
        $this->ssn_encrypted = $user->ssn_encrypted ?? '';
        $this->taxonomy_code = $user->taxonomy_code ?? '';
        $this->caqh_id = $user->caqh_id ?? '';
        $this->caqh_login = $user->caqh_login ?? '';
        $this->caqh_password = $user->caqh_password ?? '';
        $this->pecos_login = $user->pecos_login ?? '';
        $this->pecos_password = $user->pecos_password ?? '';
        $this->nppes_login = $user->nppes_login ?? '';
        $this->nppes_password = $user->nppes_password ?? '';
        $this->availity_login = $user->availity_login ?? '';
        $this->availity_password = $user->availity_password ?? '';

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


    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function loadPracticeLocations()
    {
        $this->practiceLocations = PracticeLocation::where('user_id', Auth::id())
            ->orderBy('is_primary', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function openPracticeModal()
    {
        $this->resetPracticeForm();
        $this->showPracticeModal = true;
    }

    public function closePracticeModal()
    {
        $this->showPracticeModal = false;
        $this->resetPracticeForm();
    }

    public function resetPracticeForm()
    {
        $this->editingPracticeId = null;
        $this->practice_name = '';
        $this->practice_address_line_1 = '';
        $this->practice_address_line_2 = '';
        $this->practice_city = '';
        $this->practice_state = '';
        $this->practice_zip_code = '';
        $this->practice_country = 'US';
        $this->practice_specialty = '';
        $this->practice_npi_type_1 = '';
        $this->practice_npi_type_2 = '';
        $this->is_primary_location = false;
        $this->resetValidation();
    }

    public function editPracticeLocation($id)
    {
        $practice = PracticeLocation::findOrFail($id);
        
        if ($practice->user_id !== Auth::id()) {
            $this->toastError('Unauthorized access');
            return;
        }

        $this->editingPracticeId = $practice->id;
        $this->practice_name = $practice->practice_name;
        $this->practice_address_line_1 = $practice->address_line_1;
        $this->practice_address_line_2 = $practice->address_line_2 ?? '';
        $this->practice_city = $practice->city;
        $this->practice_state = $practice->state;
        $this->practice_zip_code = $practice->zip_code;
        $this->practice_country = $practice->country ?? 'US';
        $this->practice_specialty = $practice->specialty;
        $this->practice_npi_type_1 = $practice->npi_type_1 ?? '';
        $this->practice_npi_type_2 = $practice->npi_type_2 ?? '';
        $this->is_primary_location = $practice->is_primary;

        $this->showPracticeModal = true;
    }

    public function savePracticeLocation()
    {
        $this->validate([
            'practice_name' => 'required|string|max:255',
            'practice_address_line_1' => 'required|string|max:255',
            'practice_address_line_2' => 'nullable|string|max:255',
            'practice_city' => 'required|string|max:100',
            'practice_state' => 'required|string|max:100',
            'practice_zip_code' => 'required|string|max:20',
            'practice_country' => 'required|string|max:2',
            'practice_specialty' => 'required|string|max:255',
            'practice_npi_type_1' => 'nullable|string|max:50',
            'practice_npi_type_2' => 'nullable|string|max:50',
            'is_primary_location' => 'boolean',
        ]);

        try {
            $data = [
                'user_id' => Auth::id(),
                'practice_name' => $this->practice_name,
                'address_line_1' => $this->practice_address_line_1,
                'address_line_2' => $this->practice_address_line_2,
                'city' => $this->practice_city,
                'state' => $this->practice_state,
                'zip_code' => $this->practice_zip_code,
                'country' => $this->practice_country,
                'specialty' => $this->practice_specialty,
                'npi_type_1' => $this->practice_npi_type_1,
                'npi_type_2' => $this->practice_npi_type_2,
                'is_primary' => $this->is_primary_location,
            ];

            if ($this->editingPracticeId) {
                $practice = PracticeLocation::findOrFail($this->editingPracticeId);
                $practice->update($data);
                $this->toastSuccess('Practice location updated successfully');
            } else {
                // If this is marked as primary, unmark all others
                if ($this->is_primary_location) {
                    PracticeLocation::where('user_id', Auth::id())
                        ->update(['is_primary' => false]);
                }
                
                PracticeLocation::create($data);
                $this->toastSuccess('Practice location added successfully');
            }

            $this->loadPracticeLocations();
            $this->closePracticeModal();
        } catch (\Exception $e) {
            $this->toastError('Failed to save practice location: ' . $e->getMessage());
        }
    }

    public function deletePracticeLocation($id)
    {
        try {
            $practice = PracticeLocation::findOrFail($id);
            
            if ($practice->user_id !== Auth::id()) {
                $this->toastError('Unauthorized access');
                return;
            }

            $practice->delete();
            $this->toastSuccess('Practice location deleted successfully');
            $this->loadPracticeLocations();
        } catch (\Exception $e) {
            $this->toastError('Failed to delete practice location: ' . $e->getMessage());
        }
    }

    public function saveInformation()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'npi_number' => 'required|string|max:50',
            'provider_type' => 'required|string',
        ]);

        try {
            $user = Auth::user();
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'fax_number' => $this->fax_number,
                'date_of_birth' => $this->date_of_birth,
                'npi_number' => $this->npi_number,
                'provider_type' => $this->provider_type,
                'ssn_encrypted' => $this->ssn_encrypted,
                'is_active' => $this->is_active,
            ]);

            $this->toastSuccess('Information saved successfully');
        } catch (\Exception $e) {
            $this->toastError('Failed to save information: ' . $e->getMessage());
        }
    }

    public function saveSpecialty()
    {
        $this->validate([
            'primary_specialty_id' => 'required|exists:specialties,id',
            'taxonomy_code' => 'required|string|max:50',
        ]);

        try {
            $user = Auth::user();
            $user->update([
                'taxonomy_code' => $this->taxonomy_code,
            ]);

            // Update or create doctor profile
            if ($this->doctorProfile) {
                $this->doctorProfile->update([
                    'primary_specialty_id' => $this->primary_specialty_id,
                ]);
            } else {
                DoctorProfile::create([
                    'user_id' => Auth::id(),
                    'primary_specialty_id' => $this->primary_specialty_id,
                    'status' => 'active',
                ]);
            }

            $this->toastSuccess('Specialty and taxonomy code saved successfully');
            $this->loadProfile();
        } catch (\Exception $e) {
            $this->toastError('Failed to save specialty: ' . $e->getMessage());
        }
    }

    public function savePortalLogins()
    {
        try {
            $user = Auth::user();
            $user->update([
                'nppes_login' => $this->nppes_login,
                'nppes_password' => $this->nppes_password,
                'caqh_id' => $this->caqh_id,
                'caqh_login' => $this->caqh_login,
                'caqh_password' => $this->caqh_password,
                'availity_login' => $this->availity_login,
                'availity_password' => $this->availity_password,
                'pecos_login' => $this->pecos_login,
                'pecos_password' => $this->pecos_password,
            ]);

            $this->toastSuccess('Portal logins saved successfully');
        } catch (\Exception $e) {
            $this->toastError('Failed to save portal logins: ' . $e->getMessage());
        }
    }

    public function getProviderTypesProperty()
    {
        return [
            'MD' => 'Medical Doctor (MD)',
            'DO' => 'Doctor of Osteopathic Medicine (DO)',
            'NP' => 'Nurse Practitioner (NP)',
            'PA' => 'Physician Assistant (PA)',
            'ABA' => 'Applied Behavior Analysis (ABA)',
            'RN' => 'Registered Nurse (RN)',
            'LPN' => 'Licensed Practical Nurse (LPN)',
            'PT' => 'Physical Therapist (PT)',
            'OT' => 'Occupational Therapist (OT)',
            'ST' => 'Speech Therapist (ST)',
            'PSY' => 'Psychologist (PSY)',
            'LCSW' => 'Licensed Clinical Social Worker (LCSW)',
            'LMFT' => 'Licensed Marriage and Family Therapist (LMFT)',
            'LPC' => 'Licensed Professional Counselor (LPC)',
        ];
    }

    public function render()
    {
        return view('livewire.doctor.doctor-profile-component', [
            'providerTypes' => $this->providerTypes,
        ]);
    }
}
