<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    
      public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
      }
}
