<?php

namespace App\Livewire\SuperAdmin\Transactions;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class AllTransactionComponent extends Component
{
    public function render()
    {
        return view('livewire.super-admin.transactions.all-transaction-component');
    }
}
