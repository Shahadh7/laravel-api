<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'user_id' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'user_id' => $request->user_id,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function login(Request $request) {
        $request->validate([
            'user_id' => 'required',
            'password' => 'required',
            'remember_me' => 'boolean',
        ]);

        $user = User::where('user_id', $request->user_id)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $tokenName = 'auth-token';
        $abilities = ['*'];

        if ($request->boolean('remember_me')) {
            $token = $user->createToken($tokenName, $abilities, now()->addYear()); 
        } else {
            $token = $user->createToken($tokenName, $abilities, now()->addDay());
        }


        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken,
            'expires_at' => $token->accessToken->expires_at
        ]);
    }

    public function user(Request $request) {
        return $request->user();
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}

