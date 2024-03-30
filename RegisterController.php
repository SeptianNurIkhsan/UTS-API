<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|confirmed',
        ]);

        // Create new user
        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();

        // You can customize the response according to your needs
        return response()->json(['message' => 'User registered successfully'], 201);
    }
}