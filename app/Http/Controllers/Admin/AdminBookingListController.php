<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminBookingListController extends Controller
{
    public function breakfast_index()
    {
        $users = User::where('role', 1)->get();
        // $today = Carbon::today();

        // $bookings = Booking::whereIn('user_id', $users->pluck('id'))
        // ->whereDate('created_at', $today)
        // ->latest()->get();

        $today = Carbon::today();
        $bookings = Booking::whereIn('user_id', $users->pluck('id'))
            ->whereDate('date', $today)
            ->latest()
            ->get();
        
        // dd($bookings);
    
        return view('admin.booking.breakfast-list', compact('bookings', 'users'));
    }

    public function lunch_index()
    {
        $users = User::where('role', 1)->get();
        // $today = Carbon::today();

        // $bookings = Booking::whereIn('user_id', $users->pluck('id'))
        // ->whereDate('created_at', $today)
        // ->latest()->get();

        $today = Carbon::today();
        $bookings = Booking::whereIn('user_id', $users->pluck('id'))
            ->whereDate('date', $today)
            ->latest()
            ->get();
        
        // dd($bookings);
    
        return view('admin.booking.lunch-list', compact('bookings', 'users'));
    }

    public function dinner_index()
    {
        $users = User::where('role', 1)->get();
        // $today = Carbon::today();

        // $bookings = Booking::whereIn('user_id', $users->pluck('id'))
        // ->whereDate('created_at', $today)
        // ->latest()->get();

        $today = Carbon::today();
        $bookings = Booking::whereIn('user_id', $users->pluck('id'))
            ->whereDate('date', $today)
            ->latest()
            ->get();
        
        // dd($bookings);
    
        return view('admin.booking.dinner-list', compact('bookings', 'users'));
    }
    
}
