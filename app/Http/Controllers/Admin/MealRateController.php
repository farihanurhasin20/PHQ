<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bonus;
use App\Models\Booking;
use App\Models\MealRate;
use App\Models\Purchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;

class MealRateController extends Controller
{
    public function index(Request $request)
    {
        $startDate = '--/--/--';
        $endDate = '--/--/--';
        $userNumber = 0;
        $totalAmount = 0;
        $rate = 0;
        $mealRates = MealRate::orderBy('date', 'DESC')->paginate(10);

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
            $mealRates = MealRate::whereBetween("date", [$start_date, $end_date])->paginate(20);
        }
        $today = Carbon::today();

        $mealRate = MealRate::where('date', $today)->first(); // Use first() to get the first matching record

        if ($mealRate == null) {
            $mealRate = new MealRate();
            $mealRate->date = $today;
        }

        $amount = Bonus::where('date', $today)
            ->where('founding_source_id', 1)
            ->sum('amount');

        $userNumber = Booking::where('date', $today)->count();
        $amount = $userNumber > 0 ? $amount / $userNumber : 0;

        $mealRate->rate = $amount;

        $mealRate->save();

        $request->session()->put('startDate', $startDate);
        $request->session()->put('endDate', $endDate);
        // dd($purchasesAmount,$purchases);
        // $datesFromController = $start_date;
        return view('admin.meal_rate.index', compact('mealRates', 'startDate', 'endDate', 'totalAmount', 'userNumber', 'rate'));
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
    public function checkinreport(Request $request)
    {
        $today = Carbon::now();
        $today = Carbon::createFromFormat('Y-m-d H:i:s', $today)->format('Y-m-d');
        $date = $today;
        // dd($date);

        if ($request->date != null) {
            $date = $request->date;
            // dd($request->date);

        }
        $users = User::where('role', 1)->latest();

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');
            $users = $users->where('id', 'like', '%' . $keyword . '%');
        }

        $users = $users->paginate(10);

        // $tomorrow = Carbon::tomorrow(); // Get tomorrow's date

        $bookings = Booking::whereIn('user_id', $users->pluck('id'))
            ->whereDate('date', $date) // Filter for tomorrow's date
            ->latest()
            ->get();
        $request->session()->put('date', $date);

        return view('admin.meal_rate.check_in_report', compact('bookings', 'users', 'date'));
    }
}
