<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bonus;
use App\Models\Booking;
use App\Models\FundingSource;
use App\Models\Item;
use App\Models\ItemUnits;
use App\Models\MealRate;
use App\Models\Purchase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function getUnitOptions($itemId)
    {
        $item = Item::find($itemId);

        if ($item) {
            $unitOptions = $item->unit->items;
            return response()->json($unitOptions);
        }

        return response()->json(['error' => 'Item not found.'], 404);
    }
    public function index(Request $request)

    {
        $startDate = '--/--/--';
        $endDate = '--/--/--';

        $purchases = Purchase::orderBy('date', 'DESC')->paginate(10);
        $purchasesAll = Purchase::all();
        $purchasesAmount = $purchasesAll->sum('grand_total');

        $bonusAll = Bonus::all();
        $bonusAmount = $bonusAll->where('founding_source_id', '!=', 1)->sum('amount');

        if ($request->filled('fromDate') && $request->filled('toDate')) {
            $start_date = $request->fromDate;
            $end_date = $request->toDate;
            $startDate = $start_date;
            $endDate = $end_date;
            $purchases = Purchase::whereBetween("date", [$start_date, $end_date])->get();
            $purchasesAmount = $purchases->sum('grand_total');

            $bonus = Bonus::whereBetween("date", [$start_date, $end_date])->get();
            $bonusAmount = $bonus->where('founding_source_id', '!=', 1)->sum('amount');


            $purchases = Purchase::whereBetween("date", [$start_date, $end_date])->paginate(20);
        }

        // dd($purchasesAmount,$purchases);
        // $datesFromController = $start_date;
        return view('admin.purchase.index', compact('purchases', 'startDate', 'endDate', 'purchasesAmount', 'bonusAmount'));
    }

    public function create()
    {
        $itemUnits = ItemUnits::orderBy('unit_name', 'ASC')->get();
        $foundingSources = FundingSource::orderBy('source', 'ASC')->get();
        $items = Item::orderBy('item_name', 'ASC')->get();
        $generatedCode = $this->generateUniqueCode();
        // dd($generatedCode);

        return view('admin.purchase.create', compact('itemUnits', 'foundingSources', 'items', 'generatedCode'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'purchaseNumber' => 'required|string',
            'date' => 'required|date',
            'cartItems' => 'required|json',
            'bonusItems' => 'nullable|json',
        ]);
        if ($validator->passes()) {

            $cartItemsJson = $request->input('cartItems');

            // Decode the JSON string to an array
            $cartItemsArray = json_decode($cartItemsJson, true);

            $grandTotal = 0;
            $Source = 0;
            $memberSourceId = 0;
            foreach ($cartItemsArray as $item) {
                $purchase = new Purchase();
                $purchase->purchase_number = $request->input('purchaseNumber');
                $purchase->date = $request->input('date');
                $purchase->qty = $item['qty'] ?? null;
                $purchase->unit_price = $item['unit_price'] ?? null;
                $grandTotal = $item['unit_price'] * $item['qty'];
                $Source += $item['unit_price'] * $item['qty'];
                $purchase->grand_total = $grandTotal;
                $itemUnit = Item::find($item['item_id']);
                $purchase->founding_source_id = $item['founding_source_id'] ?? null;
                $memberSourceId = $item['founding_source_id'] ?? null;
                $purchase->item_id = $item['item_id'] ?? null;
                $purchase->item_unit_id = $itemUnit->item_units_id ?? null;
                // dd($purchase->toArray());
                $purchase->save();
            }

            $Bonus = 0;
            // Process bonus items
            $bonusItemsArray = json_decode($request->input('bonusItems'), true);
        // dd($request->all());
        
            foreach ($bonusItemsArray as $bonusItem) {
                if ($bonusItem['founding_source_id'] != "") {
                $bonus = Bonus::where('founding_source_id',$bonusItem['founding_source_id'])
                ->where('date',$request->input('date'))
                ->get()->first();
            
                if($bonus == null){
                
                
                    $bonus = new Bonus();
                    $Bonus += $bonusItem['amount'];
                    // Find the funding source
                    $fundingSource = FundingSource::find($bonusItem['founding_source_id']);

                    $bonus->founding_source_id = $bonusItem['founding_source_id'];
                    $bonus->amount = $bonusItem['amount'];
                    $bonus->date = $request->input('date');

                    $bonus->save();

                    // Subtract the amount from the current fund
                    $bonusFund = $fundingSource->current_fund;

                    $updatedBonusFund = $bonusFund - $bonusItem['amount'];

                    // Update the current fund of the funding source
                    $fundingSource->current_fund = $updatedBonusFund;
                    $fundingSource->save();
                }
                
                else
                {
                    $Bonus += $bonusItem['amount'];
                    // Find the funding source
                    $fundingSource = FundingSource::find($bonusItem['founding_source_id']);

                    $bonus->founding_source_id = $bonusItem['founding_source_id'];
                    $bonus->amount += $bonusItem['amount'];
                    $bonus->date = $request->input('date');

                    $bonus->save();

                    // Subtract the amount from the current fund
                    $bonusFund = $fundingSource->current_fund;

                    $updatedBonusFund = $bonusFund - $bonusItem['amount'];

                    // Update the current fund of the funding source
                    $fundingSource->current_fund = $updatedBonusFund;
                    $fundingSource->save();
                }
            }
            }


            $foundingSource = FundingSource::find($item['founding_source_id']);
            $currentFund = $foundingSource->current_fund;

            // Subtract the grand total from the current fund
            $updatedFund = $currentFund - $Source + $Bonus;
            // dd($updatedFund);

            // Update the current fund of the funding source
            $foundingSource->current_fund = $updatedFund;
            $foundingSource->save();

            $bonus = Bonus::where('founding_source_id',$memberSourceId)
            ->where('date',$request->input('date'))
            ->get()->first();
        
            if($bonus == null){
            $bonus = new Bonus();
            $bonus->founding_source_id =  $memberSourceId;
            $bonus->amount = $Source - $Bonus;
            $bonus->date = $request->input('date');
            $bonus->save();
            }else{
                
                $bonus->founding_source_id =  $memberSourceId;
                $bonus->amount += $Source - $Bonus;
            $bonus->date = $request->input('date');

                $bonus->save();
            }

            $mealRate = MealRate::where('date', $request->input('date'))->first(); // Use first() to get the first matching record

            if ($mealRate== null) {
                $mealRate = new MealRate();
                $mealRate->date = $request->input('date');
            }

            $amount = Bonus::where('date', $request->input('date'))
                ->where('founding_source_id', $item['founding_source_id'])
                ->sum('amount');

            $userNumber = Booking::where('date', $request->input('date'))->count();
            $amount = $userNumber > 0 ? $amount / $userNumber : 0;

            $mealRate->rate = $amount;

            $mealRate->save();


            // dd($foundingSource->toArray());
            $request->session()->flash('success', 'Purchase created successfully.');
            return response()->json([
                'status' => true,
                'message' => 'Purchase created successfully.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function getUnitId($item_id)
    {
        $itemUnit = Item::find($item_id);
        $itemUnit = ItemUnits::find($itemUnit->item_units_id);

        return response()->json($itemUnit);
    }

    public function generateUniqueCode()
    {
        $prefix = 'FM';
        $purchases = Purchase::orderBy('id', 'DESC')->first();

        if ($purchases) {
            $parts = explode('-', $purchases->purchase_number);
            $lastPart = end($parts);
            $nextValue = $lastPart + 1;
        } else {
            // If there are no purchases yet, set $nextValue to 1
            $nextValue = 1;
        }

        $currentYearMonth = date('Y-m');
        $paddedValue = str_pad($nextValue, 3, '0', STR_PAD_LEFT);
        $uniqueCode = $prefix . '-' . $currentYearMonth . '-' . $paddedValue;

        return $uniqueCode;
    }

    public function fundlist($date)
    {
        $availableFundings = Bonus::where('date', $date)
            ->latest('bonuses.id')
            ->leftJoin('funding_sources', 'funding_sources.id', '=', 'bonuses.founding_source_id')
            ->get();
        // dd($availableFundings);
        // if (!empty($request->get('keyword'))) {
        //     $keyword = $request->get('keyword');
        //     $availableFundings = $availableFundings->where(function ($query) use ($keyword) {
        //         $query->where('available_fundings.total_amount', 'like', '%' . $keyword . '%')
        //             ->orWhere('funding_sources.source', 'like', '%' . $keyword . '%');
        //     });
        // }

        // $availableFundings = $availableFundings->latest()->paginate(10);
        $foundingSource = Bonus::where('date', $date)->get();

        return view('admin.purchase.funding_list', compact('availableFundings'));
    }
    public function destroy($id,Request $request)
    {
        
        $Purchase = Purchase::find($id);
        // dd($Purchase); 
        if($Purchase == null)
        {
        $request->session()->flash('Error','Purchase not Found');
        return response()->json([
            'status'=>true,
            'message' =>'Category not Found'
        ]);
       }
       $bonus = Bonus::where('date',$Purchase->date)->where('founding_source_id',$Purchase->founding_source_id)->get()->first();

        dd($bonus); 
       
        $category->delete();

        $request->session()->flash('success','Category deleted successfully');
        return response()->json([
            'status'=>true,
            'message' =>'Category deleted successfully'
        ]);

    }
}
