<?php

use App\Http\Controllers\Admin\AdminBookingListController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\BookingListController;
use App\Http\Controllers\admin\MealTimeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => 'admin'], function () {
  

    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [LoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('admin.authenticate');
    });

   Route::group(['middleware' => 'admin.auth'],function(){
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/list', [BookingListController::class, 'index'])->name('users.list');
        Route::get('/edit/{id}', [BookingListController::class, 'edit'])->name('users.edit');
        Route::put('/update/{id}', [BookingListController::class, 'update'])->name('users.update');


        // booking-list
        Route::get('/breakfast-list', [AdminBookingListController::class, 'breakfast_index'])->name('bookings.breakfast-list');
        Route::get('/lunch-list', [AdminBookingListController::class, 'lunch_index'])->name('bookings.lunch-list');
        Route::get('/dinner-list', [AdminBookingListController::class, 'dinner_index'])->name('bookings.dinner-list');
        Route::get('/logout',[LoginController::class, 'logout'])->name('admin.logout');

        //Meal time 
        Route::get('/meal-times', [MealTimeController::class, 'index'])->name('meal-times.index');
        Route::get('/meal-times/{id}/edit', [MealTimeController::class, 'edit'])->name('meal-times.edit');
        Route::put('/meal-times/{id}', [MealTimeController::class, 'update'])->name('meal-times.update');


    });
});