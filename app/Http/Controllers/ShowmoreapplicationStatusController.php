<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Department;
use Illuminate\Http\Request;

class ShowmoreapplicationStatusController extends Controller
{
    public function show($id)
    {
        $application = Application::findOrFail($id);
        $statuses = $application->applicationStatus()
            ->with('department')
            ->whereHas('department', function($query) {
                $query->whereNotIn('id', [1, 2]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('applications.statuses', compact('application', 'statuses'));
    }
}