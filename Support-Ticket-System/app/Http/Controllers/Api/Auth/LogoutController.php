<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        try {
            //revoke token for passport 
            $request->user()->token()->revoke();
            return response()->json([
                'status' => 1,
                'message' => 'You have been logged out successfully. Come back soon!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'error' => 'Oops! Something went wrong while logging out. Please try again later.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
