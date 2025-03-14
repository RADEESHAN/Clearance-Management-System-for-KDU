<?php


namespace App\Http\Controllers;
use id;
use App\Models\User; 

use App\Models\Application;
use App\Models\StudentInfo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ApplicationStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;



class StudentDashboardController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the student's information along with the related faculty data
        $studentInfo = StudentInfo::with('faculty')->where('user_id', $user->id)->first();

        // Retrieve the application for the student
        $application = Application::where('student_id', $studentInfo->id)->first();

        // Retrieve all department statuses for this student's application
        $departmentStatuses = [];
        if ($application) {
            $departmentStatuses = ApplicationStatus::with('department', 'updater')
                ->where('application_id', $application->id)
                ->get();
                //->slice(2);
        }
  // Check if all departments have approved the application
$allApproved = collect($departmentStatuses)->every(function ($status) {
    return $status->status === 'APPROVED';
});
    // Pass the user, student information, application, department statuses, and allApproved status to the view
    return view('student.dashboard', compact('user', 'studentInfo', 'application', 'departmentStatuses', 'allApproved'));

    }
    public function management()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the student's information along with the related faculty data
        $studentInfo = StudentInfo::with('faculty')->where('user_id', $user->id)->first();

        // Retrieve the application for the student
        $application = Application::where('student_id', $studentInfo->id)->first();

        // Retrieve all department statuses for this student's application
        $departmentStatuses = [];
        if ($application) {
            $departmentStatuses = ApplicationStatus::with('department', 'updater')
                ->where('application_id', $application->id)
                ->get();
                //->slice(2);
        }

        // Pass the user, student information, application, and department statuses to the view
        return view('management.dashboard', compact('user', 'studentInfo', 'application', 'departmentStatuses'));
    }

    public function submitClearanceForm(Request $request)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Retrieve the student's information based on the authenticated user's ID
        $studentInfo = StudentInfo::where('user_id', $user->id)->first();

        // Validate the request data (Add validation rules as needed)
        $request->validate([
            // Add your validation rules here
            'bank' => 'required|string|max:255',
            'account_number' => 'required|string|max:255|confirmed',
        ]);

        // Update bank and account number in the StudentInfo table
        $studentInfo->bank = $request->bank; // Save Bank Name
        $studentInfo->account_number = $request->account_number; // Save Account Number
        $studentInfo->save();
        
        // Check if an application already exists for the student
        if (Application::where('student_id', $studentInfo->id)->exists()) {
            return redirect()->route('student.dashboard')->with('error', 'You have already submitted a clearance application.');
        }
        

        // Create a new application record
        $application = new Application();
        $application->student_id = $studentInfo->id;
        $application->user_name = $user->user_name; 
        $application->application_status = 'PENDING'; // Default status
        $application->created_by = $user->id;
        $application->updated_by = $user->id;
        $application->save();

        // Retrieve the student's faculty ID
        $studentFacultyId = $studentInfo->faculty_id;

        // Retrieve all departments, excluding those with dep_id 1, 2, and 3
        $departments = DB::table('departments')
        ->whereNotIn('id', [1, 2, 3, 14]) // Exclude departments with ID 1, 2, and 3
        ->where(function($query) use ($studentFacultyId) {
            $query->whereNull('faculty_id') // Include general departments
                  ->orWhere('faculty_id', $studentFacultyId); // Include departments related to the student's faculty
        })
        ->get();

        // Create an application status record for each remaining department
        foreach ($departments as $department) {
            $applicationStatus = new ApplicationStatus();
            $applicationStatus->application_id = $application->id;
            $applicationStatus->department_id = $department->id;
            $applicationStatus->status = 'PENDING'; // Initial status
            $applicationStatus->reason = '';
            $applicationStatus->created_by = $user->id;
            $applicationStatus->updated_by = $user->id;
            $applicationStatus->save();
        }

        // Redirect back with a success message
        return redirect()->route('student.dashboard')->with('success', 'Clearance application submitted successfully.');
    }

     // New method for downloading clearance PDF
     public function downloadClearancePDF()
     {
         // Retrieve the authenticated user
         $user = Auth::user();
     
         // Retrieve the student's information along with related faculty data
         $studentInfo = StudentInfo::with('faculty')->where('user_id', $user->id)->first();
     
         // Retrieve the application and its department statuses
         $application = Application::where('student_id', $studentInfo->id)->first();
     
         // Retrieve all department statuses related to this application
         $departmentStatuses = ApplicationStatus::with(['department', 'updater'])
             ->where('application_id', $application->id)
             ->get();
     
         // Filter the AR department related to the student's faculty and include all other non-AR departments
         $filteredDepartmentStatuses = $departmentStatuses->filter(function ($status) use ($studentInfo) {
             // Check if the department is an 'AR' related to the student's faculty
             $isARDepartment = Str::startsWith($status->department->dep_name, 'AR') &&
                               $status->department->faculty_id == $studentInfo->faculty->id;
     
             // Include all other non-AR departments
             $isNonARDepartment = !Str::startsWith($status->department->dep_name, 'AR');
     
             return $isARDepartment || $isNonARDepartment;
         });
     
         // Generate the PDF with the filtered department statuses
         $pdf = Pdf::loadView('pdf.clearance', [
             'user' => $user,
             'studentInfo' => $studentInfo,
             'application' => $application,
             'departmentStatuses' => $filteredDepartmentStatuses // Use the filtered collection
         ]);
     
         // Return the generated PDF for download
         return $pdf->download('clearance_form.pdf');
     }

     public function uploadReceipt(Request $request)
{
    $request->validate([
        'department_id' => 'required|exists:departments,id',
        'receipt' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $user = Auth::user();
    $studentInfo = StudentInfo::where('user_id', $user->id)->first();
    $application = Application::where('student_id', $studentInfo->id)->first();

    $applicationStatus = ApplicationStatus::where('department_id', $request->department_id)
        ->where('application_id', $application->id)
        ->firstOrFail();

    // Store the uploaded file
    $filename = 'receipt_' . $application->id . '_' . $request->department_id . '_' . time() . '.' . $request->file('receipt')->getClientOriginalExtension();
    $path = $request->file('receipt')->storeAs('receipts', $filename, 'public');

    // Append the new path to the existing array
    $receiptPaths = $applicationStatus->receipt_paths ?? [];
    $receiptPaths[] = $path;
    $applicationStatus->receipt_paths = $receiptPaths;

    $applicationStatus->save();

    return back()->with('success', 'Receipt uploaded successfully.');
}
     
}