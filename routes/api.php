<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChannelController;
use App\Http\Controllers\Api\EpgController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\HistoryController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Live TV Streaming Backend API Routes
| All routes are prefixed with /api automatically
|
*/

// ─── Public Routes ───────────────────────────────────────────────────────────

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// ─── Public Content Routes ───────────────────────────────────────────────────

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/channels', [ChannelController::class, 'index']);
Route::get('/subscriptions', [SubscriptionController::class, 'plans']);

// ─── Authenticated Routes ────────────────────────────────────────────────────

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/profile', [AuthController::class, 'profile']);

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites/add', [FavoriteController::class, 'add']);
    Route::post('/favorites/remove', [FavoriteController::class, 'remove']);

    // Subscriptions
    Route::post('/subscriptions/subscribe', [SubscriptionController::class, 'subscribe']);
    Route::get('/subscriptions/status', [SubscriptionController::class, 'status']);

    // Payments
    Route::get('/payments', [PaymentController::class, 'index']);

    // Channels Details
    Route::get('/channels/{id}', [ChannelController::class, 'show']);
    Route::get('/channels/{id}/epg', [EpgController::class, 'channelPrograms']);

    // Watch History
    Route::get('/history', [HistoryController::class, 'index']);
    Route::post('/history/save', [HistoryController::class, 'save']);
});
