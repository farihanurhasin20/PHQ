<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\MealTime;
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

    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'user_id' => 'required|string',
    //         'date' => 'required|array',
    //         'booking_type'=>'nullable|string',
    //         'breakfast' => 'nullable|string',
    //         'b_scan' => 'nullable|string',
    //         'lunch' => 'nullable|string',
    //         'l_scan' => 'nullable|string',
    //         'dinner' => 'nullable|string',
    //         'd_scan' => 'nullable|string',

    //     ]);
    
    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->errors()], 200);
    //     }
    //     // $user = Auth::user();
    //     // $today = Carbon::today();
    //     $bookings = Booking::where('user_id', $request->user_id)
    //     ->whereDate('date', $request->date)
    //     ->get()->first();


        
    //     if ($bookings != null) {
    //         return response()->json(['message' => 'Already Booked'], 200);
    //     }
       
    
    //     $bookingData = $request->all();
    
    //     $userId = Auth::id();
        
    
    //     // if (!empty($bookingData['breakfast'])) {
    //     //     $bookingData['b_scan'] = $this->generateQRCode($bookingData['date'], $userId, 'b');
    //     // }
    
    //     // if (!empty($bookingData['lunch'])) {
    //     //     $bookingData['l_scan'] = $this->generateQRCode($bookingData['date'], $userId, 'l');
    //     // }
    
    //     // if (!empty($bookingData['dinner'])) {
    //     //     $bookingData['d_scan'] = $this->generateQRCode($bookingData['date'], $userId, 'd');
    //     // }
    
    //     $booking = Booking::create($bookingData);
    
    //     return response()->json(['message' => 'Your meal has been booked successfully.', 'booking' => $booking], 200);
    // }
    
        public function store(Request $request)
    {
       
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|string',
                'dates' => 'required|array',
                'booking_type' => 'nullable',
                'dates.*' => 'date', // Validate each date in the array
                'breakfast' => 'nullable|string',
                'b_scan' => 'nullable|array',
                'lunch' => 'nullable|string',
                'l_scan' => 'nullable|array',
                'dinner' => 'nullable|string',
                'd_scan' => 'nullable|array',
            ]);
        
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 200);
            }
        
            $userId = Auth::id();
        
            foreach ($request->get('dates') as $key => $date) {
                $bookings = Booking::where('user_id', $request->user_id)
                    ->whereDate('date', $date)
                    ->get()->first();
        
                if ($bookings != null) {
                    return response()->json(['message' => 'Booking already exists for date ' . $date], 200);
                }
        
                $bookingData = [
                    'user_id' => $request->user_id,
                    'date' => $date,
                    'breakfast' => $request->breakfast,
                    'booking_type' => $request->booking_type,
                    'b_scan' => $request->b_scan[$key] ?? null,
                    'lunch' => $request->lunch,
                    'l_scan' => $request->l_scan[$key] ?? null,
                    'dinner' => $request->dinner,
                    'd_scan' => $request->d_scan[$key] ?? null,
                ];
        
                // Additional logic for generating QR codes can be added here if needed
        
                $booking = Booking::create($bookingData);
            }
        
            return response()->json(['message' => 'Your meals have been booked successfully.'], 200);
        
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
            'totalBreakfast' => Booking::whereNotNull('breakfast')->whereDate('date', $today)->count(),
            'totalBreakfastCheckedIn' => Booking::where('breakfast', '=', '2')->whereDate('date', $today)->count(),
            'totalLunch' => Booking::whereNotNull('lunch')->whereDate('date', $today)->count(),
            'totalLunchCheckedIn' => Booking::where('lunch', '=', '2')->whereDate('date', $today)->count(),
            'totalDinner' => Booking::whereNotNull('dinner')->whereDate('date', $today)->count(),
            'totalDinnerCheckedIn' => Booking::where('dinner', '=', '2')->whereDate('date', $today)->count(),
        ];
        
        // Counts for tomorrow
        $tomorrowCounts = [
            'totalBreakfast' => Booking::whereNotNull('breakfast')->whereDate('date', $tomorrow)->count(),
            'totalBreakfastCheckedIn' => Booking::where('breakfast', '=', '2')->whereDate('date', $tomorrow)->count(),
            'totalLunch' => Booking::whereNotNull('lunch')->whereDate('date', $tomorrow)->count(),
            'totalLunchCheckedIn' => Booking::where('lunch', '=', '2')->whereDate('date', $tomorrow)->count(),
            'totalDinner' => Booking::whereNotNull('dinner')->whereDate('date', $tomorrow)->count(),
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
            $meal = $request->meal;
            $date = $request->date;
        
            $bookings = Booking::whereIn('user_id', $users->pluck('id'))
                ->whereDate('date', $date)
                ->where(function ($query) use ($meal) {
                    $query->where($meal, '1')->orWhere($meal, '2');
                })
                ->latest()
                ->with('user') // Load the related user information
                ->get();
        
            // Transform the result to include user names and images
            $bookings = $bookings->map(function ($booking) {
                return [
                    'booking' => $booking,
                    // Add other fields as needed
                ];
            });
        
            return response()->json(['message' => 'Meal details', 'bookings' => $bookings], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        

    }

    public function checkIN(Request $request){
        $user = Auth::user();
        $parts = explode('-', $request->qrcode);
      
        $lastPart = end($parts);
        //  dd($lastPart); // breakfast
        if ($user && $user->role == 2) {
            $mealTypes = ['b_scan' => 'breakfast', 'l_scan' => 'lunch', 'd_scan' => 'dinner'];
    
            foreach ($mealTypes as $scanField => $mealType) {
                if($mealType == $lastPart){
                $booking = Booking::where($scanField, $request->qrcode)->first();
               
            if($booking->$mealType == 2){
                
                return response()->json(['message' => 'already exists'], 200);
            }
                if ($booking) {
                    $booking->$mealType = 2;
                    $booking->save();
    
                    return response()->json(['message' => $mealType . ' successfully checkedIn'], 200);
                }
            }
        }
            return response()->json(['message' => 'Failed CheckedIn'], 200);
        }
    
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function meal_time($id){

        $time = Carbon::now('Asia/Dhaka');
        $formattedTime = $time->format('H:i:s');
        $today = Carbon::today();
        $bookings = Booking::where('user_id', $id)
        ->whereDate('date', $today)
        ->latest()->first();

         if($bookings == null){
        return response()->json(['message' => 'No Meal booked Today','meal_name'=>null, 'meal_time'=> null,'qrcode' => null], 200);

         }
       
        $mealInfo = MealTime::whereRaw('? BETWEEN start_time AND end_time', [$formattedTime])->first();
      
        if($mealInfo == null){
            
            $mealInfoNext = MealTime::where('start_time', '>', $formattedTime)
            ->orderBy('start_time')
            ->first();
            if ($mealInfoNext) {
                $nextMealTime = Carbon::createFromFormat('H:i:s', $mealInfoNext->start_time)->format('h:i A');
                $message = 'No meal right now.';
                $qrCode=null;
            } else {
                $message = 'No upcoming meals Today.';
                $mealInfoNext=null;
                $nextMealTime=null;
                $qrCode=null;
            }
            
                return response()->json(['message' => $message, 'meal_name'=>$mealInfoNext->meal_type, 'meal_time'=> $nextMealTime,'qrcode' => $qrCode], 200);
        }  
        $user = Auth::user();
        $lastPart=$mealInfo->meal_type;
          
            $mealTypes = ['b_scan' => 'Breakfast', 'l_scan' => 'Lunch', 'd_scan' => 'Dinner'];
    
            foreach ($mealTypes as $scanField => $mealType) {
                if($mealType == $lastPart){
                $booking = Booking::where('user_id', $id)
                ->whereDate('date', $today)
                ->latest()->first();

            if($booking == null){
                return response()->json(['message' => 'No Meal Today','meal_name'=>null, 'meal_time'=> null,'qrcode' => null], 200);

            }
            $mealtype=strtolower($lastPart);
          
            // if($booking->$mealtype == 2){
                
            //     return response()->json(['message' => 'Meal done'], 200);
            // } 
            

    
                    return response()->json(['message' => $mealType ,'meal_name'=>$mealType, 'meal_time'=> $mealInfo->start_time, 'qrcode' => $booking->$scanField], 200);
                }
            }
        
        
    

    }
    public function mealDates($id){
        $today = Carbon::today();
        $booking = Booking::where('user_id', $id)
        ->whereMonth('date', $today)
        ->get();
        $bookingDates = $booking->pluck('date')->toArray();
        return response()->json([ 'date' => $bookingDates], 200);
    }
    
    public function mealDatesCancel(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'date' => 'required|array',
            
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 200);
        }
        $requestData = json_decode($request->getContent(), true);
        $datesToDelete = $requestData['date'];

       
        $today = Carbon::today();

       
        $bookingsToDelete = Booking::where('user_id', $request->user_id)
            ->whereIn('date', $datesToDelete)
            ->get();

        
        foreach ($bookingsToDelete as $booking) {
            $booking->delete();
        }

        // Optionally, you can return a response indicating success or failure
        return response()->json(['message' => 'Bookings deleted successfully.'], 200);
    }
}