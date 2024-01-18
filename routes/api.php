<?php

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
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
Route::get('/booking-list', [BookingController::class, 'index']);   
Route::get('/user-list', [AuthController::class, 'index']);  
Route::post('/booking', [BookingController::class, 'store']);
Route::get('/today-booking-count', [BookingController::class, 'todayBookingCount']);
Route::post('/today-booking-list', [BookingController::class, 'todayBookingList']);
Route::post('/check-in', [BookingController::class, 'checkIn']);
});