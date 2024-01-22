<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MealTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MealTimeController extends Controller
{
    public function index()
    {
        $mealTimes = MealTime::all();
        return view('admin.meal_times.list', compact('mealTimes'));
    }

    public function edit($id)
    {
        $mealTime = MealTime::where('id',$id)->get()->first();

        return view('admin.meal_times.edit', compact('mealTime'));
    }

    public function update(Request $request, $id)
    {
        $mealTime = MealTime::find($id);

        if (empty($mealTime)) {
            session()->flash('error', 'Meal Time not found');
            return response()->json([
                'status' => false,
                'message' => 'Meal Time not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'meal_type' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        if ($validator->passes()) {
            $mealTime->meal_type = $request->meal_type;
            $mealTime->start_time = $request->start_time;
            $mealTime->end_time = $request->end_time;
            $mealTime->save();

            $request->session()->flash('success', 'Meal Time updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'Meal Time updated successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
