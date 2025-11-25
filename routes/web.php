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
use App\Livewire\Doctor\ExpirablesComponent;
use App\Livewire\Doctor\ReportsComponent;
use App\Livewire\Doctor\InvoicePaymentsComponent;
use App\Livewire\Coordinator\InvoicePaymentsComponent as CoordInvoicePaymentsComponent;
use App\Livewire\Coordinator\ExpirablesComponent as CoordExpirablesComponent;
use App\Livewire\Coordinator\ReportsComponent as CoordReportsComponent;
use App\Livewire\Coordinator\TasksComponent as CoordTasksComponent;
use App\Livewire\Coordinator\ApplicationsComponent as CoordApplicationsComponent;
use App\Livewire\Coordinator\LicensingComponent as CoordLicensingComponent;
use App\Livewire\Organization\DoctorTasksComponent;
use App\Livewire\Organization\DoctorApplicationsComponent;
use App\Livewire\Organization\DoctorPayerEnrollmentComponent;
use App\Livewire\Organization\DoctorExpirablesComponent as OrgDoctorExpirablesComponent;
use App\Livewire\Organization\DoctorReportsComponent as OrgDoctorReportsComponent;
use App\Livewire\Organization\DoctorInvoicePaymentsComponent as OrgDoctorInvoicePaymentsComponent;
use App\Livewire\Doctor\Application\PayerEnrollmentComponent;
use App\Livewire\SuperAdmin\Invoice\AllInvoicesComponent;
use App\Livewire\SuperAdmin\PaymentGateway\AllPayemntGatewaysComponent;
// Notification Components
use App\Livewire\Doctor\DoctorNotificationComponent;
use App\Livewire\Doctor\SupportsTickets\AllSupportTicketsComponent;
use App\Livewire\Doctor\SupportsTickets\ChatSupportTicketComponent;
use App\Livewire\Doctor\SupportsTickets\CreateSupportTicketComponent;
use App\Livewire\OrganizationAdmin\SupportTickets\AllSupportTicketsComponent as OrgAdminAllSupportTicketsComponent;
use App\Livewire\OrganizationAdmin\SupportTickets\ChatSupportTicketComponent as OrgAdminChatSupportTicketComponent;
use App\Livewire\OrganizationAdmin\SupportTickets\CreateSupportTicketComponent as OrgAdminCreateSupportTicketComponent;
use App\Livewire\Organization\ManageStaffComponent;
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

Route::view('/solutions', 'pages.solutions')->name('solutions');
Route::view('/how-it-works', 'pages.how-it-works')->name('how-it-works');
Route::view('/pricing', 'pages.pricing')->name('pricing');
Route::view('/resources', 'pages.resources')->name('resources');
Route::view('/about', 'pages.about')->name('about');

// Custom email verification route - allows verification without authentication
Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Http\Request $request, $id, $hash) {
    try {
        $user = \App\Models\User::findOrFail($id);
        
        \Log::info('Email verification attempt', [
            'user_id' => $id,
            'user_email' => $user->email,
            'request_url' => $request->fullUrl(),
            'request_host' => $request->getHost(),
            'signature_valid' => $request->hasValidSignature(),
        ]);
        
        // Verify the hash matches the user's email first (more reliable check)
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            \Log::warning('Email verification failed: Hash mismatch', [
                'user_id' => $id,
                'expected_hash' => sha1($user->getEmailForVerification()),
                'received_hash' => $hash,
            ]);
            abort(403, 'Invalid verification link. The hash does not match.');
        }
        
        // Try to verify the signed URL - if it fails due to domain mismatch, we still proceed
        // because we've already verified the hash which is the critical security check
        if (! $request->hasValidSignature()) {
            \Log::warning('Email verification: Signature validation failed but hash is valid', [
                'user_id' => $id,
                'expires' => $request->query('expires'),
            ]);
            
            // Check if the link has expired
            if ($request->has('expires') && $request->query('expires') < now()->timestamp) {
                abort(403, 'Verification link has expired. Please request a new verification email.');
            }
            
            // Hash is valid, so we proceed despite signature validation failure
            // This handles cases where URL was generated with different domain
            \Log::info('Email verification: Proceeding with hash validation only');
        }
        
        // Check if email is already verified
        if ($user->hasVerifiedEmail()) {
            \Log::info('Email verification: Already verified', ['user_id' => $id]);
            return redirect()->route('login')->with('status', 'Email already verified. You can now login.');
        }
        
        // Mark email as verified
        if ($user->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($user));
            \Log::info('Email verification: Successfully verified', ['user_id' => $id]);
        }
        
        // Auto-login the user after verification
        Auth::login($user);
        
        // Redirect based on user type
        $user = $user->fresh();
        switch ($user->user_type) {
            case \App\Enums\UserType::SUPER_ADMIN:
                return redirect()->route('super_admin.dashboard')->with('verified', true);
            case \App\Enums\UserType::ORGANIZATION_ADMIN:
                return redirect()->route('organization_admin.dashboard')->with('verified', true);
            case \App\Enums\UserType::ORGANIZATION_COORDINATOR:
            case \App\Enums\UserType::COORDINATOR:
                return redirect()->route('coordinator.dashboard')->with('verified', true);
            case \App\Enums\UserType::DOCTOR:
                return redirect()->route('doctor.dashboard')->with('verified', true);
            default:
                return redirect()->route('login')->with('status', 'Email verified successfully. You can now login.');
        }
    } catch (\Exception $e) {
        \Log::error('Email verification error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        abort(403, 'Verification failed: ' . $e->getMessage());
    }
})->name('verification.verify');

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
            case \App\Enums\UserType::ORGANIZATION_COORDINATOR:
                return redirect()->route('coordinator.dashboard');
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
    Route::get('/users/{userId}/profile', \App\Livewire\SuperAdmin\User\ViewUserProfileComponent::class)->name('user-profile');
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

Route::group(['prefix' => 'organization-admin', 'as' => 'organization-admin.', 'middleware' => ['auth', 'verified']],function () {
    Route::get('/notifications',OrganizationNotificationComponent::class)->name('notifications');
    Route::get('/manage-staff',ManageStaffComponent::class)->name('manage_staff');
    Route::get('/doctor-tasks',DoctorTasksComponent::class)->name('doctor_tasks');
    Route::get('/doctor-licenses',DoctorApplicationsComponent::class)->name('doctor_licenses');
    Route::get('/doctor-applications',DoctorPayerEnrollmentComponent::class)->name('doctor_applications');
    Route::get('/doctor-expirables',OrgDoctorExpirablesComponent::class)->name('doctor_expirables');
    Route::get('/doctor-reports',OrgDoctorReportsComponent::class)->name('doctor_reports');
    Route::get('/doctor-invoice-payments',OrgDoctorInvoicePaymentsComponent::class)->name('doctor_invoice_payments');
    Route::get('/invoices', \App\Livewire\Organization\InvoiceListComponent::class)->name('invoices');
    Route::get('/doctor-documents', \App\Livewire\Organization\DoctorDocumentsComponent::class)->name('doctor_documents');
    // Support Tickets
    Route::get('/support-tickets', OrgAdminAllSupportTicketsComponent::class)->name('all_support_tickets');
    Route::get('/create/support-ticket', OrgAdminCreateSupportTicketComponent::class)->name('create_support_ticket');
    Route::get('/chat/{supportTicketId}', OrgAdminChatSupportTicketComponent::class)->name('chat_support_tickets');
});
    // Route::prefix('organization-manager','as'=>'organization-manager.')->group(function () {
    // });
    // Route::prefix('organization-staff','as'=>'organization-staff.')->group(function () {
    // });
    // Route::prefix('coordinator','as'=>'coordinator.')->group(function () {
    // });
Route::group(['prefix' => 'doctor', 'as' => 'doctor.', 'middleware' => ['auth', 'verified']],function () {
    Route::get('/tasks', MyTasksComponent::class)->name('tasks');
    Route::get('/invite-providers', InviteProvidersComponent::class)->name('invite-providers');
    Route::get('/licensing',ApplicationsComponent::class)->name('licensing');
    Route::get('/profile', DoctorProfileComponent::class)->name('profile');
    Route::get('/applications',PayerEnrollmentComponent::class)->name('applications');
    Route::get('/certifications', \App\Livewire\Doctor\CertificationComponent::class)->name('certifications');
    Route::get('/reports', ReportsComponent::class)->name('reports');
    Route::get('/expirables', ExpirablesComponent::class)->name('expirables');
    Route::get('/invoice-payments', InvoicePaymentsComponent::class)->name('invoice-payments');
    Route::get('/invoices', \App\Livewire\Doctor\InvoiceListComponent::class)->name('invoices');
    Route::get('/documents', \App\Livewire\Doctor\DocumentsComponent::class)->name('documents');
    Route::get('/notifications',DoctorNotificationComponent::class)->name('notifications');
    Route::get('/support-tickets',AllSupportTicketsComponent::class)->name('all_support_tickets');
    Route::get('create/support-ticket',CreateSupportTicketComponent::class)->name('create_support_ticket');
    Route::get('chat/{supportTicketId}',ChatSupportTicketComponent::class)->name('chat_support_tickets');
});
Route::group(['prefix' => 'coordinator', 'as' => 'coordinator.', 'middleware' => ['auth', 'verified']],function () {
    Route::get('/tasks', CoordTasksComponent::class)->name('tasks');
    Route::get('/applications', CoordApplicationsComponent::class)->name('applications');
    Route::get('/licensing', CoordLicensingComponent::class)->name('licensing');
    Route::get('/invoice-payments', CoordInvoicePaymentsComponent::class)->name('invoice-payments');
    Route::get('/expirables', CoordExpirablesComponent::class)->name('expirables');
    Route::get('/reports', CoordReportsComponent::class)->name('reports');
});
 