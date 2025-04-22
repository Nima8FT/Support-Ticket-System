<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $inputs = $request->only('name', 'email', 'password');
            $inputs['password'] = Hash::make($inputs['password']);

            $user = User::create($inputs);

            //create token with passport package
            $token = $user->createToken('ticket')->accessToken;

            $response = $user->only('name', 'email');
            $response['token'] = $token;

            return response()->json([
                'status' => 1,
                'message' => 'User registered successfully.',
                'user' => $response,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'error' => 'Failed to register user. Please try again later.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
