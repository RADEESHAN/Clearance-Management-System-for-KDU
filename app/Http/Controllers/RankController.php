<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rank;

class RankController extends Controller
{
    // Show the form for creating a new person
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $departmentId = Auth::user()->dep_id;
        return view('ranks.create', compact('departmentId'));
    }

    // Store a newly created person in storage
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'rank_name' => 'required|string|max:255',
            'person_name' => 'required|string|max:255',
            'service_number' => 'required|string|max:255', // Validate the service number
        ]);

        // Create a new rank entry
        Rank::create([
            'rank_name' => $request->rank_name,
            'person_name' => $request->person_name,
            'service_number' => $request->service_number, // Store the service number
            'department_id' => Auth::user()->dep_id,
        ]);

        return redirect()->route('ranks.create')->with('success', 'Person added successfully!');
    }

    public function getRanksByDepartment(Request $request)
    {
        $department_id = $request->input('department_id');
        $ranks = Rank::where('department_id', $department_id)->get();
        
        return response()->json($ranks);
    }

    public function getDepartments()
    {
        $departments = Department::all();
        return view('your-view-file', compact('departments'));
    }
}
