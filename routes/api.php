
<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    // Annonces
    Route::apiResource('annonces', AnnonceController::class);
    Route::get('annonces/search/{keyword}', [AnnonceController::class, 'search']);
    
    // Candidatures
    Route::apiResource('candidatures', CandidatureController::class)->except(['store']);
    Route::post('annonces/{annonce}/candidatures', [CandidatureController::class, 'store']);
    Route::get('my-candidatures', [CandidatureController::class, 'myCandidatures']);
    Route::get('annonces/{annonce}/candidatures', [CandidatureController::class, 'annonceCandidatures']);
    
    // Statistiques
    Route::get('stats/recruiter', [StatisticController::class, 'recruiterStats']);
    Route::get('stats/admin', [StatisticController::class, 'adminStats'])->middleware('can:admin');
});