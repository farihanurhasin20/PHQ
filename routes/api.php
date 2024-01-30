<?php

use App\Http\Controllers\admin\MealTimeController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\BookingController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/update-profile', [AuthController::class, 'updateProfile']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
Route::get('/booking-list', [BookingController::class, 'index']);   
Route::get('/time-list', [MealTimeController::class, 'api_index']); 
Route::get('/meal-time/{id}', [BookingController::class, 'meal_time']); 
Route::get('/user-list', [AuthController::class, 'index']);  
Route::post('/booking', [BookingController::class, 'store']);
Route::get('/today-booking-count', [BookingController::class, 'todayBookingCount']);
Route::post('/today-booking-list', [BookingController::class, 'todayBookingList']);
Route::post('/check-in', [BookingController::class, 'checkIn']);
Route::get('/meal-dates/{id}', [BookingController::class, 'mealDates']);
Route::post('/meal-dates-cancel', [BookingController::class, 'mealDatesCancel']);
});