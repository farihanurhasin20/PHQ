<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bonus;
use App\Models\Booking;
use App\Models\MealRate;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;

class MealRateController extends Controller
{
    public function index(Request $request)
    {
        $startDate='--/--/--';
        $endDate='--/--/--';
        $userNumber=0;
        $totalAmount=0;
        $rate=0;
        $mealRates = MealRate::orderBy('date', 'DESC')->paginate(10);
        $purchasesAll = MealRate::all();
        // $purchasesAmount=$purchasesAll->sum('grand_total');
        if ($request->filled('fromDate') && $request->filled('toDate')) {
            $start_date = $request->fromDate;
            $end_date = $request->toDate;
            $startDate = $start_date;
            $endDate = $end_date;
            $totalAmount = Bonus::whereBetween("date", [$start_date, $end_date])
                ->where('founding_source_id', 1)
                ->sum('amount');

            $userNumber = Booking::whereBetween("date", [$start_date, $end_date])->count();
            $rate = $userNumber > 0 ? $totalAmount / $userNumber : 0;
            $mealRates = MealRate::whereBetween("date", [$start_date, $end_date])->get();
            // $purchasesAmount = $mealRates->sum('grand_total');
        //    dd($totalAmount,$userNumber);
            $mealRates=MealRate::whereBetween("date", [$start_date, $end_date])->paginate(20);
        }

        $request->session()->put('startDate', $startDate);
        $request->session()->put('endDate', $endDate);
// dd($purchasesAmount,$purchases);
        // $datesFromController = $start_date;
        return view('admin.meal_rate.index', compact('mealRates','startDate','endDate','totalAmount','userNumber','rate'));
    }
    public function store(Request $request)
    {
        
        $today = Carbon::today();
        
        return response()->json([
            'status' => true,
            'message' => 'Purchase created successfully.'
        ]);
    }
    public function downloadPDF(Request $request)
    {
    
         
        $today = Carbon::today();
        $startDate = $request->session()->get('startDate');
        $endDate = $request->session()->get('endDate');
        $purchases = Bonus::whereBetween("date", [$startDate, $endDate])->get();
        $mealRates = MealRate::whereBetween("date", [$startDate, $endDate])->get();
        $booking = Booking::whereBetween("date", [$startDate, $endDate])->get();


        // dd($userId);
        
        $pdf = PDF::loadView('admin.meal_rate.pdf', [
          'purchase' => $purchases,
          'mealRates' => $mealRates,
          'booking' => $booking,
          'startDate' => $startDate,
          'endDate' => $endDate,
      ]);

      $fileName = 'CheckIN-List' . now()->format('Y-m-d_His') . '.pdf';
    //  return view('admin.meal_rate.pdf', [
    //         'purchase' => $purchases,
    //         'mealRates' => $mealRates,
    //         'booking' => $booking,
    //         'startDate' => $startDate,
    //         'endDate' => $endDate,
        
    //         ]
        
    //           );
      return $pdf->stream();
      }
    
}
