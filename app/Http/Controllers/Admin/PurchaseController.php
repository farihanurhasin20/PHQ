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
        // dd($request->all());
        $request->validate([
            'purchaseNumber' => 'required|string',
            'date' => 'required|date',
            'cartItems' => 'required|array|min:1', 
            'cartItems.*.qty' => 'required|integer',
            'cartItems.*.unit_price' => 'required|numeric',
            'cartItems.*.founding_source_id' => 'required',
            'cartItems.*.item_id' => 'required',
            'cartItems.*.item_unit_id' => 'required',
        ]);
        
        $cartItems = json_decode($request->input('cartItems'), true);
        dd($cartItems);
        foreach ($cartItems as $item) {
            $purchase = new Purchase();
            $purchase->purchase_number = $request->input('purchaseNumber');
            $purchase->date = $request->input('date');
            $purchase->qty = $item['qty'];
            $purchase->unit_price = $item['unit_price'];
            $purchase->founding_source_id = $item['founding_source_id'];
            $purchase->item_id = $item['item_id'];
            $purchase->item_unit_id = $item['item_unit_id'];
            $purchase->save();
        }

        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
    }
}
