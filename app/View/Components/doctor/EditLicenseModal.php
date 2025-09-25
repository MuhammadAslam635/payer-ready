<?php

namespace App\View\Components\doctor;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditLicenseModal extends Component
{
    public $licenseTypes;
    public $states;

    /**
     * Create a new component instance.
     */
    public function __construct($licenseTypes = [], $states = [])
    {
        $this->licenseTypes = $licenseTypes;
        $this->states = $states;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.doctor.edit-license-modal');
    }
}