<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        if (User::where('username', $data['username'])->exists()) {
            return response()->json([
                'errors' => [
                    'username' => [
                        'Username already registered.'
                    ]
                ]
            ], 400);
        }

        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function login(UserLoginRequest $request): UserResource
    {
        $data = $request->validated();

        $user = User::where('username', $data['username'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'errors' => [
                    'message' => [
                        'Username or password wrong.'
                    ]
                ]
            ], 401);
        }

        $user->update(['remember_token' => Str::uuid()->toString()]);

        return new UserResource($user);
    }


    public function get(Request $request): UserResource
    {
        $user = Auth::user();
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request): UserResource
    {
        $data = $request->validated();
        $user = Auth::user();

        if ($user instanceof User) {
            if (isset($data['name'])) {
                $user->name = $data['name'];
            }
            if (isset($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            $user->save();

            return new UserResource($user);
        } else {
            // Handle the case where Auth::user() doesn't return an instance of User
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }
    }


   public function logout(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        if ($user instanceof User) {
            $user->update(['remember_token' => null]);
        } else {
            // Handle the case where Auth::user() doesn't return an instance of User
            return response()->json([
                'error' => 'User not found'
            ], 404);
        }

        return response()->json([
            'data' => true
        ])->setStatusCode(200);
    }

    public function dashboard()
    {
        // Dapatkan pengguna yang diautentikasi
        $user = Auth::user();

        // Dapatkan daftar kontak dan alamat pengguna
        $contacts = $user->contacts;
        $addresses = $user->addresses;

        // Kirim data ke tampilan dashboard
        return View('dashboard', compact('user', 'contacts', 'addresses'));
    }
}