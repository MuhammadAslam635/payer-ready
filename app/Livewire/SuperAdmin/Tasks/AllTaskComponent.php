<?php

namespace App\Livewire\SuperAdmin\Tasks;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class AllTaskComponent extends Component
{
    public function render()
    {
        return view('livewire.super-admin.tasks.all-task-component');
    }
}
