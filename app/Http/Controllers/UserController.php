<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivationEmail;

class UserController extends Controller
{
    public function importForm()
    {
        return view('import-users');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        $path = $request->file('file')->store('uploads');

        $importer = new UsersImport();
        $invalidEmails = $importer->import(storage_path('app/' . $path));

        if (count($invalidEmails) > 0) {
            $message = 'Users imported, but some emails were invalid: ' . implode(', ', $invalidEmails);
            return back()->with('warning', $message);
        }

        return back()->with('success', 'Users imported and emails sent successfully.');
    }
}