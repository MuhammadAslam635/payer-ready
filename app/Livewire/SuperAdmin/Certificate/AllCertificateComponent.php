<?php

namespace App\Livewire\SuperAdmin\Certificate;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class AllCertificateComponent extends Component
{
    public function render()
    {
        return view('livewire.super-admin.certificate.all-certificate-component');
    }
}
