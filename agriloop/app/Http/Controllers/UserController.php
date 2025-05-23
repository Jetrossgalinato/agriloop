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
            'id' => $user->id,
            'name' => $user->name,
            'location' => $user->location,
            'membership_status' => $user->membership_status,
            'email' => $user->email,
            'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : null, // Return full URL for avatar
        ], 200);
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update user fields
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->location = $request->input('location');

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Handle password update
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['message' => 'Current password is incorrect'], 400);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return response()->json(['message' => 'Profile updated successfully']);
    }
}
