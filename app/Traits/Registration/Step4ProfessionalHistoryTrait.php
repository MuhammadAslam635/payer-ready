<?php

namespace App\Traits\Registration;

use App\Models\DoctorWorkHistory;
use App\Models\DoctorReference;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
trait Step4ProfessionalHistoryTrait
{
    // Step 4: Professional History
    #[Validate('nullable|array')]
    public $workHistory = [];
    #[Validate('nullable|array')]
    public $references = [];

    /**
     * Validate Step 4: Professional History
     */
    private function validateStep4ProfessionalHistory()
    {
        $rules = [];

        // Validate work history if any are provided
        foreach ($this->workHistory as $index => $work) {
            if (!empty($work['employer']) || !empty($work['position'])) {
                $rules["workHistory.{$index}.employer"] = 'nullable|string|max:255';
                $rules["workHistory.{$index}.position"] = 'nullable|string|max:255';
                $rules["workHistory.{$index}.start_date"] = 'nullable|date';
                if (!$work['current']) {
                    $rules["workHistory.{$index}.end_date"] = 'nullable|date|after:workHistory.' . $index . '.start_date';
                }
            }
        }

        // Validate references if any are provided
        foreach ($this->references as $index => $reference) {
            if (!empty($reference['name']) || !empty($reference['email']) || !empty($reference['phone']) || !empty($reference['relationship']) || !empty($reference['title']) || !empty($reference['facility_address'])) {
                $rules["references.{$index}.name"] = 'nullable|string|max:255';
                $rules["references.{$index}.email"] = 'nullable|email|max:255';
                $rules["references.{$index}.phone"] = 'nullable|string|max:20';
                $rules["references.{$index}.title"] = 'nullable|string|max:255';
                $rules["references.{$index}.facility_address"] = 'nullable|string|max:500';
            }
        }

        $this->validate($rules);
    }
    /**
     * Process Step 4: Professional History data
     */
    public function processStep4ProfessionalHistory(User $user)
    {
        // Validate step 4 data internally
        $this->validateStep4ProfessionalHistory();

        if (!$this->hasWorkHistoryData()) {
            Log::info('No work history data provided or doctor profile not available');
            return null;
        }

        $workHistory = [];
        $references = [];

        // Process work history
        if (!empty($this->workHistory)) {
            $workHistory = $this->createWorkHistory($user);
        }

        // Process references
        if (!empty($this->references)) {
            $references = $this->createReferences($user);
        }

        return [
            'workHistory' => $workHistory,
            'references' => $references,
        ];
    }

    // hasWorkHistoryData method is now centralized in RegistrationTrait

    /**
     * Create work history records
     */
    private function createWorkHistory($user)
    {
        $workHistoryRecords = [];

        foreach ($this->workHistory as $index => $workData) {

            if (!empty($workData['employer']) && !empty($workData['position'])) {

                try {
                    $workHistory = DoctorWorkHistory::create([
                        'user_id' => $user->id,
                        'hospital_name' => $workData['employer'], // Map employer to hospital_name
                        'position_title' => $workData['position'], // Map position to position_title
                        'address' => $workData['address'] ?? null,
                        'start_date' => $workData['start_date'],
                        'end_date' => $workData['end_date'],
                    ]);

                    $workHistoryRecords[] = $workHistory;
                } catch (\Exception $e) {
                    Log::error('Failed to create work history record', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage(),
                        'work_data' => $workData
                    ]);
                }
            } else {
                Log::warning('Skipping work history item due to missing nullable fields', [
                    'user_id' => $user->id,
                    'item_index' => $index,
                    'missing_employer' => empty($workData['employer']),
                    'missing_position' => empty($workData['position'])
                ]);
            }
        }

        Log::info('Work history creation summary', [
            'user_id' => $user->id,
            'total_items_processed' => count($this->workHistory),
            'successful_records' => count($workHistoryRecords)
        ]);

        return $workHistoryRecords;
    }

    /**
     * Create reference records
     */
    private function createReferences($user)
    {
        $referenceRecords = [];

        foreach ($this->references as $index => $referenceData) {

            if (!empty($referenceData['name']) && !empty($referenceData['title'])) {
                try {
                    $reference = DoctorReference::create([
                        'user_id' => $user->id,
                        'full_name' => $referenceData['name'], // Map name to full_name
                        'title' => $referenceData['title'],
                        'address' => $referenceData['facility_address'] ?? 'N/A', // Map facility_address to address
                        'phone' => $referenceData['phone'],
                        'email' => $referenceData['email']
                    ]);

                    $referenceRecords[] = $reference;
                } catch (\Exception $e) {
                    Log::error('Failed to create reference record', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage(),
                        'reference_data' => $referenceData
                    ]);
                }
            } else {
                Log::warning('Skipping reference item due to missing required fields', [
                    'user_id' => $user->id,
                    'item_index' => $index,
                    'missing_name' => empty($referenceData['name']),
                    'missing_title' => empty($referenceData['title'])
                ]);
            }
        }

        Log::info('References creation summary', [
            'user_id' => $user->id,
            'total_items_processed' => count($this->references),
            'successful_records' => count($referenceRecords)
        ]);

        return $referenceRecords;
    }

    /**
     * Add a new work history entry
     */
    public function addWorkHistory()
    {
        $this->workHistory[] = [
            'employer' => '',
            'position' => '',
            'address' => '',
            'start_date' => '',
            'end_date' => '',
            'current' => false,
            'responsibilities' => ''
        ];
    }

    /**
     * Remove a work history entry
     */
    public function removeWorkHistory($index)
    {
        if (isset($this->workHistory[$index])) {
            unset($this->workHistory[$index]);
            $this->workHistory = array_values($this->workHistory); // Re-index array
        }
    }

    /**
     * Add a new reference entry
     */
    public function addReference()
    {
        $this->references[] = [
            'name' => '',
            'title' => '',
            'facility_address' => '',
            'phone' => '',
            'email' => '',
            'relationship' => ''
        ];
    }

    /**
     * Remove a reference entry
     */
    public function removeReference($index)
    {
        if (isset($this->references[$index])) {
            unset($this->references[$index]);
            $this->references = array_values($this->references); // Re-index array
        }
    }

    /**
     * Initialize work history and references arrays
     */
    public function initializeStep4Data()
    {
        if (empty($this->workHistory)) {
            $this->workHistory = [
                [
                    'employer' => '',
                    'position' => '',
                    'address' => '',
                    'start_date' => '',
                    'end_date' => '',
                    'current' => false,
                    'responsibilities' => ''
                ]
            ];
        }

        if (empty($this->references)) {
            $this->references = [
                [
                    'name' => '',
                    'title' => '',
                    'facility_address' => '',
                    'phone' => '',
                    'email' => '',
                    'relationship' => ''
                ],
                [
                    'name' => '',
                    'title' => '',
                    'facility_address' => '',
                    'phone' => '',
                    'email' => '',
                    'relationship' => ''
                ]
            ];
        }
    }

    /**
     * Check if work history data exists
     */
    private function hasWorkHistoryData()
    {
        if (empty($this->workHistory) && empty($this->references)) {
            return false;
        }

        // Check if any work history has meaningful data
        $hasWorkData = false;
        foreach ($this->workHistory as $work) {
            if (!empty($work['employer']) || !empty($work['position'])) {
                $hasWorkData = true;
                break;
            }
        }

        // Check if any reference has meaningful data
        $hasReferenceData = false;
        foreach ($this->references as $reference) {
            if (!empty($reference['name']) || !empty($reference['title']) || !empty($reference['email'])) {
                $hasReferenceData = true;
                break;
            }
        }

        return $hasWorkData || $hasReferenceData;
    }
}



