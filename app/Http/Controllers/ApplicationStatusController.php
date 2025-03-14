<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicationStatus;

class ApplicationStatusController extends Controller
{
    public function filter(Request $request)
{
    $query = ApplicationStatus::query();

    // Filter by approval status
    if ($request->has('approved') && !$request->has('rejected')) {
        $query->where('status', 'APPROVED');
    } elseif ($request->has('rejected') && !$request->has('approved')) {
        $query->where('status', 'REJECTED');
    } elseif ($request->has('approved') && $request->has('rejected')) {
        // Handle both approved and rejected statuses
        $query->whereIn('status', ['APPROVED', 'REJECTED']);
    }

    // Search by name, application ID, or registration number
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->whereHas('application.user', function($q) use ($search) {
            $q->where('user_name', 'like', "%{$search}%")
              ->orWhere('reg_no', 'like', "%{$search}%");
        })->orWhere('application_id', 'like', "%{$search}%");
    }
    
    $applicationStatuses = $query->get();
    $totalRequests = $applicationStatuses->count();

    return view('applications.index', compact('applicationStatuses', 'totalRequests'));
}

    
}
