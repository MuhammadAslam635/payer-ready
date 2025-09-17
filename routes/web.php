<?php

use Illuminate\Support\Facades\Route;
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
    Route::get('/super-admin/dashboard', SuperAdminDashboardComponent::class)->name('super_admin.dashboard');
    Route::get('/organization-admin/dashboard', OrganizationManagerDashboardComponent::class)->name('organization_admin.dashboard');
    Route::get('/organization-staff/dashboard', OrganizationStaffDashboardComponent::class)->name('organization_staff.dashboard');
    Route::get('/coordinator/dashboard', CoordinatorDashboardComponent::class)->name('coordinator.dashboard');
    Route::get('/doctor/dashboard', DoctorDashboardComponent::class)->name('doctor.dashboard');
    Route::prefix('super-admin')->group(function () {
        Route::get('/specialties', SpecialtyIndex::class)->name('super-admin.specialties.index');
        Route::get('/states', StateIndex::class)->name('super-admin.states.index');
        Route::get('/certificate-types', CertificateTypeIndex::class)->name('super-admin.certificate-types.index');
        Route::get('/task-types', TaskTypeIndex::class)->name('super-admin.task-types.index');
        Route::get('/license-types', LicenseTypeIndex::class)->name('super-admin.license-types.index');
    });
});
