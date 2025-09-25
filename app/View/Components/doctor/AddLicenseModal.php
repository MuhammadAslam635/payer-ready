<?php

namespace App\View\Components\doctor;

use App\Models\LicenseType;
use App\Models\State;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddLicenseModal extends Component
{
    public $selectedProvider;
    public $licenseTypes;
    public $states;

    /**
     * Create a new component instance.
     */
    public function __construct($selectedProvider = '')
    {
        $this->selectedProvider = $selectedProvider;
        $this->licenseTypes = LicenseType::all();
        $this->states = State::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.doctor.add-license-modal', [
            'licenseTypes' => $this->licenseTypes,
            'selectedProvider' => $this->selectedProvider,
            'states' => $this->states
        ]);
    }
}
