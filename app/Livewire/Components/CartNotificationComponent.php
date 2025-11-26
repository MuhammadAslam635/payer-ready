<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\On;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CartNotificationComponent extends Component
{
    public $cartCount = 0;
    public $cartTotal = 0;
    public $cartInstance = 'invoice';
    public $showNotification = false;

    protected $listeners = [
        'cart-updated' => 'refreshCart',
        'item-added' => 'showAddedNotification',
    ];

    public function mount()
    {
        $this->refreshCart();
    }

    #[On('cart-updated')]
    #[On('item-added')]
    public function refreshCart()
    {
        $this->cartCount = Cart::instance($this->cartInstance)->count();
        $this->cartTotal = Cart::instance($this->cartInstance)->total();
    }

    public function showAddedNotification()
    {
        $this->refreshCart();
        $this->showNotification = true;
        
        // Auto-hide notification after 3 seconds
        $this->dispatch('hide-notification')->delay(3000);
    }

    #[On('hide-notification')]
    public function hideNotification()
    {
        $this->showNotification = false;
    }

    public function render()
    {
        // Only show for super_admin users
        if (!Auth::check() || Auth::user()->user_type !== \App\Enums\UserType::SUPER_ADMIN) {
            return view('livewire.components.cart-notification-component', [
                'showComponent' => false
            ]);
        }

        return view('livewire.components.cart-notification-component', [
            'showComponent' => true
        ]);
    }
}