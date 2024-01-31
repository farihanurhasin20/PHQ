<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class BookingListController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 1)->latest();
        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');
            $users = $users->where('name', 'like', '%' . $keyword . '%');
        }
        // dd($users);
        $users = $users->paginate(10);
    
        return view('admin.users.list', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }
    

    public function edit($id){
        $users = User::where('id',$id)->get()->first();
        // dd($users);
        return view('admin.users.edit',compact('users'));

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable',
            'mobile' => 'required|unique:users,mobile',
            'bp_num' => 'required|unique:users,bp_num|min:10',
            'password' => 'required|min:6',
            'rank' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->passes()) {
            // Create a new user instance
            $user = new User([
                'name' => $request->input('name'),
                'mobile' => $request->input('mobile'),
                'bp_num' => $request->input('bp_num'),
                'password' => $request->input('password'),
                'rank' => $request->input('rank'),
            ]);

            // Handle image upload and save as base64
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $base64Image = base64_encode(file_get_contents($image->path()));
                $user->image = 'data:' . $image->getMimeType() . ';base64,' . $base64Image;
            }
            
            // Save the user to the database
            $user->save();

            $request->session()->flash('success', 'User created successfully');

            return response()->json([
                'status' => true,
                'message' => 'User created successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
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
                $users -> password = $request->password;
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
