<?php

namespace App\Services;

use App\Models\User;
use App\Models\DoctorCredential;
use App\Models\Payer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;

class OrganizationCredentialingFeeService
{
    /**
     * Calculate credentialing fee for organization based on type and provider count
     * 
     * @param User $organization The organization admin user
     * @param string $requestType The request type (enrollment_new, recredentialing)
     * @param Payer|null $payer The payer being enrolled (for checking existing enrollment)
     * @param User|null $provider The provider being linked (if linking provider)
     * @return array Returns ['base_fee' => float, 'provider_linkage_fee' => float, 'total' => float, 'breakdown' => array]
     */
    public function calculateFee(
        User $organization,
        string $requestType,
        ?Payer $payer = null,
        ?User $provider = null
    ): array {
        $organizationType = $organization->organization_type ?? '';
        $existingProviderCount = $this->getExistingProviderCount($organization);
        $isAlreadyEnrolled = $payer ? $this->isOrganizationEnrolledWithPayer($organization, $payer) : false;
        
        $baseFee = 0.00;
        $providerLinkageFee = 0.00;
        $breakdown = [];

        // If organization is already enrolled with payer and just linking a provider
        if ($isAlreadyEnrolled && $provider) {
            $providerLinkageFee = 100.00;
            $breakdown[] = [
                'description' => 'Provider linkage fee (organization already enrolled)',
                'amount' => $providerLinkageFee
            ];
            
            return [
                'base_fee' => 0,
                'provider_linkage_fee' => $providerLinkageFee,
                'total' => $providerLinkageFee,
                'breakdown' => $breakdown,
                'fee_type' => 'provider_linkage'
            ];
        }

        // Calculate base fee based on organization type
        $orgTypeUpper = strtoupper($organizationType);
        
        // For general organizations (not specific types), apply the standard fee structure
        if (!in_array($orgTypeUpper, ['HHA', 'CMHC', 'DME', 'PHARMACY', 'CLINIC GROUP'])) {
            // Organization Per application Fee: If organization has up to 5 providers, per application fee is $250
            if ($existingProviderCount <= 5) {
                $baseFee = 250.00;
                $breakdown[] = [
                    'description' => 'Organization per application fee (up to 5 providers)',
                    'amount' => $baseFee
                ];
            } else {
                // Above 5 providers: $50 per provider to link
                $providersAboveFive = $existingProviderCount - 5;
                $providerLinkageFee = $providersAboveFive * 50.00;
                $baseFee = 0; // No base fee, only per-provider fee
                $breakdown[] = [
                    'description' => "Provider linkage fee ({$providersAboveFive} providers above 5 × $50)",
                    'amount' => $providerLinkageFee
                ];
            }
        } else {
            // Specific organization types have their own fee structure
            switch ($orgTypeUpper) {
                case 'HHA':
                case 'CMHC':
                    // HHA/CMHC: $150-$250 per application
                    // Using $200 as default, can be adjusted based on complexity
                    $baseFee = 200.00;
                    $breakdown[] = [
                        'description' => ucfirst($organizationType) . ' application fee',
                        'amount' => $baseFee
                    ];
                    break;

                case 'DME':
                    // DME: $250 per application
                    $baseFee = 250.00;
                    $breakdown[] = [
                        'description' => 'DME application fee',
                        'amount' => $baseFee
                    ];
                    break;

                case 'PHARMACY':
                    // Pharmacy: $150 per application
                    $baseFee = 150.00;
                    $breakdown[] = [
                        'description' => 'Pharmacy application fee',
                        'amount' => $baseFee
                    ];
                    break;

                case 'CLINIC GROUP':
                    // Clinic Group: $100-$150 per application, and $50 per individual provider linkage
                    $baseFee = 125.00; // Using $125 as default (middle of $100-$150 range)
                    $breakdown[] = [
                        'description' => 'Clinic Group application fee',
                        'amount' => $baseFee
                    ];
                    
                    // If linking a provider and organization has providers, add $50 per provider linkage
                    if ($provider && $existingProviderCount > 0) {
                        $providerLinkageFee = 50.00;
                        $breakdown[] = [
                            'description' => 'Individual provider linkage fee',
                            'amount' => $providerLinkageFee
                        ];
                    }
                    break;
            }
        }

        $total = $baseFee + $providerLinkageFee;

        return [
            'base_fee' => $baseFee,
            'provider_linkage_fee' => $providerLinkageFee,
            'total' => $total,
            'breakdown' => $breakdown,
            'fee_type' => 'application',
            'organization_type' => $organizationType,
            'existing_provider_count' => $existingProviderCount,
            'is_already_enrolled' => $isAlreadyEnrolled
        ];
    }

    /**
     * Get count of existing providers under the organization
     * 
     * @param User $organization
     * @return int
     */
    public function getExistingProviderCount(User $organization): int
    {
        return User::where('org_id', $organization->id)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->where('is_active', true)
            ->count();
    }

    /**
     * Check if organization is already enrolled with a specific payer
     * 
     * @param User $organization
     * @param Payer $payer
     * @return bool
     */
    public function isOrganizationEnrolledWithPayer(User $organization, Payer $payer): bool
    {
        // Check if organization admin itself has credentials with this payer
        $orgHasCredential = DoctorCredential::where('user_id', $organization->id)
            ->where('payer_id', $payer->id)
            ->whereIn('status', [
                \App\Enums\CredentialStatus::COMPLETED,
                \App\Enums\CredentialStatus::PENDING,
                \App\Enums\CredentialStatus::WORKING
            ])
            ->exists();

        if ($orgHasCredential) {
            return true;
        }

        // Check if any provider under this organization has credentials with this payer
        $providerIds = User::where('org_id', $organization->id)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id');

        if ($providerIds->isEmpty()) {
            return false;
        }

        return DoctorCredential::whereIn('user_id', $providerIds)
            ->where('payer_id', $payer->id)
            ->whereIn('status', [
                \App\Enums\CredentialStatus::COMPLETED,
                \App\Enums\CredentialStatus::PENDING,
                \App\Enums\CredentialStatus::WORKING
            ])
            ->exists();
    }

    /**
     * Create invoice for credentialing based on enrollment
     * 
     * @param DoctorCredential $credential
     * @return Invoice|null
     */
    public function createInvoiceForCredentialing(DoctorCredential $credential): ?Invoice
    {
        $provider = $credential->user;
        $organization = $provider->parentOrganization;
        
        // If provider doesn't have organization, invoice goes to provider
        $invoiceUser = $organization ?? $provider;
        
        // Check if invoice already exists for this credential
        $existingInvoice = Invoice::whereHas('invoiceItems', function ($query) use ($credential) {
            $query->where('itemable_id', $credential->id)
                  ->where('itemable_type', DoctorCredential::class);
        })->first();

        if ($existingInvoice) {
            return $existingInvoice;
        }

        // Calculate fee
        $feeData = $this->calculateFee(
            $invoiceUser,
            $credential->request_type ?? 'enrollment_new',
            $credential->payer,
            ($provider->org_id && $provider->id !== $organization?->id) ? $provider : null
        );

        if ($feeData['total'] <= 0) {
            return null; // No fee, no invoice needed
        }

        try {
            DB::beginTransaction();

            // Create invoice
            $invoice = Invoice::create([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'user_id' => $invoiceUser->id,
                'subtotal' => $feeData['total'],
                'discount' => 0,
                'tax' => 0,
                'total' => $feeData['total'],
                'status' => 'pending',
                'due_date' => now()->addDays(30),
                'notes' => 'Credentialing fee for ' . ($credential->payer->name ?? 'Payer') . ' enrollment - ' . 
                           ($provider->id === $organization?->id ? 'Organization' : $provider->name),
            ]);

            // Create invoice items for fee breakdown
            foreach ($feeData['breakdown'] as $feeItem) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $feeItem['description'],
                    'quantity' => 1,
                    'unit_price' => $feeItem['amount'],
                    'amount' => $feeItem['amount'],
                    'itemable_id' => $credential->id,
                    'itemable_type' => DoctorCredential::class,
                    'notes' => 'Credentialing fee for enrollment request',
                ]);
            }

            // Link invoice to credential in metadata
            $credential->update([
                'metadata' => array_merge($credential->metadata ?? [], [
                    'invoice_id' => $invoice->id,
                    'fee_calculation' => $feeData,
                ]),
            ]);

            DB::commit();

            // Send invoice notification
            try {
                $invoiceUser->notify(new \App\Notifications\InvoiceNotification($invoice, 'created'));
            } catch (\Exception $e) {
                \Log::error('Failed to send invoice notification: ' . $e->getMessage());
            }

            return $invoice;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to create credentialing invoice: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create invoices for all pending enrollments that don't have invoices
     * 
     * @param User $organization
     * @return array ['created' => int, 'skipped' => int]
     */
    public function createInvoicesForPendingEnrollments(User $organization): array
    {
        $providerIds = User::where('org_id', $organization->id)
            ->where('user_type', \App\Enums\UserType::DOCTOR)
            ->pluck('id')
            ->toArray();
        
        $providerIds[] = $organization->id; // Include organization itself

        $pendingCredentials = DoctorCredential::whereIn('user_id', $providerIds)
            ->whereIn('status', [
                \App\Enums\CredentialStatus::REQUESTED,
                \App\Enums\CredentialStatus::WORKING,
                \App\Enums\CredentialStatus::PENDING
            ])
            ->with(['payer', 'user'])
            ->get();

        $created = 0;
        $skipped = 0;

        foreach ($pendingCredentials as $credential) {
            // Check if invoice already exists
            $existingInvoice = Invoice::whereHas('invoiceItems', function ($query) use ($credential) {
                $query->where('itemable_id', $credential->id)
                      ->where('itemable_type', DoctorCredential::class);
            })->first();

            if ($existingInvoice) {
                $skipped++;
                continue;
            }

            $invoice = $this->createInvoiceForCredentialing($credential);
            if ($invoice) {
                $created++;
            } else {
                $skipped++;
            }
        }

        return [
            'created' => $created,
            'skipped' => $skipped
        ];
    }
}

