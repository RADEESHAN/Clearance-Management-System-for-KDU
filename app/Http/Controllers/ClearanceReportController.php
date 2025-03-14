<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ClearanceReportController extends Controller
{
    public function showClearanceGraph(Request $request)
    {
        $filter = $request->input('filter', 'daily'); // Default to daily
        $endDate = Carbon::today();
        
        switch ($filter) {
            case 'monthly':
                $startDate = $endDate->copy()->startOfYear();
                $groupBy = 'DATE_FORMAT(created_at, "%Y-%m")';
                $dateFormat = 'Y-m';
                break;
            case 'yearly':
                $startDate = $endDate->copy()->subYears(5)->startOfYear();
                $groupBy = 'YEAR(created_at)';
                $dateFormat = 'Y';
                break;
            default: // daily
                $startDate = $endDate->copy()->subDays(29);
                $groupBy = 'DATE(created_at)';
                $dateFormat = 'Y-m-d';
                break;
        }

        $applications = Application::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw("$groupBy as date, COUNT(*) as count")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $dates = [];
        $counts = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $dateString = $currentDate->format($dateFormat);
            $dates[] = $dateString;
            $counts[] = $applications->where('date', $dateString)->first()->count ?? 0;
            
            switch ($filter) {
                case 'monthly':
                    $currentDate->addMonth();
                    break;
                case 'yearly':
                    $currentDate->addYear();
                    break;
                default:
                    $currentDate->addDay();
                    break;
            }
        }

        return view('clearance-graph', compact('dates', 'counts', 'filter'));
    }

    public function index()
    {
        $pendingStatusesByDepartment = DB::table('application_status')
            ->join('departments', 'application_status.department_id', '=', 'departments.id')
            ->where('application_status.status', 'Pending')
            ->select('departments.dep_name', DB::raw('count(*) as count'))
            ->groupBy('departments.id', 'departments.dep_name')
            ->get();
    
        return view('status-chart', compact('pendingStatusesByDepartment'));
    }

    public function duration()
    {
        $averageTimes = ApplicationStatus::select('department_id', 
            DB::raw('AVG(TIMESTAMPDIFF(SECOND, created_at, updated_at)) as average_time'))
            ->whereNotNull('updated_at')
            ->groupBy('department_id')
            ->get();

        $labels = [];
        $data = [];
        $timeUnit = 'seconds';

        foreach ($averageTimes as $avgTime) {
            $labels[] = Department::find($avgTime->department_id)->dep_name ?? 'Unknown';
            $seconds = $avgTime->average_time;

            if ($seconds >= 2592000) { // More than 30 days
                $data[] = round($seconds / 2592000, 2);
                $timeUnit = 'months';
            } elseif ($seconds >= 604800) { // More than 7 days
                $data[] = round($seconds / 604800, 2);
                $timeUnit = 'weeks';
            } elseif ($seconds >= 86400) { // More than 1 day
                $data[] = round($seconds / 86400, 2);
                $timeUnit = 'days';
            } elseif ($seconds >= 3600) { // More than 1 hour
                $data[] = round($seconds / 3600, 2);
                $timeUnit = 'hours';
            } elseif ($seconds >= 60) { // More than 1 minute
                $data[] = round($seconds / 60, 2);
                $timeUnit = 'minutes';
            } else {
                $data[] = round($seconds, 2);
                $timeUnit = 'seconds';
            }
        }

        return view('duration-chart', compact('labels', 'data', 'timeUnit'));
    }

    public function show()
    {
        $user = Auth::user();
        return view('user-profile', compact('user'));

    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validatedData = $request->validate([
            'user_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,'.$id,
            'reg_no' => 'sometimes|required|string|max:255|unique:users,reg_no,'.$id,
        ]);
    
        $user->update($validatedData);
    
        if ($request->ajax()) {
            return response()->json(['success' => 'Profile updated successfully']);
        }
    
    }
}