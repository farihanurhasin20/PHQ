<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
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
        
        // $today = Carbon::today();
    
        // $bookings = Booking::where('user_id', $user->id)
        // ->whereDate('created_at', $today)
        // ->latest()->first();
        $yesterday = now()->subDay(); // Subtracts one day from the current date

        $bookings = Booking::where('user_id', $user->id)
            ->whereDate('created_at', $yesterday)
            ->latest()
            ->first();
        
        return response()->json(['data' => $bookings], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
    


}
