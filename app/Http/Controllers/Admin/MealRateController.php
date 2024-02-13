<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MealRate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MealRateController extends Controller
{
    public function index(Request $request)
    {
        $startDate='--/--/--';
        $endDate='--/--/--';
        
        $mealRates = MealRate::orderBy('date', 'DESC')->paginate(10);
        $purchasesAll = MealRate::all();
        // $purchasesAmount=$purchasesAll->sum('grand_total');
        if ($request->filled('fromDate') && $request->filled('toDate')) {
            $start_date = $request->fromDate;
            $end_date = $request->toDate;
            $startDate = $start_date;
            $endDate = $end_date;
            $mealRates = MealRate::whereBetween("date", [$start_date, $end_date])->get();
            // $purchasesAmount = $mealRates->sum('grand_total');
           
            $mealRates=MealRate::whereBetween("date", [$start_date, $end_date])->paginate(20);
        }
        //  $session->put('mealRates', $mealRates);
// dd($purchasesAmount,$purchases);
        // $datesFromController = $start_date;
        return view('admin.meal_rate.index', compact('mealRates','startDate','endDate'));
    }
    public function store(Request $request)
    {
        
        $today = Carbon::today();
        
        return response()->json([
            'status' => true,
            'message' => 'Purchase created successfully.'
        ]);
    }
}
