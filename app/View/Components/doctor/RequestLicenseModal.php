<?php

namespace App\View\Components\doctor;

use App\Models\LicenseType;
use App\Models\State;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RequestLicenseModal extends Component
{
    /**
     * Create a new component instance.
     */
    public $licenseTypes;
    public $states;

    public function __construct()
    {
        $this->licenseTypes = LicenseType::all();
        $this->states = State::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.doctor.request-license-modal',[
            'licenseTypes'=>$this->licenseTypes,
            'states'=>$this->states
        ]);
    }
}
