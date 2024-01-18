<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function index(){
        $today = Carbon::today();

        $totalBreakfastBooking = Booking::where('breakfast', '=', '1')
            ->whereDate('date', '=', $today)
            ->count();

        $totalBreakfastCheckin = Booking::where('breakfast', '=', '2')
        ->whereDate('date', '=', $today)
        ->count();
        
        $totalLunchBooking = Booking::where('lunch', '=', '1')
            ->whereDate('date', '=', $today)
            ->count();

        $totalLunchCheckin = Booking::where('lunch', '=', '2')
        ->whereDate('date', '=', $today)
        ->count();
        
        $totalDinnerBooking = Booking::where('dinner', '=', '1')
            ->whereDate('date', '=', $today)
            ->count();
        

        $totalDinnerCheckin = Booking::where('dinner', '=', '2')
        ->whereDate('date', '=', $today)
        ->count();
        
        return view('admin.dashboard',[
            'totalBreakfastBooking' => $totalBreakfastBooking,
            'totalLunchBooking' => $totalLunchBooking,
            'totalDinnerBooking' => $totalDinnerBooking,

            'totalBreakfastCheckin' => $totalBreakfastCheckin,
            'totalLunchCheckin' => $totalLunchCheckin,
            'totalDinnerCheckin' => $totalDinnerCheckin,
        ]);
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');

    }
}
