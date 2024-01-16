<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable',
            'mobile' => 'required|unique:users,mobile',
            'bp_num' => 'required|unique:users,bp_num|min:10',
            'password' => 'required|min:6',
            'rank' => 'nullable',
            'image' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 200);
        }

        $userData = $request->all();
    
        $user = User::create($userData);

        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json(['message' => 'User registered successfully'], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 200);
        }

        if (Auth::attempt(['mobile' => $request->input('mobile'), 'password' => $request->input('password')])) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;

            return response()->json(['id'=>$user->id, 'token' => $token, 'name' => $user->name,'bp_number' => $user->bp_num, 'image' => $user->image, 'rank' => $user->rank,'message' => 'Login successful'], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 200);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}
