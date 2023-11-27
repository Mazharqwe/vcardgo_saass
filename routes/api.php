<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [ApiController::class, 'login'])->middleware(['APILog']);
Route::post('/logout', [ApiController::class, 'logout'])->middleware(['auth:sanctum', 'APILog']);
Route::get('/business', [ApiController::class, 'businessData'])->middleware(['auth:sanctum', 'APILog']);
Route::get('/appointment', [ApiController::class, 'appointmentData'])->middleware(['auth:sanctum', 'APILog']);
Route::post('delete_appointment', [ApiController::class, 'appointmentDestroy'])->middleware(['auth:sanctum', 'APILog']);
Route::post('/appointment_status', [ApiController::class, 'ChangeStatusAppointment'])->middleware(['auth:sanctum', 'APILog']);
Route::post('/change_password', [ApiController::class, 'changePassword'])->middleware(['auth:sanctum', 'APILog']);
Route::post('/edit_profile', [ApiController::class, 'updateProfile'])->middleware(['auth:sanctum', 'APILog']);
