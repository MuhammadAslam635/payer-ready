<?php

namespace App\Traits\Registration;

use App\Models\DoctorWorkHistory;
use App\Models\DoctorReference;
use App\Models\User;
use Illuminate\Support\Facades\Log;

trait Step4ProfessionalHistoryTrait
{
    // Step 4: Professional History Variables
    public $workHistory = [
        ['employer' => '', 'position' => '', 'start_date' => '', 'end_date' => '', 'current' => false]
    ];
    public $references = [
        ['name' => '', 'title' => '', 'facility_address' => '', 'phone' => '', 'email' => '', 'relationship' => ''],
        ['name' => '', 'title' => '', 'facility_address' => '', 'phone' => '', 'email' => '', 'relationship' => '']
    ];

    /**
     * Validate Step 4: Professional History
     */
    private function validateStep4ProfessionalHistory()
    {
        $rules = [];

        // Validate work history if any are provided
        foreach ($this->workHistory as $index => $work) {
            if (!empty($work['employer']) || !empty($work['position'])) {
                $rules["workHistory.{$index}.employer"] = 'required|string|max:255';
                $rules["workHistory.{$index}.position"] = 'required|string|max:255';
                $rules["workHistory.{$index}.start_date"] = 'required|date';
                if (!$work['current']) {
                    $rules["workHistory.{$index}.end_date"] = 'required|date|after:workHistory.' . $index . '.start_date';
                }
            }
        }

        // Validate references if any are provided
        foreach ($this->references as $index => $reference) {
            if (!empty($reference['name']) || !empty($reference['email']) || !empty($reference['phone']) || !empty($reference['relationship']) || !empty($reference['title']) || !empty($reference['facility_address'])) {
                $rules["references.{$index}.name"] = 'required|string|max:255';
                $rules["references.{$index}.email"] = 'required|email|max:255';
                $rules["references.{$index}.phone"] = 'nullable|string|max:20';
                $rules["references.{$index}.relationship"] = 'required|string|max:255';
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

        Log::info('Processing Step 4: Professional History', [
            'user_id' => $user->id,
            'has_work_history_data' => $this->hasWorkHistoryData(),
            'work_history_count' => count($this->workHistory ?? []),
            'references_count' => count($this->references ?? [])
        ]);

        if (!$this->hasWorkHistoryData()) {
            Log::info('No work history data provided or doctor profile not available');
            return null;
        }

        $workHistory = [];
        $references = [];

        // Process work history
        if (!empty($this->workHistory)) {
            Log::info('Starting work history creation', [
                'user_id' => $user->id,
                'work_history_items' => count($this->workHistory)
            ]);
            $workHistory = $this->createWorkHistory($user);
            Log::info('Work history creation completed', [
                'user_id' => $user->id,
                'created_records' => count($workHistory)
            ]);
        }

        // Process references
        if (!empty($this->references)) {
            Log::info('Starting references creation', [
                'user_id' => $user->id,
                'reference_items' => count($this->references)
            ]);
            $references = $this->createReferences($user);
            Log::info('References creation completed', [
                'user_id' => $user->id,
                'created_records' => count($references)
            ]);
        }

        Log::info('Step 4 Professional History processing completed', [
            'user_id' => $user->id,
            'work_history_records' => count($workHistory),
            'reference_records' => count($references)
        ]);

        return [
            'workHistory' => $workHistory,
            'references' => $references,
        ];
    }

    /**
     * Check if work history data is provided
     */
    private function hasWorkHistoryData()
    {
        // Check if any work history fields have data
        if (!empty($this->workHistory)) {
            foreach ($this->workHistory as $work) {
                if (!empty($work['employer']) || !empty($work['position']) || !empty($work['start_date']) || !empty($work['end_date'])) {
                    return true;
                }
            }
        }

        // Check if any reference fields have data
        if (!empty($this->references)) {
            foreach ($this->references as $reference) {
                if (!empty($reference['name']) || !empty($reference['email']) || !empty($reference['phone']) || 
                    !empty($reference['relationship']) || !empty($reference['title']) || !empty($reference['facility_address'])) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Create work history records
     */
    private function createWorkHistory($user)
    {
        $workHistoryRecords = [];

        foreach ($this->workHistory as $index => $workData) {
            Log::info("Processing work history item {$index}", [
                'user_id' => $user->id,
                'item_index' => $index,
                'has_employer' => !empty($workData['employer']),
                'has_position' => !empty($workData['position']),
                'employer' => $workData['employer'] ?? 'N/A',
                'position' => $workData['position'] ?? 'N/A'
            ]);

            if (!empty($workData['employer']) && !empty($workData['position'])) {
                Log::info('Creating work history', [
                    'user_id' => $user->id,
                    'employer' => $workData['employer'],
                    'position' => $workData['position']
                ]);

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

                    Log::info('Work history created successfully', [
                        'work_history_id' => $workHistory->id,
                        'hospital_name' => $workHistory->hospital_name,
                        'position_title' => $workHistory->position_title,
                        'user_id' => $workHistory->user_id
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to create work history record', [
                        'user_id' => $user->id,
                        'error' => $e->getMessage(),
                        'work_data' => $workData
                    ]);
                }
            } else {
                Log::warning('Skipping work history item due to missing required fields', [
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
            Log::info("Processing reference item {$index}", [
                'user_id' => $user->id,
                'item_index' => $index,
                'has_name' => !empty($referenceData['name']),
                'has_title' => !empty($referenceData['title']),
                'name' => $referenceData['name'] ?? 'N/A',
                'title' => $referenceData['title'] ?? 'N/A'
            ]);

            if (!empty($referenceData['name']) && !empty($referenceData['title'])) {
                Log::info('Creating reference', [
                    'user_id' => $user->id,
                    'reference_name' => $referenceData['name'],
                    'reference_title' => $referenceData['title']
                ]);

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

                    Log::info('Reference created successfully', [
                        'reference_id' => $reference->id,
                        'reference_name' => $reference->full_name,
                        'reference_title' => $reference->title,
                        'user_id' => $reference->user_id
                    ]);
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
}



