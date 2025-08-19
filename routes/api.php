<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\RecordController;

// API Routes
Route::get('/settings/sheet-url', [SettingController::class, 'getSheetUrl']);
Route::post('/settings/sheet-url', [SettingController::class, 'setSheetUrl']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/records', [RecordController::class, 'index']);
Route::post('/records', [RecordController::class, 'store']);
Route::get('/records/{id}', [RecordController::class, 'show']);
Route::put('/records/{id}', [RecordController::class, 'update']);
Route::delete('/records/{id}', [RecordController::class, 'destroy']);
Route::post('/records/generate', [RecordController::class, 'generate']);
Route::post('/records/clear', [RecordController::class, 'clear']);