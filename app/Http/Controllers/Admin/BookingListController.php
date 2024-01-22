<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class BookingListController extends Controller
{
    public function index()
    {
        $users = User::where('role', 1)->latest()->paginate(10);
    
        return view('admin.users.list', compact('users'));
    }
    

    public function edit($id){
        $users = User::where('id',$id)->get()->first();
        // dd($users);
        return view('admin.users.edit',compact('users'));

    }

    public function update(Request $request, $id){
        $users= User::find($id);

        if (empty($users)){
            session()->flash('error','User not found');
            return response()->json([
                'status'=> false,
                'message'=> 'User not found'
            ]);

        }
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'mobile' => 'required',
     
    
            ]);
            if($validator->passes()){
                $users -> name = $request->name;
                $users -> mobile = $request->mobile;
                $users -> rank = $request->rank;
                $users -> status = $request->status;
                $users->save();

                $request->session()->flash('success','User updated successfully');
                return response()->json([
                    'status'=>true,
                    'messege'=>'User updated successfully'
                ]);

            }else{
                return response()->json([
                    'status'  =>  false,
                    'errors'=>$validator->errors()
                ]);
                }
    }
}
