<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminBookingListController extends Controller
{
    public function index()
    {
        $users = User::where('role', 1)->get();
        // $today = Carbon::today();

        // $bookings = Booking::whereIn('user_id', $users->pluck('id'))
        // ->whereDate('created_at', $today)
        // ->latest()->get();

        $yesterday = now()->subDay(); 
        $bookings = Booking::whereIn('user_id', $users->pluck('id'))
            ->whereDate('created_at', $yesterday)
            ->latest()
            ->get();
        
        // dd($bookings);
    
        return view('admin.booking.list', compact('bookings', 'users'));
    }
    
}
