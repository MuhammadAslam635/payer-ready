<?php

namespace App\View\Components\doctor;

use App\Models\LicenseType;
use App\Models\State;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Log;

class RequestLicenseModal extends Component
{
    /**
     * Create a new component instance.
     */
    public $licenseTypes;
    public $states;

    public function __construct()
    {
        try {
            $this->licenseTypes = LicenseType::all();
            $this->states = State::all();
        } catch (\Exception $e) {
            Log::error('Error loading data for RequestLicenseModal: ' . $e->getMessage());
            $this->licenseTypes = collect();
            $this->states = collect();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.doctor.request-license-modal', [
            'licenseTypes' => $this->licenseTypes,
            'states' => $this->states
        ]);
    }
}
