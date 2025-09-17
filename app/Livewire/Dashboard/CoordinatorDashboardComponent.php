<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
#[Layout('layouts.dashboard')]
class CoordinatorDashboardComponent extends Component
{
    public function render()
    {
        return view('livewire.dashboard.coordinator-dashboard-component');
    }
}
