<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function index(){
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $events = array();
        
        $bookings = Booking::whereYear('date', $today->year) // Filter by year of today
                         ->get()
                         ->groupBy('date') // Group by date
                         ->map(function ($dates) {
                             return [
                                 "date" => $dates->first()->date, // Get the date
                                 "count" => $dates->count(), // Get count of each date
                             ];
                         });
        
        foreach ($bookings as $booking) {
            $color = '#007DFF59';
            $color1 = 'rgba(255, 134, 155 , 1)';
            $textcolor='black';
            // Check if the booking date is before or equal to today
            if (Carbon::parse($booking['date'])->lt($today)) {
                $events[] = [
                    'title' => 'Checked: ' . $booking['count'],
                    'start' => $booking['date'],
                    'end' => $booking['date'],
                    // 'rendering' => 'background', // Set rendering to background
                    'color' => $color1,
                    // 'textColor'=>$textcolor
                ];
            } else {
                $events[] = [
                    'title' => 'Booked: ' . $booking['count'],
                    'start' => $booking['date'],
                    'end' => $booking['date'],
                    'color' => $color,
                    // 'textColor'=>$textcolor

                ];
            }
        }
        
        // dd($events);
        // return view('calendar.index', ['events' => $events]);
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
            'events'=> $events,
        ]);
    }
    public function listByDate(Request $request){
        // dd($request->all());
                // dd($users);
                session()->put('date', $request->date);
                return response()->json([
                    'status' => true,
                    'message' => 'Purchase created successfully.'
                ]);
    }
    public function userListByDate(){
        $date = session('date');
        // dd($users);
      
        $booking = Booking::where('date', $date)
        ->latest();
        $bookingids = $booking->pluck('user_id')->toArray();
        $users = User::whereIn('id', $bookingids)
        
        ->latest()->paginate();
        // session()->forget('users');
        
        return view ('admin.booking.user-date-list',compact('users'));
    }
    public function masterdata_index(){
        return view ('admin.masterdata');
    }

    public function purchase_index(){
        return view ('admin.purchase.list');
    }

    public function reports_index(){
        return view ('admin.reports');
    }

    public function purchase_page(){
        return view ('admin.local-purchase');
    }
    public function calender(){
        return view ('admin.calender');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');

    }
}
