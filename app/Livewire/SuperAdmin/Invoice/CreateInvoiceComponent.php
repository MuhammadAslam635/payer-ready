<?php

namespace App\Livewire\SuperAdmin\Invoice;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use App\Models\DoctorCertificate;
use App\Models\DoctorLicense;
use App\Models\DoctorCredential;
use App\Models\CertificateType;
use App\Models\LicenseType;
use App\Models\Payer;
use App\Traits\HasToast;
use App\Notifications\InvoiceNotification;
use App\Enums\UserType;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

#[Title('Create Invoice')]
#[Layout('layouts.dashboard')]
class CreateInvoiceComponent extends Component
{
    use HasToast;

    // Form properties
    public $selectedDoctor = '';
    public $invoiceNotes = '';
    public $dueDate = '';
    public $discount = 0;
    public $tax = 0;

    // Item selection properties
    public $selectedCertificates = [];
    public $selectedLicenses = [];
    public $selectedCredentials = [];

    // Cart properties
    public $cartInstance = 'invoice';
    public $cartItems = [];
    public $cartSubtotal = 0;
    public $cartTotal = 0;
    public $cartCount = 0;

    // Modal properties
    public $showItemModal = false;
    public $itemType = '';
    public $availableItems = [];

    // Manual item properties
    public $manualItemName = '';
    public $manualItemDescription = '';
    public $manualItemAmount = '';

    protected $listeners = [
        'cart-updated' => 'refreshCart',
        'item-added' => 'refreshCart',
    ];

    protected $rules = [
        'selectedDoctor' => 'required|exists:users,id',
        'dueDate' => 'required|date|after:today',
        'discount' => 'nullable|numeric|min:0',
        'tax' => 'nullable|numeric|min:0',
        'invoiceNotes' => 'nullable|string|max:1000',
    ];

    public function mount()
    {
        Cart::instance($this->cartInstance)->destroy();
        $this->dueDate = now()->addDays(30)->format('Y-m-d');
        $this->refreshCart();
    }

    public function updatedSelectedDoctor()
    {
        // Clear cart when doctor changes
        Cart::instance($this->cartInstance)->destroy();
        $this->refreshCart();
        $this->selectedCertificates = [];
        $this->selectedLicenses = [];
        $this->selectedCredentials = [];
    }

    public function openItemModal($type)
    {
        if (!$this->selectedDoctor) {
            $this->toast('Please select a doctor first.', 'error');
            return;
        }

        $this->itemType = $type;
        $this->showItemModal = true;
        $this->loadAvailableItems();
    }

    public function loadAvailableItems()
    {
        switch ($this->itemType) {
            case 'certificates':
                $this->availableItems = DoctorCertificate::with('certificateType')
                    ->where('user_id', $this->selectedDoctor)
                    ->get()
                    ->map(function ($cert) {
                        return [
                            'id' => $cert->id,
                            'name' => $cert->certificateType->name ?? 'Certificate',
                            'description' => "Certificate: {$cert->certificate_number}",
                            'price' => $cert->certificateType->default_amount  ?? 150, // Default price
                            'type' => 'certificate'
                        ];
                    });
                break;

            case 'licenses':
                $this->availableItems = DoctorLicense::with('licenseType', 'state')
                    ->where('user_id', $this->selectedDoctor)
                    ->get()
                    ->map(function ($license) {
                        return [
                            'id' => $license->id,
                            'name' => $license->licenseType->name ?? 'License',
                            'description' => "License: {$license->license_number} ({$license->state->name})",
                            'price' => 75.00, // Default price
                            'type' => 'license'
                        ];
                    });
                break;

            case 'credentials':
                $this->availableItems = DoctorCredential::with('payer')
                    ->where('user_id', $this->selectedDoctor)
                    ->get()
                    ->map(function ($credential) {
                        return [
                            'id' => $credential->id,
                            'name' => $credential->payer->name ?? 'Credential',
                            'description' => "Credential: {$credential->credential_number}",
                            'price' => 100.00, // Default price
                            'type' => 'credential'
                        ];
                    });
                break;
        }
    }

    public function addToCart($itemId, $price = null)
    {
        $item = collect($this->availableItems)->firstWhere('id', $itemId);
        
        if (!$item) {
            $this->toast('Item not found.', 'error');
            return;
        }

        $cartId = $item['type'] . '_' . $item['id'];
        $finalPrice = $price ?? $item['price'];

        // Check if item already exists in cart
        $existingItem = Cart::instance($this->cartInstance)->search(function ($cartItem) use ($cartId) {
            return $cartItem->id === $cartId;
        });

        if ($existingItem->isNotEmpty()) {
            $this->toast('Item already added to invoice.', 'warning');
            return;
        }

        Cart::instance($this->cartInstance)->add([
            'id' => $cartId,
            'name' => $item['name'],
            'qty' => 1,
            'price' => $finalPrice,
            'options' => [
                'description' => $item['description'],
                'type' => $item['type'],
                'item_id' => $item['id'],
            ]
        ]);

        $this->refreshCart();
        $this->toast('Item added to invoice successfully!', 'success');
        $this->dispatch('item-added');
    }

    public function addManualItem()
    {
        if (!$this->selectedDoctor) {
            $this->toast('Please select a doctor first.', 'error');
            return;
        }

        $this->validate([
            'manualItemName' => 'required|string|max:255',
            'manualItemAmount' => 'required|numeric|min:0.01',
            'manualItemDescription' => 'nullable|string|max:500',
        ], [], [
            'manualItemName' => 'service name',
            'manualItemAmount' => 'amount',
        ]);

        $cartId = 'custom_' . uniqid();

        Cart::instance($this->cartInstance)->add([
            'id' => $cartId,
            'name' => $this->manualItemName,
            'qty' => 1,
            'price' => (float) $this->manualItemAmount,
            'options' => [
                'description' => $this->manualItemDescription ?: 'Custom service',
                'type' => 'custom',
                'item_id' => null,
            ]
        ]);

        $this->reset(['manualItemName', 'manualItemDescription', 'manualItemAmount']);
        $this->refreshCart();
        $this->toast('Custom item added successfully!', 'success');
    }

    public function removeFromCart($rowId)
    {
        Cart::instance($this->cartInstance)->remove($rowId);
        $this->refreshCart();
        $this->toast('Item removed from invoice.', 'success');
        $this->dispatch('cart-updated');
    }

    public function updateCartItemPrice($rowId, $newPrice)
    {
        Cart::instance($this->cartInstance)->update($rowId, ['price' => $newPrice]);
        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function refreshCart()
    {
        $cart = Cart::instance($this->cartInstance);
        $this->cartItems = $cart->content()->toArray();
        $this->cartSubtotal = (float) $cart->subtotal(2, '.', '');
        $this->cartTotal = (float) $cart->total(2, '.', '');
        $this->cartCount = $cart->count();
    }

    public function closeModal()
    {
        $this->showItemModal = false;
        $this->itemType = '';
        $this->availableItems = [];
    }

    public function createInvoice()
    {
        $this->validate();

        if (Cart::instance($this->cartInstance)->count() === 0) {
            $this->toast('Please add at least one item to the invoice.', 'error');
            return;
        }

        try {
            DB::beginTransaction();

            // Create invoice
            $cart = Cart::instance($this->cartInstance);
            $cartSubtotal = (float) $cart->subtotal(2, '.', '');
            $finalTotal = $cartSubtotal - (float) $this->discount + (float) $this->tax;

            $invoice = Invoice::create([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'user_id' => $this->selectedDoctor,
                'subtotal' => $cartSubtotal,
                'discount' => $this->discount,
                'tax' => $this->tax,
                'total' => $finalTotal,
                'status' => 'pending',
                'due_date' => $this->dueDate,
                'notes' => $this->invoiceNotes,
            ]);

            // Create invoice items
            foreach ($cart->content() as $cartItem) {
                $itemableType = match($cartItem->options->type) {
                    'certificate' => DoctorCertificate::class,
                    'license' => DoctorLicense::class,
                    'credential' => DoctorCredential::class,
                    default => null,
                };

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $cartItem->options->description,
                    'quantity' => $cartItem->qty,
                    'unit_price' => (float) $cartItem->price,
                    'amount' => (float) $cartItem->total,
                    'itemable_id' => $cartItem->options->item_id,
                    'itemable_type' => $itemableType,
                    'notes' => null,
                ]);
            }

            // Clear cart
            Cart::instance($this->cartInstance)->destroy();

            // Send notifications
            $selectedUser = User::find($this->selectedDoctor);
            if ($selectedUser) {
                // Notify the selected doctor/organization
                try {
                    $selectedUser->notify(new InvoiceNotification($invoice, 'created'));
                    
                    // If doctor has an organization (org_id), also notify the organization
                    if ($selectedUser->org_id) {
                        $organization = User::find($selectedUser->org_id);
                        if ($organization) {
                            $organization->notify(new InvoiceNotification($invoice, 'created'));
                        }
                    }
                } catch (\Exception $e) {
                    // Log error but don't block invoice creation
                    \Log::error('Failed to send invoice notification: ' . $e->getMessage());
                }
            }

            DB::commit();

            $this->toast('Invoice created successfully!', 'success');
            $this->reset();
            $this->refreshCart();

            // Redirect to invoice view or list
            return redirect()->route('super-admin.all_invoices');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->toast('Error creating invoice: ' . $e->getMessage(), 'error');
        }
    }

    public function render()
    {
        $doctors = User::orderBy('name','asc')
            ->get();

        return view('livewire.super-admin.invoice.create-invoice-component', [
            'doctors' => $doctors,
        ]);
    }
}
