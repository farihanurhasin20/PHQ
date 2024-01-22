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
        $tomorrow = Carbon::tomorrow();

        $todayBreakfastBooking = Booking::whereNotNull('breakfast')
            ->whereDate('date', '=', $today)
            ->count();
        $tomorrowBreakfastBooking = Booking::whereNotNull('breakfast')
        ->whereDate('date', '=', $tomorrow)
        ->count();

        $todayBreakfastCheckin = Booking::where('breakfast', '=', '2')
        ->whereDate('date', '=', $today)
        ->count();
        $tomorrowBreakfastCheckin = Booking::where('breakfast', '=', '2')
        ->whereDate('date', '=', $tomorrow)
        ->count();
        
        $todayLunchBooking = Booking::whereNotNull('lunch')
            ->whereDate('date', '=', $today)
            ->count();
        $tomorrowLunchBooking = Booking::whereNotNull('lunch')
        ->whereDate('date', '=', $tomorrow)
        ->count();

        $todayLunchCheckin = Booking::where('lunch', '=', '2')
        ->whereDate('date', '=', $today)
        ->count();
        $tomorrowLunchCheckin = Booking::where('lunch', '=', '2')
        ->whereDate('date', '=', $tomorrow)
        ->count();
        
        $todayDinnerBooking = Booking::whereNotNull('dinner')
            ->whereDate('date', '=', $today)
            ->count();
        $tomorrowDinnerBooking = Booking::whereNotNull('dinner')
        ->whereDate('date', '=', $tomorrow)
        ->count();
        

        $todayDinnerCheckin = Booking::where('dinner', '=', '2')
        ->whereDate('date', '=', $today)
        ->count();
        $tomorrowDinnerCheckin = Booking::where('dinner', '=', '2')
        ->whereDate('date', '=', $tomorrow)
        ->count();
        
        return view('admin.dashboard',[
            'todayBreakfastBooking' => $todayBreakfastBooking,
            'todayLunchBooking' => $todayLunchBooking,
            'todayDinnerBooking' => $todayDinnerBooking,
            'todayBreakfastCheckin' => $todayBreakfastCheckin,
            'todayLunchCheckin' => $todayLunchCheckin,
            'todayDinnerCheckin' => $todayDinnerCheckin,

            'tomorrowBreakfastBooking' => $tomorrowBreakfastBooking,
            'tomorrowLunchBooking' => $tomorrowLunchBooking,
            'tomorrowDinnerBooking' => $tomorrowDinnerBooking,
            'tomorrowBreakfastCheckin' => $tomorrowBreakfastCheckin,
            'tomorrowLunchCheckin' => $tomorrowLunchCheckin,
            'tomorrowDinnerCheckin' => $tomorrowDinnerCheckin,
        ]);
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');

    }
}
