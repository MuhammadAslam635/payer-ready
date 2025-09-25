<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Dashboard\SuperAdminDashboardComponent;
use App\Livewire\Dashboard\OrganizationManagerDashboardComponent;
use App\Livewire\Dashboard\OrganizationStaffDashboardComponent;
use App\Livewire\Dashboard\CoordinatorDashboardComponent;
use App\Livewire\Dashboard\DoctorDashboardComponent;
use App\Livewire\SuperAdmin\Specialty\SpecialtyIndex;
use App\Livewire\SuperAdmin\State\StateIndex;
use App\Livewire\SuperAdmin\CertificateType\CertificateTypeIndex;
use App\Livewire\SuperAdmin\TaskType\TaskTypeIndex;
use App\Livewire\SuperAdmin\LicenseType\LicenseTypeIndex;
use App\Livewire\Doctor\MyTasksComponent;
use App\Livewire\Doctor\InviteProvidersComponent;
use App\Livewire\Doctor\ApplicationsComponent;
use App\Livewire\Doctor\DoctorProfileComponent;
use App\Livewire\Doctor\Application\PayerEnrollmentComponent;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/doctor-register', function () {
    return view('auth.doctor-register');
})->name('doctor-register');

Route::get('/organization-register', function () {
    return view('auth.organization-register');
})->name('organization-register');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'redirect',
])->group(function () {
    // General dashboard route that redirects to appropriate dashboard
    Route::get('/dashboard', function () {
        $user = Auth::user();
        switch ($user->user_type) {
            case \App\Enums\UserType::SUPER_ADMIN:
                return redirect()->route('super_admin.dashboard');
            case \App\Enums\UserType::ORGANIZATION_ADMIN:
                return redirect()->route('organization_admin.dashboard');
            // case \App\Enums\UserType::ORGANIZATION_STAFF:
            //     return redirect()->route('organization_staff.dashboard');
            case \App\Enums\UserType::COORDINATOR:
                return redirect()->route('coordinator.dashboard');
            case \App\Enums\UserType::DOCTOR:
                return redirect()->route('doctor.dashboard');
            default:
                return redirect()->route('doctor.dashboard');
        }
    })->name('dashboard');

    Route::get('/super-admin/dashboard', SuperAdminDashboardComponent::class)->name('super_admin.dashboard');
    Route::get('/organization-admin/dashboard', OrganizationManagerDashboardComponent::class)->name('organization_admin.dashboard');
    Route::get('/organization-staff/dashboard', OrganizationStaffDashboardComponent::class)->name('organization_staff.dashboard');
    Route::get('/coordinator/dashboard', CoordinatorDashboardComponent::class)->name('coordinator.dashboard');
    Route::get('/doctor/dashboard', DoctorDashboardComponent::class)->name('doctor.dashboard');


});
Route::middleware(['auth:sanctum',
    config('jetstream.auth_session'),
    'verified'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/specialties', SpecialtyIndex::class)->name('specialties.index');
    Route::get('/states', StateIndex::class)->name('states.index');
    Route::get('/certificate-types', CertificateTypeIndex::class)->name('certificate-types.index');
    Route::get('/task-types', TaskTypeIndex::class)->name('task-types.index');
    Route::get('/license-types', LicenseTypeIndex::class)->name('license-types.index');
});

    Route::prefix('organization')->group(function () {

    });
    // Route::prefix('organization-manager','as'=>'organization-manager.')->group(function () {
    // });
    // Route::prefix('organization-staff','as'=>'organization-staff.')->group(function () {
    // });
    // Route::prefix('coordinator','as'=>'coordinator.')->group(function () {
    // });
Route::group(['prefix' => 'doctor', 'as' => 'doctor.', 'middleware' => 'auth'],function () {
    Route::get('/tasks', MyTasksComponent::class)->name('tasks');
    Route::get('/invite-providers', InviteProvidersComponent::class)->name('invite-providers');
    Route::get('/licensing',ApplicationsComponent::class)->name('licensing');
    Route::get('/profile', DoctorProfileComponent::class)->name('profile');
    Route::get('/applications',PayerEnrollmentComponent::class)->name('applications');
});
