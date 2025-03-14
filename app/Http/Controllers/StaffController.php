<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Show the staff creation form.
     */
    public function create()
    {
        return view('staff.create'); // No need to pass departments
    }

    /**
     * Store the newly added staff member.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reg_no' => 'required|string|unique:users,reg_no',
            'user_name' => 'required|string|max:255',
            'service_number' => 'required|string|unique:users,service_number',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Retrieve department ID from the logged-in user
        $loggedInUser = Auth::user();
        $departmentId = $loggedInUser->dep_id;

        User::create([
            'reg_no' => $request->reg_no,
            'user_name' => $request->user_name,
            'service_number' => $request->service_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'dep_id' => $departmentId, // Assigning department automatically
            'is_management' => true, // Mark user as staff
        ]);

        return redirect()->route('staff.create')->with('success', 'Staff member added successfully!');
    }
}