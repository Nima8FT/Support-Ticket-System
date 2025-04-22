<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Auth\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only("email", "password");

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    "status" => 0,
                    "message" => "Unauthorized access. Please check your credentials and try again.",
                ]);
            }

            $user = Auth::user();

            //create token for passport
            $token = $user->createToken("ticket")->accessToken;

            $response = $user->only(["name", "email"]);
            $response["token"] = $token;

            return response()->json([
                "status" => 1,
                "message" => "Login successful. Welcome back!",
                "data" => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'error' => 'Failed to login user. Please try again later.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
