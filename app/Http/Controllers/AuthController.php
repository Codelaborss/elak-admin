<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // --------------------------
    // 🔹 Login API
    // --------------------------
    public function login(Request $request)
    {
        // dd($request->all());
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();

        if (!$user->is_active) {
            return response()->json(['error' => 'Account not activated'], 403);
        }

        $token = $user->createToken('API Token')->accessToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $user
        ]);
    }

    // --------------------------
    // 🔹 Activate & Update User
    // --------------------------
  public function activateUser(Request $request)
{
    // Find user by ref_by
    $user = User::where('ref_by', $request->ref_by)->first();

    if (!$user) {
        return response()->json(['error' => 'User not found with this ref_by'], 404);
    }

    // Check if email already exists (excluding current user)
    if ($request->has('email')) {
        $exists = User::where('email', $request->email)
                      ->where('id', '!=', $user->id)
                      ->exists();
        if ($exists) {
            return response()->json(['error' => 'Email already exists'], 409);
        }
        $user->email = $request->email;
    }

    // Check if username already exists (excluding current user)
    if ($request->has('username')) {
        $exists = User::where('username', $request->username)
                      ->where('id', '!=', $user->id)
                      ->exists();
        if ($exists) {
            return response()->json(['error' => 'Username already exists'], 409);
        }
        $user->username = $request->username;
    }

    // Update other fields
    if ($request->has('name')) {
        $user->f_name = $request->name;
    }
    if ($request->has('password')) {
        $user->password = \Hash::make($request->password);
    }

    // Activate account
    $user->is_active = true;
    $user->save();

    return response()->json([
        'message' => 'Account activated successfully!',
        'user'    => $user
    ]);
}


    // --------------------------
    // 🔹 Get Logged-in User
    // --------------------------
    public function me()
    {
        return response()->json(Auth::user());
    }

    // --------------------------
    // 🔹 Logout
    // --------------------------
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
