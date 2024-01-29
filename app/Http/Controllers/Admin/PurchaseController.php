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
            'item_units_id' => 'required',
            'qty' => 'required|integer',
            'unit_price' => 'required|numeric',
            'founding_source_id' => 'required',
            'item_id' => 'required',
            'item_unit_id' => 'required',
        ]);

        $purchase = new Purchase();
        $purchase->purchase_number = $request->input('purchaseNumber');
        $purchase->date = $request->input('date');
        $purchase->item_units_id = $request->input('item_units_id');
        $purchase->qty = $request->input('qty');
        $purchase->unit_price = $request->input('unit_price');
        $purchase->founding_source_id = $request->input('founding_source_id');
        $purchase->item_id = $request->input('item_id');
        $purchase->item_unit_id = $request->input('item_unit_id');
        $purchase->save();

        return redirect()->route('purchases.create')->with('success', 'Purchase created successfully.');
    }
}
