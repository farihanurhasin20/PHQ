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
            'bp_num' => 'required',
            'password' => 'required|min:6',
            'rank' => 'nullable',
            'image' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $userData = [
            'name' => $request->input('name'),
            'mobile' => $request->input('mobile'),
            'bp_num' => $request->input('bp_num'),
            'password' => Hash::make($request->input('password')),
            'rank' => $request->input('rank'),
        ];
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageContent = base64_encode(file_get_contents($image->path()));
    
            $userData['image'] = $imageContent;
        }
    
        $user = User::create($userData);

        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json(['message' => 'User registered successfully', 'user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if (Auth::attempt(['mobile' => $request->input('mobile'), 'password' => $request->input('password')])) {
            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;

            return response()->json(['token' => $token, 'name' => $user->name, 'message' => 'Login successful'], 200);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}
