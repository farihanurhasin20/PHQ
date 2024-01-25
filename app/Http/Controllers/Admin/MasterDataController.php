<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AvailableFunding;
use App\Models\FundingSource;
use App\Models\Item;
use App\Models\ItemUnits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterDataController extends Controller
{
    // Funding Source Crud
    public function fund_index()
    {
        $fundingSources = FundingSource::all();

        return view('admin.funding_sources.list', compact('fundingSources'));
    }

    public function fund_create()
    {
        return view('admin.funding_sources.create');
    }

    public function fund_store(Request $request)
    {
        $request->validate([
            'source' => 'required|unique:funding_sources|max:255',
        ]);

        FundingSource::create([
            'source' => $request->input('source'),
        ]);

        $request->session()->flash('success','Funding sources added successfully');
        return response()->json([
            'status'=>true,
            'messege'=>'Funding sources added successfully'
        ]);
    }

    // Funding history Crud
    public function fund_history_index(Request $request)
    {
        $availableFundings = AvailableFunding::select('available_fundings.*', 'funding_sources.source as fundingSource')
            ->latest('available_fundings.id')
            ->leftJoin('funding_sources', 'funding_sources.id', 'available_fundings.funding_source_id');

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');
            $availableFundings = $availableFundings->where(function ($query) use ($keyword) {
                $query->where('available_fundings.total_amount', 'like', '%' . $keyword . '%')
                    ->orWhere('funding_sources.source', 'like', '%' . $keyword . '%');
            });
        }

        $availableFundings = $availableFundings->latest()->paginate(10);

        return view('admin.fund_history.list', compact('availableFundings'));
    }

    public function fund_history_create()
    {
        $fundingSources = FundingSource::orderBy('source', 'ASC')->get();
        return view('admin.fund_history.create', ['fundingSources' => $fundingSources]);
    }

    public function fund_history_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'total_amount' => 'required|numeric',
            'funding_source' => 'required',
        ]);

        if ($validator->passes()) {
            $availableFunding = new AvailableFunding();
            $availableFunding->date = $request->input('date');
            $availableFunding->total_amount = $request->input('total_amount');
            $availableFunding->funding_source_id = $request->input('funding_source');

            $availableFunding->save();

            $request->session()->flash('success', 'New fund created successfully');

            return response([
                'status' => true,
                'message' => 'New fund created successfully',
            ]);
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    // Item Units Crud
        public function unit_index()
    {
        $itemUnits = ItemUnits::all();

        return view('admin.item_units.list', compact('itemUnits'));
    }

    public function unit_create()
    {
        return view('admin.item_units.create');
    }

    public function unit_store(Request $request)
    {
        $request->validate([
            'unit_name' => 'required|unique:item_units|max:255',
            'description' => 'nullable',
        ]);

        ItemUnits::create([
            'unit_name' => $request->input('unit_name'),
            'description' => $request->input('description'),
        ]);

        $request->session()->flash('success', 'Item unit added successfully');
        return response()->json([
            'status' => true,
            'message' => 'Item unit added successfully'
        ]);
    }


    // item Crud
    public function item_index(Request $request)
    {
        $items = Item::select('items.*', 'item_units.unit_name')
            ->latest('items.id')
            ->leftJoin('item_units', 'item_units.id', 'items.item_units_id');

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');
            $items = $items->where('items.item_name', 'like', '%' . $keyword . '%');
        }

        $items = $items->latest()->paginate(10);

        return view('admin.item.list', compact('items'));
    }

    public function item_create()
    {
        $itemUnits = ItemUnits::orderBy('unit_name', 'ASC')->get();
        return view('admin.item.create', ['itemUnits' => $itemUnits]);
    }

    public function item_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_units_id' => 'required',
            'item_code' => 'nullable',
            'item_name' => 'required',
        ]);

        if ($validator->passes()) {
            $item = new Item();
            $item->item_units_id = $request->input('item_units_id');
            $item->item_code = $request->input('item_code');
            $item->item_name = $request->input('item_name');

            $item->save();

            $request->session()->flash('success', 'New item created successfully');

            return response([
                'status' => true,
                'message' => 'New item created successfully',
            ]);
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

}
