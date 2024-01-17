<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
// use BaconQrCode\Encoder\QrCode;

class BookingController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        
        $today = Carbon::today();
    
        $bookings = Booking::where('user_id', $user->id)
        ->whereDate('date', $today)
        ->latest()->first();
        // $yesterday = now()->subDay(); // Subtracts one day from the current date

        // $bookings = Booking::where('user_id', $user->id)
        //     ->whereDate('created_at', $yesterday)
        //     ->latest()
        //     ->first();
        
        return response()->json(['data' => $bookings], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
            'date' => 'required|string',
            'breakfast' => 'nullable|string',
            'b_scan' => 'nullable|string',
            'lunch' => 'nullable|string',
            'l_scan' => 'nullable|string',
            'dinner' => 'nullable|string',
            'd_scan' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 200);
        }
        $user = Auth::user();
        $today = Carbon::today();
        $bookings = Booking::where('user_id', $user->id)
        ->whereDate('created_at', $request->date)
        ->get()->first();

        
        if ($bookings != null) {
            return response()->json(['message' => 'Already Booked'], 200);
        }
       
    
        $bookingData = $request->all();
    
        $userId = Auth::id();
        $bookingData['user_id'] = $userId;
    
        // if (!empty($bookingData['breakfast'])) {
        //     $bookingData['b_scan'] = $this->generateQRCode($bookingData['date'], $userId, 'b');
        // }
    
        // if (!empty($bookingData['lunch'])) {
        //     $bookingData['l_scan'] = $this->generateQRCode($bookingData['date'], $userId, 'l');
        // }
    
        // if (!empty($bookingData['dinner'])) {
        //     $bookingData['d_scan'] = $this->generateQRCode($bookingData['date'], $userId, 'd');
        // }
    
        $booking = Booking::create($bookingData);
    
        return response()->json(['message' => 'Your meal has been booked successfully.', 'booking' => $booking], 200);
    }
    
    private function generateQRCode($date, $userId, $mealType)
    {
        $qrCodeData = substr($date, 0, 2) . $userId . $mealType;
        // $qrCode = new QrCode($qrCodeData);
        return $qrCodeData;
    }
    public function todayBookingCount()
    {
        
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        
        // Counts for today
        $todayCounts = [
            'totalBreakfast' => Booking::where('breakfast', '=', '1')->whereDate('date', $today)->count(),
            'totalBreakfastCheckedIn' => Booking::where('breakfast', '=', '2')->whereDate('date', $today)->count(),
            'totalLunch' => Booking::where('lunch', '=', '1')->whereDate('date', $today)->count(),
            'totalLunchCheckedIn' => Booking::where('lunch', '=', '2')->whereDate('date', $today)->count(),
            'totalDinner' => Booking::where('dinner', '=', '1')->whereDate('date', $today)->count(),
            'totalDinnerCheckedIn' => Booking::where('dinner', '=', '2')->whereDate('date', $today)->count(),
        ];
        
        // Counts for tomorrow
        $tomorrowCounts = [
            'totalBreakfast' => Booking::where('breakfast', '=', '1')->whereDate('date', $tomorrow)->count(),
            'totalBreakfastCheckedIn' => Booking::where('breakfast', '=', '2')->whereDate('date', $tomorrow)->count(),
            'totalLunch' => Booking::where('lunch', '=', '1')->whereDate('date', $tomorrow)->count(),
            'totalLunchCheckedIn' => Booking::where('lunch', '=', '2')->whereDate('date', $tomorrow)->count(),
            'totalDinner' => Booking::where('dinner', '=', '1')->whereDate('date', $tomorrow)->count(),
            'totalDinnerCheckedIn' => Booking::where('dinner', '=', '2')->whereDate('date', $tomorrow)->count(),
        ];
        
        return response()->json([
            'today' => $todayCounts,
            'tomorrow' => $tomorrowCounts,
        ], 200);
        
    }

    public function todayBookingList(Request $request)
    {
        $user = Auth::user();
        if ($user && $user->role == 2) {
        $users = User::where('role', 1)->get();
        $meal=$request->meal;

        $today = now(); 
        $bookings = Booking::whereIn('user_id', $users->pluck('id'))
        ->whereDate('date', $today)
        ->where(function ($query) use ($meal) {
            $query->where($meal, '1')->orWhere($meal, '2');
        })->latest()->get();
    
        
        return response()->json(['message' => 'meal deatails', 'bookings' => $bookings], 200);
    } else {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    } }