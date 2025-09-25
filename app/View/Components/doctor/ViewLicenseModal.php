<?php

namespace App\View\Components\doctor;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ViewLicenseModal extends Component
{
    public $license;

    /**
     * Create a new component instance.
     */
    public function __construct($license = null)
    {
        $this->license = $license;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.doctor.view-license-modal');
    }
}