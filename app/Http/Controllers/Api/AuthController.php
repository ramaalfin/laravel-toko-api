<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $attrs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $attrs['name'],
            'email' => $attrs['email'],
            'password' => Hash::make($attrs['password']),
        ]);

        $credential = $request->only('email', 'password');
        $token = auth()->guard('api')->attempt($credential);

        return response([
            'user' => $user,
            'code' => 200,
            'status' => true,
            'message' => 'Registrasi Berhasil',
            'token' => $token
        ], 200);
    }

    public function login(Request $request)
    {
        $attrs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (!Auth::attempt($attrs)) {
            return response([
                'message' => 'Login Gagal'
            ], 403);
        }

        $credential = $request->only('email', 'password');
        $token = auth()->guard('api')->attempt($credential);

        return response([
            'user' => auth()->guard('api')->user(),
            'code' => 200,
            'status' => true,
            'message' => 'Login Berhasil',
            'token' => $token
        ], 200);
    }

    public function user()
    {
        return response()->json([
            'user' => auth()->user()
        ], 200);
    }

    public function logout(User $user)
    {
        $user()->tokens()->delete();
        return response([
            'message' => 'Logout berhasil'
        ], 200);
    }

    

    // public function update(Request $request)
    // {
    //     $attrs = $request->validate([
    //         'name' => 'required|string',
    //     ]);

    //     $request->auth()->user()->update([
    //         'name' => $attrs['name'],
    //     ]);

    //     return response([
    //         'message' => 'User Diupdate',
    //         'user' => auth()->user()
    //     ], 200);
    // }
}
