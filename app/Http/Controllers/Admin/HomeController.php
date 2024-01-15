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
        $totalBreakfast = Booking::where('breakfast','=','1')
        ->whereDate('created_at', '=', $today)->count();

        $totalLunch = Booking::where('lunch','=','1')
        ->whereDate('created_at', '=', $today)->count();

        $totalDinner = Booking::where('dinner','=','1')
        ->whereDate('created_at', '=', $today)->count();
        
        return view('admin.dashboard',[
            'totalBreakfast' => $totalBreakfast,
            'totalLunch' => $totalLunch,
            'totalDinner' => $totalDinner,
        ]);
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');

    }
}
