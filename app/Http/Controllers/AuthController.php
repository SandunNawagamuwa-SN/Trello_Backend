<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUserRequest;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    
    public function register(RegisterUserRequest $request)
    {

        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $token = $user->createToken('tma-token')->plainTextToken;

        return response()->json(['status' => 'sucess', 'message' => 'registerd','user' => $user, 'token' => $token], 201);

    }

    public function logout(Request $request)
    {
        
        auth()->user()->tokens()->delete();

        return response()->json(['status' => 'sucess', 'message' => 'logged out'], 200);
    
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        //Check email
        $user = User::where('email', $validated['email'])->first();

        //Check Password
        if(!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['status' => 'error', 'message' => 'credientials not match'], 401);
        }

        $token = $user->createToken('tma-token')->plainTextToken;

        return response()->json(['status' => 'success', 'message' => 'logged in', 'user' => $user, 'token' => $token], 200);
    }
}
