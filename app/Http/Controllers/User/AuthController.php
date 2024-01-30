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

    public function index()
    {
        $user = Auth::user();
        if ($user && $user->role == 2) {
            $users = User::where('role', 1)->get();
            return response()->json(['data' => $users], 200);
        }
    }

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
            $errors = $validator->errors();

            $errorMessages = [];

            // Check each field for specific error messages
            if ($errors->has('mobile')) {
                $errorMessages[] = $errors->first('mobile');
            }

            if ($errors->has('bp_num')) {
                $errorMessages[] = $errors->first('bp_num');
            }

            // Add other fields as needed

            $responseMessage = implode(' and ', $errorMessages);

            return response()->json(['message' => $responseMessage], 200);
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
                $userData['mobile'] = $user->mobile;
                $userData['bp_number'] = $user->bp_num;
                $userData['image'] = $user->image;
                $userData['rank'] = $user->rank;

                return response()->json($userData, 200);
            }
        } else {
            return response()->json(['message' => 'Invalid credentials'], 200);
        }
    }
    
    public function resetPassword(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'old_password' => 'required',
            'new_password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
    
        // Find the user by ID
        $user = User::findOrFail($request->user_id);
    
        // Check if the old password matches the current password
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Old password is incorrect'], 400);
        }
    
        // Hash the new password
        $hashedPassword = Hash::make($request->new_password);
    
        // Update the user's password
        $user->password = $hashedPassword;
        $user->save();
    
        // You can return a response indicating success if needed
        return response()->json(['message' => 'Password reset successfully'], 200);
    }
    

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable',
            'mobile' => 'required|unique:users,mobile',
            // 'bp_num' => 'required|unique:users,bp_num|min:10',
            'rank' => 'nullable',
            'image' => 'nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            $errorMessages = [];

            // Check each field for specific error messages
            if ($errors->has('mobile')) {
                $errorMessages[] = $errors->first('mobile');
            }

            if ($errors->has('bp_num')) {
                $errorMessages[] = $errors->first('bp_num');
            }

            // Add other fields as needed

            $responseMessage = implode(' and ', $errorMessages);

            return response()->json(['message' => $responseMessage], 200);
        }

        $userData = $request->all();
        $user = User::find($request->user_id);

        $user->name =  $request->input('name');
        $user->mobile =  $request->input('mobile');
        $user->rank =  $request->input('rank');
        $user->image =  $request->input('image');
        $user->save();
        return response()->json(['message' => 'Profile updated successfully'], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful']);
    }
}
