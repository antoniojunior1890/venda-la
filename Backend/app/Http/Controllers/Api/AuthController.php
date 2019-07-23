<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
             'email' => $request->email,
             'password' => bcrypt($request->password),
         ]);
        $token = auth()->login($user);
        return $this->respondWithToken($token);
    }
    
    public function login()
    {
        $credentials = request(['email', 'password']);
        $token       = auth()->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'Unauthorized']);
        }
        return $this->respondWithToken($token);
    }
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
