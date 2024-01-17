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

    if (Auth::attempt($request->only('mobile', 'password'))) {
        $user = Auth::user();

        $userData = [
            'token' => $user->createToken('MyApp')->plainTextToken,
            'name' => $user->name,
            'role' => $user->role,
            'message' => 'Login successful',
        ];

        if ($user->role == 2) {
            return response()->json($userData, 200);
        } else {
            $userData['id'] = $user->id;
            $userData['bp_number'] = $user->bp_num;
            $userData['image'] = $user->image;
            $userData['rank'] = $user->rank;

            return response()->json($userData, 200);
        }
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
