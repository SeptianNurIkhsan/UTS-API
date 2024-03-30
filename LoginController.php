<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Lakukan proses otentikasi
        if (Auth::attempt($credentials)) {
            // Otentikasi berhasil, kembali dengan pesan sukses
            return response()->json([
                'message' => 'Login successful!'
            ], 200);
        }

        // Otentikasi gagal, kembali ke halaman login dengan pesan kesalahan
        return response()->json([
            'errors' => [
                'username' => ['Invalid credentials']
            ]
        ], 422);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully!'); // Tambahkan pesan success ke dalam flash session
    }
}