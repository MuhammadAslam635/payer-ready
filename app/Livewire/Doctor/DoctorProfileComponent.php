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
use App\Models\Address;
use App\Models\DoctorLicense;
use App\Models\DoctorCertificate;
use App\Models\Education;
use App\Models\Insurance;
use App\Models\LicenseType;
use App\Models\CertificateType;
use App\Models\DoctorDocument;
use App\Models\DocumentType;
use App\Notifications\DocumentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasToast;
use Livewire\WithFileUploads;

#[Title('Doctor Profile')]
#[Layout('layouts.dashboard')]
class DoctorProfileComponent extends Component
{
    use HasToast, WithFileUploads;

    public $editing = false;
    public $doctorProfile;
    public $specialties = [];
    public $showEditForm = false;
    public $activeTab = 'personal';
    
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
    
    // Password visibility toggles
    public $showNppesPassword = false;
    public $showCaqhPassword = false;
    public $showAvailityPassword = false;
    public $showPecosPassword = false;

    // Doctor Profile fields
    public $status = 'active';
    public $primary_specialty_id = '';
    public $experience_years = '';
    public $board_certified = false;
    public $board_certification_date = '';
    public $bio = '';
    public $dea_number = '';
    public $dea_issue_date = '';
    public $dea_expiry_date = '';
    
    // License form fields
    public $license_license_number = '';
    public $license_license_type_id = '';
    public $license_state_id = '';
    public $license_issue_date = '';
    public $license_expiry_date = '';
    
    // Certification form fields
    public $cert_certificate_number = '';
    public $cert_certificate_type_id = '';
    public $cert_issuing_organization = '';
    public $cert_issue_date = '';
    public $cert_expiry_date = '';

    // Address fields
    public $address = '';
    public $address_state_id = '';
    public $address_country = 'US';
    public $address_type = 'home';

    // Professional IDs - Licenses, Certifications, DEA
    public $licenses = [];
    public $certificates = [];
    public $licenseTypes = [];
    public $certificateTypes = [];

    // Educational Information
    public $educations = [];
    public $edu_institution_name = '';
    public $edu_degree = '';
    public $edu_completed_year = '';
    public $editingEducationId = null;

    // Specialties (multiple)
    public $selectedSpecialties = [];

    // Practice Location additional fields
    public $practice_tax_id = '';
    public $practice_office_phone = '';
    public $practice_office_fax = '';

    // Professional Liability Insurance
    public $insurance_carrier = '';
    public $insurance_policy_number = '';
    public $insurance_coverage_amount_per_occurrence = '';
    public $insurance_coverage_amount_aggregate = '';
    public $insurance_policy_effective_date = '';
    public $insurance_policy_expiration_date = '';

    // Document Upload
    public $showUploadModal = false;
    public $showEditModal = false;
    public $selectedDocumentType = '';
    public $documentFile;
    public $notes = '';
    public $editingDocument = null;
    public $editNotes = '';
    public $documents = [];

    public function mount()
    {
        $this->loadProfile();
        $this->specialties = Specialty::orderBy('name')->get();
        $this->states = State::orderBy('name')->get();
        $this->licenseTypes = LicenseType::orderBy('name')->get();
        $this->certificateTypes = CertificateType::orderBy('name')->get();
        $this->loadPracticeLocations();
        $this->loadAddress();
        $this->loadLicenses();
        $this->loadCertificates();
        $this->loadEducations();
        $this->loadInsurance();
        $this->loadSpecialties();
        $this->loadDocuments();
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
            $this->dea_number = $this->doctorProfile->dea_number ?? '';
            $this->dea_issue_date = $this->doctorProfile->dea_issue_date ? 
                $this->doctorProfile->dea_issue_date->format('Y-m-d') : '';
            $this->dea_expiry_date = $this->doctorProfile->dea_expiry_date ? 
                $this->doctorProfile->dea_expiry_date->format('Y-m-d') : '';
        }
    }

    public function loadAddress()
    {
        $user = Auth::user();
        $primaryAddress = $user->addresses()->where('is_primary', true)->first();
        if ($primaryAddress) {
            $this->address = $primaryAddress->address ?? '';
            $this->address_state_id = $primaryAddress->state_id ?? '';
            $this->address_country = $primaryAddress->country ?? 'US';
            $this->address_type = $primaryAddress->address_type ?? 'home';
        }
    }

    public function loadLicenses()
    {
        $this->licenses = DoctorLicense::where('user_id', Auth::id())
            ->with(['state', 'licenseType'])
            ->orderBy('expiration_date', 'desc')
            ->get();
    }

    public function loadCertificates()
    {
        $this->certificates = DoctorCertificate::where('user_id', Auth::id())
            ->with('certificateType')
            ->orderBy('expiration_date', 'desc')
            ->get();
    }

    public function loadEducations()
    {
        $this->educations = Education::where('user_id', Auth::id())
            ->orderBy('completed_year', 'desc')
            ->get();
    }

    public function loadInsurance()
    {
        $insurance = Insurance::where('user_id', Auth::id())->first();
        if ($insurance) {
            $this->insurance_carrier = $insurance->carrier ?? '';
            $this->insurance_policy_number = $insurance->policy_number ?? '';
            $this->insurance_coverage_amount_per_occurrence = $insurance->coverage_amount ?? '';
            $this->insurance_coverage_amount_aggregate = $insurance->coverage_amount ?? '';
            $this->insurance_policy_effective_date = $insurance->policy_effective_date ? 
                $insurance->policy_effective_date->format('Y-m-d') : '';
            $this->insurance_policy_expiration_date = $insurance->policy_expiration_date ? 
                $insurance->policy_expiration_date->format('Y-m-d') : '';
        }
    }

    public function loadSpecialties()
    {
        $user = Auth::user();
        $this->selectedSpecialties = $user->specialties()->pluck('specialties.id')->toArray();
    }

    public function loadDocuments()
    {
        $this->documents = DoctorDocument::with('documentType')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function openUploadModal()
    {
        $this->showUploadModal = true;
        $this->reset(['selectedDocumentType', 'documentFile', 'notes']);
    }

    public function closeUploadModal()
    {
        $this->showUploadModal = false;
        $this->reset(['selectedDocumentType', 'documentFile', 'notes']);
        $this->resetErrorBag();
    }

    public function openEditModal($documentId)
    {
        $this->editingDocument = DoctorDocument::find($documentId);
        if ($this->editingDocument && $this->editingDocument->user_id === Auth::id()) {
            $this->editNotes = $this->editingDocument->notes ?? '';
            $this->showEditModal = true;
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingDocument = null;
        $this->editNotes = '';
        $this->resetErrorBag();
    }

    public function uploadDocument()
    {
        $this->validate([
            'selectedDocumentType' => 'required|exists:document_types,id',
            'documentFile' => 'required|file|max:10240', // 10MB max
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $documentType = DocumentType::find($this->selectedDocumentType);
            
            // Generate unique filename
            $originalFilename = $this->documentFile->getClientOriginalName();
            $extension = $this->documentFile->getClientOriginalExtension();
            $storedFilename = time() . '_' . uniqid() . '.' . $extension;
            
            // Store file
            $filePath = $this->documentFile->storeAs('doctor-documents', $storedFilename, 'public');
            
            // Create document record
            $document = DoctorDocument::create([
                'user_id' => Auth::id(),
                'document_type_id' => $this->selectedDocumentType,
                'original_filename' => $originalFilename,
                'stored_filename' => $storedFilename,
                'file_path' => $filePath,
                'file_size_bytes' => $this->documentFile->getSize(),
                'mime_type' => $this->documentFile->getMimeType(),
                'file_hash' => hash_file('sha256', $this->documentFile->path()),
                'upload_date' => now(),
                'is_verified' => false,
                'is_current' => true,
                'notes' => $this->notes,
            ]);

            // Send notification
            Auth::user()->notify(new DocumentNotification($document, 'uploaded'));

            $this->toastSuccess('Document uploaded successfully!');
            $this->closeUploadModal();
            $this->loadDocuments();
            
            // Emit event to refresh notifications
            $this->dispatch('refresh-notifications');
            
        } catch (\Exception $e) {
            $this->toastError('Failed to upload document: ' . $e->getMessage());
        }
    }

    public function updateDocument()
    {
        $this->validate([
            'editNotes' => 'nullable|string|max:1000',
        ]);

        try {
            if ($this->editingDocument && $this->editingDocument->user_id === Auth::id()) {
                $this->editingDocument->update([
                    'notes' => $this->editNotes,
                ]);

                $this->toastSuccess('Document updated successfully!');
                $this->closeEditModal();
                $this->loadDocuments();
            }
        } catch (\Exception $e) {
            $this->toastError('Failed to update document: ' . $e->getMessage());
        }
    }

    public function deleteDocument($documentId)
    {
        try {
            $document = DoctorDocument::find($documentId);
            if ($document && $document->user_id === Auth::id()) {
                // Delete file from storage
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }
                
                $document->delete();
                $this->toastSuccess('Document deleted successfully!');
                $this->loadDocuments();
            }
        } catch (\Exception $e) {
            $this->toastError('Failed to delete document: ' . $e->getMessage());
        }
    }

    public function downloadDocument($documentId)
    {
        try {
            $document = DoctorDocument::find($documentId);
            if ($document && $document->user_id === Auth::id()) {
                if (Storage::disk('public')->exists($document->file_path)) {
                    return Storage::disk('public')->download($document->file_path, $document->original_filename);
                }
            }
            
            $this->toastError('File not found!');
        } catch (\Exception $e) {
            $this->toastError('Failed to download document: ' . $e->getMessage());
        }
    }

    public function formatFileSize($bytes)
    {
        if ($bytes === 0) return '0 Bytes';
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
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
        $this->practice_tax_id = '';
        $this->practice_office_phone = '';
        $this->practice_office_fax = '';
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
        $this->practice_tax_id = $practice->tax_id ?? '';
        $this->practice_office_phone = $practice->office_phone ?? '';
        $this->practice_office_fax = $practice->office_fax ?? '';
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
            'practice_tax_id' => 'nullable|string|max:50',
            'practice_office_phone' => 'nullable|string|max:20',
            'practice_office_fax' => 'nullable|string|max:20',
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
                'tax_id' => $this->practice_tax_id,
                'office_phone' => $this->practice_office_phone,
                'office_fax' => $this->practice_office_fax,
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
            'address' => 'nullable|string|max:500',
            'address_state_id' => 'nullable|exists:states,id',
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
            ]);

            // Update or create address
            if ($this->address) {
                $primaryAddress = $user->addresses()->where('is_primary', true)->first();
                if ($primaryAddress) {
                    $primaryAddress->update([
                        'address' => $this->address,
                        'state_id' => $this->address_state_id,
                        'country' => $this->address_country,
                        'address_type' => $this->address_type,
                    ]);
                } else {
                    // Unmark all other addresses as primary
                    $user->addresses()->update(['is_primary' => false]);
                    
                    Address::create([
                        'user_id' => $user->id,
                        'address' => $this->address,
                        'state_id' => $this->address_state_id,
                        'country' => $this->address_country,
                        'address_type' => $this->address_type,
                        'is_primary' => true,
                    ]);
                }
            }

            // Update DEA in doctor profile
            if ($this->doctorProfile) {
                $this->doctorProfile->update([
                    'dea_number' => $this->dea_number,
                    'dea_issue_date' => $this->dea_issue_date ?: null,
                    'dea_expiry_date' => $this->dea_expiry_date ?: null,
                ]);
            } else {
                DoctorProfile::create([
                    'user_id' => Auth::id(),
                    'dea_number' => $this->dea_number,
                    'dea_issue_date' => $this->dea_issue_date ?: null,
                    'dea_expiry_date' => $this->dea_expiry_date ?: null,
                    'status' => 'active',
                ]);
            }

            $this->toastSuccess('Information saved successfully');
            $this->loadProfile();
            $this->loadAddress();
        } catch (\Exception $e) {
            $this->toastError('Failed to save information: ' . $e->getMessage());
        }
    }

    public function saveSpecialty()
    {
        $this->validate([
            'primary_specialty_id' => 'required|exists:specialties,id',
            'taxonomy_code' => 'required|string|max:50',
            'selectedSpecialties' => 'nullable|array',
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

            // Sync specialties
            if (!empty($this->selectedSpecialties)) {
                $user->specialties()->sync($this->selectedSpecialties);
            }

            $this->toastSuccess('Specialty and taxonomy code saved successfully');
            $this->loadProfile();
            $this->loadSpecialties();
        } catch (\Exception $e) {
            $this->toastError('Failed to save specialty: ' . $e->getMessage());
        }
    }

    public function saveInsurance()
    {
        $this->validate([
            'insurance_carrier' => 'nullable|string|max:255',
            'insurance_policy_number' => 'nullable|string|max:100',
            'insurance_coverage_amount_per_occurrence' => 'nullable|numeric|min:0',
            'insurance_coverage_amount_aggregate' => 'nullable|numeric|min:0',
            'insurance_policy_effective_date' => 'nullable|date',
            'insurance_policy_expiration_date' => 'nullable|date|after:insurance_policy_effective_date',
        ]);

        try {
            $user = Auth::user();
            $insurance = Insurance::where('user_id', $user->id)->first();
            
            $data = [
                'user_id' => $user->id,
                'carrier' => $this->insurance_carrier,
                'policy_number' => $this->insurance_policy_number,
                'coverage_amount' => $this->insurance_coverage_amount_per_occurrence,
                'policy_effective_date' => $this->insurance_policy_effective_date,
                'policy_expiration_date' => $this->insurance_policy_expiration_date,
                'status' => 'approved', // Using 'approved' as it's a valid enum value for active insurance
            ];

            if ($insurance) {
                $insurance->update($data);
            } else {
                Insurance::create($data);
            }

            $this->toastSuccess('Insurance information saved successfully');
            $this->loadInsurance();
        } catch (\Exception $e) {
            $this->toastError('Failed to save insurance: ' . $e->getMessage());
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

    public function saveDEAInfo()
    {
        $this->validate([
            'dea_number' => 'nullable|string|max:50',
            'dea_issue_date' => 'nullable|date',
            'dea_expiry_date' => 'nullable|date|after:dea_issue_date',
        ]);

        try {
            if ($this->doctorProfile) {
                $this->doctorProfile->update([
                    'dea_number' => $this->dea_number,
                    'dea_issue_date' => $this->dea_issue_date ?: null,
                    'dea_expiry_date' => $this->dea_expiry_date ?: null,
                ]);
            } else {
                DoctorProfile::create([
                    'user_id' => Auth::id(),
                    'dea_number' => $this->dea_number,
                    'dea_issue_date' => $this->dea_issue_date ?: null,
                    'dea_expiry_date' => $this->dea_expiry_date ?: null,
                    'status' => 'active',
                ]);
                $this->loadProfile();
            }

            $this->toastSuccess('DEA information saved successfully');
            $this->loadProfile();
        } catch (\Exception $e) {
            $this->toastError('Failed to save DEA information: ' . $e->getMessage());
        }
    }

    public function saveLicense()
    {
        $this->validate([
            'license_license_number' => 'required|string|max:255',
            'license_license_type_id' => 'required|exists:license_types,id',
            'license_state_id' => 'required|exists:states,id',
            'license_issue_date' => 'required|date',
            'license_expiry_date' => 'required|date|after:license_issue_date',
        ]);

        try {
            DoctorLicense::create([
                'user_id' => Auth::id(),
                'license_type_id' => $this->license_license_type_id,
                'state_id' => $this->license_state_id,
                'license_number' => $this->license_license_number,
                'issue_date' => $this->license_issue_date,
                'expiration_date' => $this->license_expiry_date,
                'status' => \App\Enums\LicenseStatus::ACTIVE,
            ]);

            $this->toastSuccess('License added successfully');
            $this->resetLicenseForm();
            $this->loadLicenses();
        } catch (\Exception $e) {
            $this->toastError('Failed to add license: ' . $e->getMessage());
        }
    }

    public function resetLicenseForm()
    {
        $this->license_license_number = '';
        $this->license_license_type_id = '';
        $this->license_state_id = '';
        $this->license_issue_date = '';
        $this->license_expiry_date = '';
        $this->resetValidation();
    }

    public function saveCertification()
    {
        $this->validate([
            'cert_certificate_number' => 'required|string|max:255',
            'cert_certificate_type_id' => 'required|exists:certificate_types,id',
            'cert_issuing_organization' => 'required|string|max:255',
            'cert_issue_date' => 'required|date',
            'cert_expiry_date' => 'required|date|after:cert_issue_date',
        ]);

        try {
            $certificateType = CertificateType::find($this->cert_certificate_type_id);
            
            DoctorCertificate::create([
                'user_id' => Auth::id(),
                'certificate_type_id' => $this->cert_certificate_type_id,
                'certificate_name' => $certificateType->name ?? 'Certificate',
                'certificate_number' => $this->cert_certificate_number,
                'issuing_organization' => $this->cert_issuing_organization,
                'issue_date' => $this->cert_issue_date,
                'expiration_date' => $this->cert_expiry_date,
                'is_current' => true,
            ]);

            $this->toastSuccess('Certification added successfully');
            $this->resetCertificationForm();
            $this->loadCertificates();
        } catch (\Exception $e) {
            $this->toastError('Failed to add certification: ' . $e->getMessage());
        }
    }

    public function resetCertificationForm()
    {
        $this->cert_certificate_number = '';
        $this->cert_certificate_type_id = '';
        $this->cert_issuing_organization = '';
        $this->cert_issue_date = '';
        $this->cert_expiry_date = '';
        $this->resetValidation();
    }

    public function saveEducation()
    {
        $this->validate([
            'edu_institution_name' => 'required|string|max:255',
            'edu_degree' => 'required|string|max:100',
            'edu_completed_year' => 'required|date',
        ]);

        try {
            // Extract year from date
            $completedYear = $this->edu_completed_year ? date('Y', strtotime($this->edu_completed_year)) : null;

            if ($this->editingEducationId) {
                $education = Education::findOrFail($this->editingEducationId);
                if ($education->user_id !== Auth::id()) {
                    $this->toastError('Unauthorized access');
                    return;
                }
                $education->update([
                    'institution_name' => $this->edu_institution_name,
                    'degree' => $this->edu_degree,
                    'completed_year' => $completedYear,
                ]);
                $this->toastSuccess('Educational information updated successfully');
            } else {
                Education::create([
                    'user_id' => Auth::id(),
                    'institution_name' => $this->edu_institution_name,
                    'degree' => $this->edu_degree,
                    'completed_year' => $completedYear,
                ]);
                $this->toastSuccess('Educational information added successfully');
            }

            $this->resetEducationForm();
            $this->loadEducations();
        } catch (\Exception $e) {
            $this->toastError('Failed to save educational information: ' . $e->getMessage());
        }
    }

    public function editEducation($educationId)
    {
        try {
            $education = Education::findOrFail($educationId);
            if ($education->user_id !== Auth::id()) {
                $this->toastError('Unauthorized access');
                return;
            }

            $this->editingEducationId = $education->id;
            $this->edu_institution_name = $education->institution_name;
            $this->edu_degree = $education->degree;
            // Convert year to date format (first day of the year)
            $this->edu_completed_year = $education->completed_year ? $education->completed_year . '-01-01' : '';
        } catch (\Exception $e) {
            $this->toastError('Failed to load education: ' . $e->getMessage());
        }
    }

    public function deleteEducation($educationId)
    {
        try {
            $education = Education::findOrFail($educationId);
            if ($education->user_id !== Auth::id()) {
                $this->toastError('Unauthorized access');
                return;
            }

            $education->delete();
            $this->toastSuccess('Educational information deleted successfully');
            $this->loadEducations();
        } catch (\Exception $e) {
            $this->toastError('Failed to delete educational information: ' . $e->getMessage());
        }
    }

    public function resetEducationForm()
    {
        $this->editingEducationId = null;
        $this->edu_institution_name = '';
        $this->edu_degree = '';
        $this->edu_completed_year = '';
        $this->resetValidation();
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

    public function getDocumentTypesProperty()
    {
        return DocumentType::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.doctor.doctor-profile-component', [
            'providerTypes' => $this->providerTypes,
            'documentTypes' => $this->documentTypes,
        ]);
    }
}
