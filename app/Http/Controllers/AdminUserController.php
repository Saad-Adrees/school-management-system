<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    // Display the list of users
    public function index()
    {
        // Fetch all users except the current authenticated admin
        $users = User::where('id', '!=', auth()->id())->get();
        
        return view('admin.users.index', compact('users'));
    }

    // Update the specific user's role
    public function updateRole(Request $request, User $user)
    {
        // Validate the incoming request. Adjust the 'in:' roles if your database uses different names.
        $request->validate([
            'role' => 'required|string|in:admin,teacher,student',
        ]);

        // Update the user's role and save to the database
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'User role updated successfully!');
    }

    // Override specific user's password
    public function updatePassword(Request $request, User $user)
    {
        // Validate the incoming password
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Update and hash the password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully for ' . $user->name . '!');
    }
}