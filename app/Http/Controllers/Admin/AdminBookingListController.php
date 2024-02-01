<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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

    public function create($id){
        $user= User::find($id);
        return view('admin.booking.create',compact('user'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'id' => 'nullable',
            'date' => 'required',
        ]);
     
        if ($validator->passes()) {

            // Create a new user instance
            $datesString = $request->input('date');
            $datesArray = explode(',', $datesString);
        // dd($datesArray);
            $user= User::find($request->id);

            foreach ($datesArray as $date) {
                        
                $booking = Booking::whereDate('date', $date)
                ->where('user_id', $request->id)
                ->get()->first();
                if($booking == null){
                $booking = new Booking;
                $booking->user_id = $request->id;
                $booking->date = $date;
                
                $booking->breakfast = 1;
                $booking->booking_type = "By Admin";
                $b_scan=$this->generateQRCode($date,$user,"breakfast");
                // dd($b_scan);
                $booking->b_scan = $b_scan;
                $booking->lunch = 1;
                $l_scan=$this->generateQRCode($date,$user,"lunch");;
                $booking->l_scan = $l_scan;
                $booking->dinner = 1;
                $d_scan=$this->generateQRCode($date,$user,"dinnar");;
                $booking->d_scan = $d_scan;
                $booking->save();
                // Store each date in your database
                }   
            }

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

       private function generateQRCode($date, $user, $mealType)
    { 
        $formattedDate = date('YmdHis', strtotime($date));
        $qrCodeData =$user->bp_num . "-" .$formattedDate."-".   $mealType;
        // $qrCode = new QrCode($qrCodeData);
        return $qrCodeData;
    }

    public function breakfast_checkIn(Request $request)
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
                'message' => 'CheckedIn successfully',
            ]);
    }

    public function lunch_checkIn(Request $request)
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
                $bookings->lunch = 2;
                $bookings->save();

            }
            return response()->json([
                'status' => true,
                'message' => 'CheckedIn successfully',
            ]);
    }

    public function dinner_checkIn(Request $request)
    {
        $today = Carbon::today();

        $booking = Booking::whereDate('date', $today)
        ->whereIn('user_id', $request->user_ids)
        ->get();
        // dd($booking);
               
        // if($booking->breakfast == 2){
            
        //     return response()->json(['message' => 'already exists'], 200);
        // }
        foreach($booking as $bookings)
            if ($bookings) {
                $bookings->dinner = 2;
                $bookings->save();

            }
            return response()->json([
                'status' => true,
                'message' => 'CheckedIn successfully',
            ]);
    }
    
}
