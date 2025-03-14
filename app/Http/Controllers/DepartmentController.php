<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\ActivationEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



class DepartmentController extends Controller
{
    // Show Add/Delete Department Page
    public function index()
    {
        return view('departments.manage');
    }

    // Add Department
    public function store(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'dep_name' => 'required|unique:departments,dep_name',
            'parent_department' => 'nullable|string',
        ]);

        // Check if a parent department is provided and find/create it
        $parentDepartmentId = null;
        if (!empty($request->parent_department)) {
            $parentDepartment = Department::firstOrCreate(
                ['dep_name' => $request->parent_department],
                ['parent_department' => null] // Set parent department of parent as null, if applicable
            );
            $parentDepartmentId = $parentDepartment->id;
        }

        // Create the new department with the parent department ID (if any)
        Department::create([
            'dep_name' => $request->dep_name,
            'parent_department' => $parentDepartmentId,
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Department added successfully!');
    }

    // Delete Department
    public function destroy(Request $request)
    {
        $request->validate([
            'dep_name' => 'required|exists:departments,dep_name',
        ]);

        $department = Department::where('dep_name', $request->dep_name)->firstOrFail();
        $department->delete();

        return redirect()->back()->with('success', 'Department deleted successfully!');
    }

    // Show Add Staff Form
    public function showAddStaffForm()
    {
        $departments = Department::all();
        return view('departments.add', compact('departments'));
    }

    // Handle Add Staff Form Submission
    public function addStaff(Request $request)
    {
        // Validate the request inputs
        $validator = Validator::make($request->all(), [
            'reg_no' => 'required|unique:users,reg_no',
            'user_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'dep_id' => 'required|exists:departments,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Generate a strong password
        $password = $this->generateStrongPassword();
        $hashedPassword = Hash::make($password);

        // Create or update the user
        $user = User::updateOrCreate(
            ['email' => $request->email],
            [
                'reg_no' => $request->reg_no,
                'user_name' => $request->user_name,
                'dep_id' => $request->dep_id,
                'password' => $hashedPassword,
                'is_student' => 0,
                'is_management' => 1,
                'is_super_admin' => 0,
            ]
        );

        // Send activation email if user was newly created
        if ($user->wasRecentlyCreated) {
            Mail::to($user->email)->send(new ActivationEmail($user, $password));
        }

        return redirect()->back()->with('success', 'Staff added and activation email sent successfully!');
    }

    // Generate a strong password
    private function generateStrongPassword($length = 8)
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()_+';

        $all = $uppercase . $lowercase . $numbers . $specialChars;

        $password = '';
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $specialChars[random_int(0, strlen($specialChars) - 1)];

        for ($i = 4; $i < $length; $i++) {
            $password .= $all[random_int(0, strlen($all) - 1)];
        }

        return str_shuffle($password);
    }
    public function show()
    {
        $user = Auth::user();
        return view('departments.profile', compact('user'));

    }

    public function updateinfo(Request $request, $id)
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