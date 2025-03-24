<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentification
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// Réinitialisation mot de passe
Route::post('/password/forgot', [PasswordResetController::class, 'sendResetLink']);
Route::post('/password/reset', [PasswordResetController::class, 'reset']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    // Annonces
    Route::apiResource('annonces', AnnonceController::class);
    Route::get('annonces/search/{keyword}', [AnnonceController::class, 'search']);
    Route::patch('annonces/{annonce}/toggle', [AnnonceController::class, 'toggleActive']);
    
    // Candidatures
    Route::apiResource('candidatures', CandidatureController::class)->except(['store']);
    Route::post('annonces/{annonce}/candidatures', [CandidatureController::class, 'store']);
    Route::get('my-candidatures', [CandidatureController::class, 'myCandidatures']);
    Route::get('annonces/{annonce}/candidatures', [CandidatureController::class, 'annonceCandidatures']);
    Route::get('candidatures/{id}/download-cv', [CandidatureController::class, 'downloadCv']);
    Route::get('candidatures/{id}/download-letter', [CandidatureController::class, 'downloadLetter']);
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    
    // Statistiques
    Route::get('stats/recruiter', [StatisticController::class, 'recruiterStats']);
    
    // Admin
    Route::middleware('can:admin')->group(function () {
        Route::get('stats/admin', [StatisticController::class, 'adminStats']);
        Route::patch('users/{user}/role', [AdminController::class, 'changeRole']);
    });
});