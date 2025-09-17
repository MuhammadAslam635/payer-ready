<?php

namespace App\Livewire\Components;

use App\Enums\UserType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardHeader extends Component
{
    public $user;
    public $organization;
    public $showProfileDropdown = false;
    public $searchQuery = '';

    public function mount()
    {
        $this->user = Auth::user();
        if ($this->user && $this->user->organizationStaff->first()) {
            $this->organization = $this->user->organizationStaff->first()->organization;
        }
    }

    public function toggleProfileDropdown()
    {
        $this->showProfileDropdown = !$this->showProfileDropdown;
    }

    public function updatedSearchQuery()
    {
        // Emit search event for other components to listen
        $this->dispatch('search-updated', query: $this->searchQuery);
    }

    public function render()
    {
        return view('livewire.components.dashboard-header');
    }
}
