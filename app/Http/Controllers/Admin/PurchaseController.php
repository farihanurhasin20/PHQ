<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FundingSource;
use App\Models\Item;
use App\Models\ItemUnits;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::orderBy('date', 'DESC')->paginate(10); 

        return view('admin.purchase.index', compact('purchases'));
    }

    public function create()
    {
        $itemUnits = ItemUnits::orderBy('unit_name', 'ASC')->get();
        $foundingSources = FundingSource::orderBy('source', 'ASC')->get();
        $items = Item::orderBy('item_name', 'ASC')->get();

        return view('admin.purchase.create', compact('itemUnits', 'foundingSources', 'items'));
    }

    public function store(Request $request)
{
    $request->validate([
        'purchaseNumber' => 'required|string',
        'date' => 'required|date',
        'cartItems' => 'required|json', 
    ]);

    $cartItemsJson = $request->input('cartItems');

    // Decode the JSON string to an array
    $cartItemsArray = json_decode($cartItemsJson, true);

    $grandTotal = 0;
    $Source = 0;
    foreach ($cartItemsArray as $item) {
        $purchase = new Purchase();
        $purchase->purchase_number = $request->input('purchaseNumber');
        $purchase->date = $request->input('date');
        $purchase->qty = $item['qty'] ?? null;
        $purchase->unit_price = $item['unit_price'] ?? null;
        $grandTotal = $item['unit_price']*$item['qty'];
        $Source += $item['unit_price']*$item['qty'];
        $purchase->grand_total = $grandTotal;
        $purchase->founding_source_id = $item['founding_source_id'] ?? null;
        $purchase->item_id = $item['item_id'] ?? null;
        $purchase->item_unit_id = $item['item_unit_id'] ?? null;
        // dd($purchase->toArray());
        $purchase->save();

    }

    $foundingSource = FundingSource::find($item['founding_source_id']);
    $currentFund = $foundingSource->current_fund;

    // Subtract the grand total from the current fund
    $updatedFund = $currentFund - $Source;
    // dd($updatedFund);

    // Update the current fund of the funding source
    $foundingSource->current_fund = $updatedFund;
    $foundingSource->save();
    

    // dd($foundingSource->toArray());
    $request->session()->flash('success', 'Purchase created successfully.');
    return response()->json([
        'status' => true,
        'message' => 'Purchase created successfully.'
    ]);
   
}


}
