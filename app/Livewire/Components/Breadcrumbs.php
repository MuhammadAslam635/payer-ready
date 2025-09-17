<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Breadcrumbs extends Component
{
    public $breadcrumbs = [];

    public function mount($breadcrumbs = [])
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    public function render()
    {
        return view('livewire.components.breadcrumbs');
    }
}
