<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"
        ]);

        $newUser = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        return response()->json([
            "status" => true,
            "message" => "User created successfully",
            "user" => $newUser
        ]);
    }

    public function login(Request $request) {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $token = JWTAuth::attempt([
            "email" => $request->email,
            "password" => $request->password,
        ]);

        if(!empty($token)) {
            $userData = auth()->user();
            return response()->json([
                "status" => true,
                "message" => "User logged in successfully",
                "token" => $token,
                "user" => $userData
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Invalid credentials",
        ], 401);
    }

    public function profile() {
        $userData = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "User data",
            "user" => $userData
        ]);
    }

    public function refreshToken() {
        $newToken = auth()->refresh();

        return response()->json([
            "status" => true,
            "message" => "New token generated",
            "token" => $newToken
        ]);
    }

    public function logout() {
        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully"
        ]);
    }
}
