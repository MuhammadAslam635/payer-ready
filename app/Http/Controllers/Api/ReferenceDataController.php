<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttestationQuestion;
use App\Models\DocumentType;
use App\Models\LicenseType;
use App\Models\Role;
use App\Models\Specialty;
use App\Models\State;
use Illuminate\Http\JsonResponse;

class ReferenceDataController extends Controller
{
    /**
     * Get all states
     */
    public function getStates(): JsonResponse
    {
        $states = State::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'code', 'name', 'country']);

        return response()->json([
            'success' => true,
            'data' => $states,
        ]);
    }

    /**
     * Get all specialties
     */
    public function getSpecialties(): JsonResponse
    {
        $specialties = Specialty::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'code', 'name']);

        return response()->json([
            'success' => true,
            'data' => $specialties,
        ]);
    }

    /**
     * Get all roles
     */
    public function getRoles(): JsonResponse
    {
        $roles = Role::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'code', 'name', 'description']);

        return response()->json([
            'success' => true,
            'data' => $roles,
        ]);
    }

    /**
     * Get all license types
     */
    public function getLicenseTypes(): JsonResponse
    {
        $licenseTypes = LicenseType::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'code', 'name', 'description']);

        return response()->json([
            'success' => true,
            'data' => $licenseTypes,
        ]);
    }

    /**
     * Get all document types
     */
    public function getDocumentTypes(): JsonResponse
    {
        $documentTypes = DocumentType::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'code', 'name', 'description', 'max_file_size_mb', 'allowed_extensions', 'is_required']);

        return response()->json([
            'success' => true,
            'data' => $documentTypes,
        ]);
    }

    /**
     * Get all attestation questions
     */
    public function getAttestationQuestions(): JsonResponse
    {
        $questions = AttestationQuestion::where('is_active', true)
            ->orderBy('display_order')
            ->get(['id', 'question_code', 'question_text', 'description', 'requires_explanation']);

        return response()->json([
            'success' => true,
            'data' => $questions,
        ]);
    }

    /**
     * Get all reference data in one call
     */
    public function getAll(): JsonResponse
    {
        $data = [
            'states' => State::where('is_active', true)->orderBy('name')->get(['id', 'code', 'name', 'country']),
            'specialties' => Specialty::where('is_active', true)->orderBy('name')->get(['id', 'code', 'name']),
            'roles' => Role::where('is_active', true)->orderBy('name')->get(['id', 'code', 'name', 'description']),
            'license_types' => LicenseType::where('is_active', true)->orderBy('name')->get(['id', 'code', 'name', 'description']),
            'document_types' => DocumentType::where('is_active', true)->orderBy('name')->get(['id', 'code', 'name', 'description', 'max_file_size_mb', 'allowed_extensions', 'is_required']),
            'attestation_questions' => AttestationQuestion::where('is_active', true)->orderBy('display_order')->get(['id', 'question_code', 'question_text', 'description', 'requires_explanation']),
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
