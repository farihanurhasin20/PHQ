<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    public function index()
      {
        return view('admin.login');
      }
     
      public function authenticate(Request $request){

        $validator = Validator::make($request->all(),[
            'mobile' => 'required|mobile',
            'password' => 'required'
    
      ]);
          
        if (Auth::guard('admin')->attempt(['mobile'=> $request ->mobile, 'password'=>
        $request->password],$request->get('remember'))) {

        $admin = Auth::guard('admin')->user();
      
              if($admin->role == 2){
                  return redirect()->route('admin.dashboard');
              }
              else{
                  Auth::guard('admin')->logout();
                  return redirect()->route('admin.login')->with('error','You are not authorized to access admin panel');
              }
              return redirect()->route('admin.dashboard');
              }

              else{
                return redirect()->route('admin.login')->with('error','Either Phone Number/Password is Incorrect');
              }
      }
      public function edit(){
        $admin = Auth::guard('admin')->user();
        $users = User::where('id', $admin->id)->get()->first();
        // dd($users);
        return view('admin.profile',compact('users'));
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
            'password'=>'nullable'
     
    
            ]);
            // dd($request->password);
            if($validator->passes()){
                $users -> name = $request->name;
                $users -> mobile = $request->mobile;
           
                if($request->password!=null){
                $users -> password = $request->password;
                }
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
      public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
      }
}
