<?php

namespace App\Livewire\SuperAdmin\PaymentGateway;

use App\Models\PaymentGateway;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout as AttributesLayout;
use App\Traits\HasToast;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

#[AttributesLayout('layouts.dashboard')]
class AllPayemntGatewaysComponent extends Component
{
    use WithPagination, WithFileUploads, HasToast;

    public $search = '';
    public $perPage = 15;

    // Modal states
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    // Form data
    public $name = '';
    public $code = '';
    public $description = '';
    public $provider = '';
    public $is_active = true;
    public $is_test_mode = true;
    public $is_local_payment = false;
    public $wallet_uri = '';
    public $barcode_screenshot = null;
    // Configuration fields
    public $api_key = '';
    public $api_secret = '';
    public $webhook_url = '';

    // Edit mode
    public $editingGateway = null;
    public $gatewayToDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('payment_gateways', 'code')->ignore($this->editingGateway?->id)
            ],
            'description' => 'nullable|string',
            'provider' => 'required|string|max:255',
            'is_active' => 'boolean',
            'is_test_mode' => 'boolean',
            'is_local_payment' => 'boolean',
            'wallet_uri' => 'nullable|string|max:500',
            'barcode_screenshot' => 'nullable|image|max:2048', // 2MB max
            'api_key' => 'nullable|string',
            'api_secret' => 'nullable|string',
            'webhook_url' => 'nullable|url',
        ];

        return $rules;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEditModal($gatewayId)
    {
        $this->editingGateway = PaymentGateway::findOrFail($gatewayId);
        $this->fillForm($this->editingGateway);
        $this->showEditModal = true;
    }

    public function openDeleteModal($gatewayId)
    {
        $this->gatewayToDelete = PaymentGateway::findOrFail($gatewayId);
        $this->showDeleteModal = true;
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    public function create()
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
                'provider' => $this->provider,
                'is_active' => $this->is_active,
                'is_test_mode' => $this->is_test_mode,
                'is_local_payment' => $this->is_local_payment,
                'wallet_uri' => $this->wallet_uri,
                'configuration' => json_encode([
                    'api_key' => $this->api_key,
                    'api_secret' => $this->api_secret,
                    'webhook_url' => $this->webhook_url,
                ]),
            ];

            // Handle barcode/screenshot upload
            if ($this->barcode_screenshot) {
                $path = $this->barcode_screenshot->store('assets/payment-gateways/barcodes', 'public');
                $data['barcode_screenshot_path'] = $path;
            }

            PaymentGateway::create($data);

            $this->toastSuccess('Payment gateway created successfully!');
            $this->closeModals();
            $this->resetPage();
        } catch (\Exception $e) {
            $this->toastError('Error creating payment gateway: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'code' => $this->code,
                'description' => $this->description,
                'provider' => $this->provider,
                'is_active' => $this->is_active,
                'is_test_mode' => $this->is_test_mode,
                'is_local_payment' => $this->is_local_payment,
                'wallet_uri' => $this->wallet_uri,
                'configuration' => json_encode([
                    'api_key' => $this->api_key,
                    'api_secret' => $this->api_secret,
                    'webhook_url' => $this->webhook_url,
                ]),
            ];

            // Handle barcode/screenshot upload
            if ($this->barcode_screenshot) {
                // Delete old file if exists
                if ($this->editingGateway->barcode_screenshot_path) {
                    Storage::disk('public')->delete($this->editingGateway->barcode_screenshot_path);
                }

                $path = $this->barcode_screenshot->store('assets/payment-gateways/barcodes', 'public');
                $data['barcode_screenshot_path'] = $path;
            }

            $this->editingGateway->update($data);

            $this->toastSuccess('Payment gateway updated successfully!');
            $this->closeModals();
        } catch (\Exception $e) {
            $this->toastError('Error updating payment gateway: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        try {
            // Delete associated barcode/screenshot file
            if ($this->gatewayToDelete->barcode_screenshot_path) {
                Storage::disk('public')->delete($this->gatewayToDelete->barcode_screenshot_path);
            }

            $this->gatewayToDelete->delete();

            $this->toastSuccess('Payment gateway deleted successfully!');
            $this->closeModals();
            $this->resetPage();
        } catch (\Exception $e) {
            $this->toastError('Error deleting payment gateway: ' . $e->getMessage());
        }
    }

    public function toggleStatus($gatewayId)
    {
        try {
            $gateway = PaymentGateway::findOrFail($gatewayId);
            $gateway->update(['is_active' => !$gateway->is_active]);

            $status = $gateway->is_active ? 'activated' : 'deactivated';
            $this->toastSuccess("Payment gateway {$status} successfully!");
        } catch (\Exception $e) {
            $this->toastError('Error updating gateway status: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->name = '';
        $this->code = '';
        $this->description = '';
        $this->provider = '';
        $this->is_active = true;
        $this->is_test_mode = true;
        $this->is_local_payment = false;
        $this->wallet_uri = '';
        $this->barcode_screenshot = null;
        $this->api_key = '';
        $this->api_secret = '';
        $this->webhook_url = '';
        $this->editingGateway = null;
        $this->gatewayToDelete = null;
        $this->resetValidation();
    }

    private function fillForm($gateway)
    {
        $this->name = $gateway->name;
        $this->code = $gateway->code;
        $this->description = $gateway->description;
        $this->provider = $gateway->provider;
        $this->is_active = $gateway->is_active;
        $this->is_test_mode = $gateway->is_test_mode;
        $this->is_local_payment = $gateway->is_local_payment;
        $this->wallet_uri = $gateway->wallet_uri;

        $config = json_decode($gateway->configuration, true) ?? [];
        $this->api_key = $config['api_key'] ?? '';
        $this->api_secret = $config['api_secret'] ?? '';
        $this->webhook_url = $config['webhook_url'] ?? '';
    }

    public function getPaymentGateways()
    {
        return PaymentGateway::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('provider', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.super-admin.payment-gateway.all-payemnt-gateways-component', [
            'paymentGateways' => $this->getPaymentGateways(),
        ]);
    }
}
