<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\User;
use App\Models\Department;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\ApplicationStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;

class ClearanceController extends Controller
{
    public function index(Request $request, $departmentId)
    {
    
        // Get the selected rank from the request
        $selectedRank = $request->input('rank');
    
        // Query to fetch ApplicationStatus related to the department
        $query = ApplicationStatus::where('department_id', $departmentId);
    
        // Handle filtering by approved, rejected, or all
        if ($request->has('approved_requests') && !$request->has('rejected_requests') && !$request->has('all_requests')) {
            $query->where('status', 'APPROVED');
        } elseif ($request->has('rejected_requests') && !$request->has('approved_requests') && !$request->has('all_requests')) {
            $query->where('status', 'REJECTED');
        } elseif ($request->has('all_requests')) {
            // Do nothing, show all requests (no extra filter needed)
        }
    
        // Search by name, application ID, or registration number
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('application.user', function($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                ->orWhere('reg_no', 'like', "%{$search}%");
            })->orWhere('application_id', 'like', "%{$search}%");
        }
    
        // Get the total count of requests
        $totalRequests = $query->count();
    
        // Get the paginated results
        //$applicationStatuses = $query->with(['application.studentInfo', 'application.user'])->paginate(10);
            $applicationStatuses = $query->orderBy('created_at', 'desc')  // Order by the most recent
            ->with(['application.studentInfo', 'application.user',])
            ->paginate(10);

        // Load the related applications and users
        $applicationStatuses->load('application.user');
        $accountSection = Department::where('dep_name', 'Account section')->firstOrFail();
        // Check if the current department is Enlistment (assuming dep_id 16 is Enlistment)
        $isEnlistment = $departmentId == 15;
    
        // If it's Enlistment, check approval status for each application
        if ($isEnlistment) {
            foreach ($applicationStatuses as $status) {
                $status->allOthersApproved = $this->allOtherDepartmentsApproved($status->application_id, $departmentId);
            }
        }
    
        return view('Clearance.department', [
            'applicationStatuses' => $applicationStatuses,
            'totalRequests' => $totalRequests,
            'isEnlistment' => $isEnlistment,
            'departmentId' => $departmentId,
            'accountSectionDepId' => $accountSection->id, 

        ]);
    }
    
       // When creating or updating ApplicationStatus, include the person name
       public function updateStatus(Request $request, $departmentId, $statusId)
       {
           try {
               Log::info('Update status request data:', compact('departmentId', 'statusId', 'request'));
       
               // Fetch and validate the ApplicationStatus
               $status = ApplicationStatus::findOrFail($statusId);
               if ($status->department_id != $departmentId) {
                   return $this->handleError($request, 'Unauthorized action: Department ID mismatch.');
               }
       
               // Validate the status value
               $statusValue = $request->input('status');
               if (!in_array($statusValue, ['APPROVED', 'REJECTED'])) {
                   Log::warning('Invalid status value received:', compact('statusValue'));
                   return $this->handleError($request, 'Invalid status selected.');
               }
       
               // Retrieve the user's service number
               $departmentUser = Auth::user();  // Get logged-in department user
               $serviceNumber = $departmentUser->service_number;
               // Prepare data for update
               $data = [
                   'status' => $statusValue,
                   'updated_by' => Auth::id(),
                   'reason' => $statusValue === 'REJECTED' ? $request->input('reason') : null,
                   'service_number' => $serviceNumber, // Store the service number
               ];
       
               // Check for rejection reason
               if ($statusValue === 'REJECTED' && empty($data['reason'])) {
                   Log::warning('Rejection reason missing.');
                   return $this->handleError($request, 'Reason is required when rejecting an application.');
               }
       
               // Update within a transaction
               DB::beginTransaction();
               $status->update($data);
               $application = Application::findOrFail($status->application_id);
               DB::commit();
       
               Log::info('Status updated successfully:', compact('statusId'));
       
               // Log the action
               Log::info('Application status updated with service number:', [
                   'application_id' => $status->application_id,
                   'department_id' => $departmentId,
                   'status' => $statusValue,
                   'service_number' => $serviceNumber,
                   'updated_by' => Auth::id(),
               ]);
       
               // Success message
               $message = $statusValue === 'APPROVED'
                   ? 'Application approved successfully.'
                   : 'Application rejected successfully with reason: ' . $data['reason'];
       
               if ($request->expectsJson()) {
                   return response()->json(['success' => true, 'message' => $message]);
               }
       
               return redirect()->route('Clearance.list', ['departmentId' => $departmentId])
                                ->with('success', $message);
           } catch (\Exception $e) {
               DB::rollBack();
               Log::error('Error updating application status:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
               return $this->handleError($request, 'An error occurred while updating the status. Please try again.');
           }
       }
   
    /**
     * Handle error responses based on request type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    private function handleError(Request $request, $message)
    {
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => $message], 400);
        }
    
        return redirect()->back()->with('error', $message);
    }
    
    private function allOtherDepartmentsApproved($applicationId, $currentDepartmentId)
    {
        $otherStatuses = ApplicationStatus::where('application_id', $applicationId)
            ->where('department_id', '!=', $currentDepartmentId)
            ->pluck('status'); // Only get 'status' values
    
        // If there are no other departments, we assume approval is fine (i.e., return true).
        if ($otherStatuses->isEmpty()) {
            return true;
        }
    
        // Check if all other department statuses are 'APPROVED'
        return !$otherStatuses->contains(function ($status) {
            return $status !== 'APPROVED';
        });
    }
    

    public function generatePdf(Request $request, $departmentId, $statusId)
{
    // Validate input
    $request->validate([
        'pdf_reason' => 'required|string',
    ]);

    try {
        // Fetch the ApplicationStatus
        $status = ApplicationStatus::findOrFail($statusId);

        // Ensure the department matches
        if ($status->department_id != $departmentId) {
            return $this->handleError($request, 'Unauthorized action: Department ID mismatch.');
        }

        // Prepare data for PDF
        $data = [
            'application' => $status->application,
            'status' => $status,
            'pdf_reason' => $request->input('pdf_reason'),
            'user' => Auth::user(),
        ];

        // Generate PDF using a Blade view
        $pdf = PDF::loadView('pdf.application', $data);

        // Define the file path
        $fileName = 'application_' . $status->application_id . '_' . $departmentId . '.pdf';
        $filePath = 'pdfs/' . $fileName;

        // Save PDF to storage (public disk)
        Storage::disk('public')->put($filePath, $pdf->output());

        // Update the ApplicationStatus with PDF info
        $status->update([
            'pdf_path' => $filePath,
            'pdf_reason' => $request->input('pdf_reason'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'PDF generated and saved successfully.',
            'pdf_url' => Storage::url($filePath),
        ]);
    } catch (\Exception $e) {
        Log::error('Error generating PDF:', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        return $this->handleError($request, 'An error occurred while generating the PDF. Please try again.');
    }
}

public function viewHostelPdf($applicationId)
    {
        return $this->viewPdf($applicationId, 16); // 25 is the department ID for Hostel
    }

    public function viewLibraryPdf($applicationId)
    {
        return $this->viewPdf($applicationId, 12); // 12 is the department ID for Library
    }

    private function viewPdf($applicationId, $departmentId)
    {
        try {
            $fileName = "application_{$applicationId}_{$departmentId}.pdf";
            $filePath = "pdfs/{$fileName}"; // Path relative to storage/app/public/
    
            if (!Storage::disk('public')->exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'PDF file not found.',
                ], 404);
            }
    
            // Generate public URL for the file
            $pdfUrl = asset("storage/{$filePath}");
    
            // Log the PDF access
            Log::info("PDF accessed", [
                'user_id' => Auth::id(),
                'application_id' => $applicationId,
                'department_id' => $departmentId,
                'file_name' => $fileName,
            ]);
    
            return response()->json([
                'success' => true,
                'pdf_url' => $pdfUrl,
            ]);
        } catch (\Exception $e) {
            Log::error('Error viewing PDF:', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the PDF.',
            ], 500);
        }
    }
    

    public function getReceipts(Request $request, $applicationId)
{
    try {
        // Fetch all application statuses for this application
        $statuses = ApplicationStatus::where('application_id', $applicationId)
                        ->with('department')
                        ->get();

        $receiptData = [];
        
        foreach ($statuses as $status) {
            if ($status->receipt_paths) {
                $departmentName = strtolower($status->department->dep_name);
                $receiptData[$departmentName] = [
                    'paths' => $status->receipt_paths,
                    'urls' => array_map(function($path) {
                        return Storage::url($path);
                    }, $status->receipt_paths)
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $receiptData
        ]);

    } catch (\Exception $e) {
        Log::error('Error fetching receipts:', ['message' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while fetching receipts.',
        ], 500);
    }
}
}