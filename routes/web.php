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
use App\Livewire\SuperAdmin\Payer\PayerIndexComponent;
use App\Livewire\Doctor\MyTasksComponent;
use App\Livewire\Doctor\InviteProvidersComponent;
use App\Livewire\Doctor\ApplicationsComponent;
use App\Livewire\Doctor\DoctorProfileComponent;
use App\Livewire\Doctor\Application\PayerEnrollmentComponent;
use App\Livewire\SuperAdmin\Invoice\AllInvoicesComponent;
use App\Livewire\SuperAdmin\PaymentGateway\AllPayemntGatewaysComponent;
// Notification Components
use App\Livewire\Doctor\DoctorNotificationComponent;
use App\Livewire\Doctor\SupportsTickets\AllSupportTicketsComponent;
use App\Livewire\Doctor\SupportsTickets\ChatSupportTicketComponent;
use App\Livewire\Doctor\SupportsTickets\CreateSupportTicketComponent;
use App\Livewire\Organization\OrganizationNotificationComponent;
use App\Livewire\SuperAdmin\Certificate\AllCertificateComponent;
use App\Livewire\SuperAdmin\Credentials\SuperAdminCredentialsComponent;
use App\Livewire\SuperAdmin\Invoice\CreateInvoiceComponent;
use App\Livewire\SuperAdmin\License\SuperAdminViewAllLicenseComponent;
use App\Livewire\SuperAdmin\SuperAdminNotificationComponent;
use App\Livewire\SuperAdmin\Tasks\AllTaskComponent;
use App\Livewire\SuperAdmin\TaskType\TaskDetailComponent;
use App\Livewire\SuperAdmin\Tickets\AdminViewAllTicketsComponent;
use App\Livewire\SuperAdmin\Transactions\AllInvoiceComponent;
use App\Livewire\SuperAdmin\Tickets\TicketChatComponent;
use App\Livewire\SuperAdmin\Transactions\AllTransactionComponent;
use App\Livewire\SuperAdmin\User\AdminCreateUserComponent;
use App\Livewire\SuperAdmin\User\AdminViewAllUsersComponent;

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
    Route::get('/task-detail/{taskType}', TaskDetailComponent::class)->name('task-detail');
    Route::get('/license-types', LicenseTypeIndex::class)->name('license-types.index');
    Route::get('/payers',PayerIndexComponent::class)->name('payers.index');
    Route::get('/sub/users',AdminCreateUserComponent::class)->name('sub_users');
    Route::get('users',AdminViewAllUsersComponent::class)->name('users');
    Route::get("/support-tickets",AdminViewAllTicketsComponent::class)->name('support-tickets');
    Route::get('/chat/{supportTicketId}',TicketChatComponent::class)->name('chat');
    Route::get('/all-invoices',AllInvoicesComponent::class)->name('all_invoices');
    Route::get('/create-invoice',CreateInvoiceComponent::class)->name('create_invoice');
    Route::get('/payment-gateways',AllPayemntGatewaysComponent::class)->name('all_payment_gateways');
    Route::get('notifications',SuperAdminNotificationComponent::class)->name('notifications');
    Route::get('/all-license',SuperAdminViewAllLicenseComponent::class)->name('view_all_license');
    Route::get('/all-credentials',SuperAdminCredentialsComponent::class)->name('view_all_credentials');
    Route::get('/all-transactions',AllTransactionComponent::class)->name('all_transactions');
    Route::get('/all-certificates',AllCertificateComponent::class)->name('all_certificates');
    Route::get('/all-tasks',AllTaskComponent::class)->name('all_tasks');
});

    Route::prefix('organization')->group(function () {

    });

Route::group(['prefix' => 'organization-admin', 'as' => 'organization-admin.', 'middleware' => 'auth'],function () {
    Route::get('/notifications',OrganizationNotificationComponent::class)->name('notifications');
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
    Route::get('/notifications',DoctorNotificationComponent::class)->name('notifications');
    Route::get('/support-tickets',AllSupportTicketsComponent::class)->name('all_support_tickets');
    Route::get('create/support-ticket',CreateSupportTicketComponent::class)->name('create_support_ticket');
    Route::get('chat/{supportTicketId}',ChatSupportTicketComponent::class)->name('chat_support_tickets');
});
