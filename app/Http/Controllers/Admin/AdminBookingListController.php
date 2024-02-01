<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminBookingListController extends Controller
{
    public function breakfast_index(Request $request)
    {
        $users = User::where('role', 1)->latest();
       
        // $today = Carbon::today();

        // $bookings = Booking::whereIn('user_id', $users->pluck('id'))
        // ->whereDate('created_at', $today)
        // ->latest()->get();
        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');
            $users = $users->where('id', 'like', '%' . $keyword . '%');
        } 
        $users = $users->paginate(10);
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
        $users = User::where('role', 1)->latest();
        $users = $users->paginate(10);

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
        $users = User::where('role', 1)->latest();
        $users = $users->paginate(10);

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

    public function create(){
        return view('admin.booking.create');
    }
    public function checkIn(Request $request)
    {
        $today = Carbon::today();

        $booking = Booking::whereDate('date', $today)
        ->whereIn('user_id', $request->user_ids)
        ->get();
               
        // if($booking->breakfast == 2){
            
        //     return response()->json(['message' => 'already exists'], 200);
        // }
        foreach($booking as $bookings)
            if ($bookings) {
                $bookings->breakfast = 2;
                $bookings->save();

            }
            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
            ]);
    }
    
}
