<?php

use App\Http\Controllers\Admin\AdminBookingListController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\BookingListController;
use App\Http\Controllers\admin\MasterDataController;
use App\Http\Controllers\Admin\MealTimeController;
use App\Http\Controllers\Admin\PurchaseController;
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
        Route::get('/masterdata', [HomeController::class, 'masterdata_index'])->name('admin.masterdata');     
        Route::get('/list', [BookingListController::class, 'index'])->name('users.list');
        Route::get('/list/create', [BookingListController::class, 'create'])->name('users.create');
        Route::post('/list', [BookingListController::class, 'store'])->name('users.store');
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

        //founding source 
        Route::get('/funding_sources', [MasterDataController::class, 'fund_index'])->name('funding_sources.index');
        Route::get('/funding_sources/create', [MasterDataController::class, 'fund_create'])->name('funding_sources.create');
        Route::post('/funding_sources', [MasterDataController::class, 'fund_store'])->name('funding_sources.store');

        //available funding
        Route::get('/fund_history', [MasterDataController::class, 'fund_history_index'])->name('fund_history.index');
        Route::get('/fund_history/create', [MasterDataController::class, 'fund_history_create'])->name('fund_history.create');
        Route::post('/fund_history', [MasterDataController::class, 'fund_history_store'])->name('fund_history.store');

        //item units source 
        Route::get('/item_units', [MasterDataController::class, 'unit_index'])->name('units.index');
        Route::get('/item_units/create', [MasterDataController::class, 'unit_create'])->name('units.create');
        Route::post('/item_units', [MasterDataController::class, 'unit_store'])->name('units.store');
        Route::get('/units/{id}/edit', [MasterDataController::class, 'unit_edit'])->name('units.edit');
        Route::put('/units/{id}/update', [MasterDataController::class, 'unit_update'])->name('units.update');

        //Item
        Route::get('/items', [MasterDataController::class, 'item_index'])->name('items.index');
        Route::get('/items/create', [MasterDataController::class, 'item_create'])->name('items.create');
        Route::post('/items', [MasterDataController::class, 'item_store'])->name('items.store');
        Route::get('/items/{id}/edit', [MasterDataController::class, 'item_edit'])->name('items.edit');
        Route::put('/items/{id}/update', [MasterDataController::class, 'item_update'])->name('items.update');

        //Purchase
        Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
        Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
        Route::post('/purchases/store', [PurchaseController::class, 'store'])->name('purchases.store');
        


    });
});