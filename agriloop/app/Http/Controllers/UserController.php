<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUserDetails($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'dietary_preferences' => $user->dietary_preferences,
            'allergies' => $user->allergies,
            'delivery_address' => $user->delivery_address,
            'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : null, // Return full URL for avatar
        ], 200);
    }
}
