<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// class ClearanceRequestController extends Controller
// {
//     public function index()
//     {
//         $user = Auth::user();
//         $departmentId = $user->dep_id;

//         // Eager load the related user and application status models
//         $applications = Application::with([
//                 'user:id,reg_no,user_name',
//                 'applicationStatus' => function ($query) use ($departmentId) {
//                     $query->where('department_id', $departmentId)
//                           ->select('id', 'application_id', 'status', 'department_id');
//                 }
//             ])
//             ->whereHas('applicationStatus', function ($query) use ($departmentId) {
//                 $query->where('department_id', $departmentId);
//             })
//             ->get(['id', 'student_id']);
        
//         return view('clearance-requests', compact('applications'));
//     }

//     public function updateStatus(Request $request, $id)
//     {
//         $user = Auth::user();
//         $departmentId = $user->dep_id;

//         // Find the application by ID and load the related application status for the user's department
//         $application = Application::with(['applicationStatus' => function ($query) use ($departmentId) {
//             $query->where('department_id', $departmentId);
//         }])->findOrFail($id);
        
//         // Check if the application status exists for this department
//         if (!$application->applicationStatus) {
//             return redirect()->back()->with('error', 'You are not authorized to update this application status.');
//         }

//         // Update the status of the related application status
//         $application->applicationStatus->status = $request->input('status');
//         $application->applicationStatus->updated_by = $user->id;
//         $application->applicationStatus->save();

//         // Redirect back with a success message
//         return redirect()->back()->with('success', 'Status updated successfully!');
//     }
// }