<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{





    function register(Request $request)
    {
        $data = $request->validate([
            'login' => 'required|unique:users',
            'password' => 'required'
        ]);

        $user = User::create($data);

        if (!Auth::attempt($data)) {
            return;
        }

        $token = Auth::user()->createToken('auth-token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }


    function login(Request $request)
    {
        $data = $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($data)) {
            return;
        }

        $token = Auth::user()->createToken('auth-token')->plainTextToken;

        return response()->json(['user' => Auth::user(), 'token' => $token]);
    }
}
