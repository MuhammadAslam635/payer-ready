<?php

use App\Http\Controllers\Api\ReferenceDataController;
use App\Http\Controllers\Api\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Registration API Routes
|--------------------------------------------------------------------------
*/

// Registration steps
Route::prefix('registration')->group(function () {
    Route::post('/step1', [RegistrationController::class, 'step1']);
    Route::post('/step2', [RegistrationController::class, 'step2']);
    Route::post('/step3', [RegistrationController::class, 'step3']);
    Route::post('/step4', [RegistrationController::class, 'step4']);
    Route::post('/step5', [RegistrationController::class, 'step5']);
    Route::post('/step6', [RegistrationController::class, 'step6']);
    Route::post('/step7', [RegistrationController::class, 'step7']);
    
    // Get registration progress
    Route::get('/progress/{userId}', [RegistrationController::class, 'getProgress']);
});

/*
|--------------------------------------------------------------------------
| Reference Data API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('reference-data')->group(function () {
    Route::get('/states', [ReferenceDataController::class, 'getStates']);
    Route::get('/specialties', [ReferenceDataController::class, 'getSpecialties']);
    Route::get('/roles', [ReferenceDataController::class, 'getRoles']);
    Route::get('/license-types', [ReferenceDataController::class, 'getLicenseTypes']);
    Route::get('/document-types', [ReferenceDataController::class, 'getDocumentTypes']);
    Route::get('/attestation-questions', [ReferenceDataController::class, 'getAttestationQuestions']);
    
    // Get all reference data in one call
    Route::get('/all', [ReferenceDataController::class, 'getAll']);
});
