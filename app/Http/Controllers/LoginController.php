<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Create this view to show the login form
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return $this->redirectBasedOnRole(Auth::user());
    }

    protected function redirectBasedOnRole($user)
    {
        if ($user->is_super_admin) {
            if ($user->user_name === 'SuperAdmin') {
                return redirect()->route('clearance.graph'); // Replace with the actual route for SuperAdmin
            } else {
                return redirect()->route('users.import-form'); // Replace with the actual route for other super admins
            }
        }


        if ($user->is_management) {

            switch ($user->dep_id) {
                case 4:
                    return redirect()->route('hq.hq'); 
                case 5:
                     return redirect()->route('it-division');
                case 6:
                    return redirect()->route('log.log'); 
                case 7:
                        return redirect()->route('fdss.fdss'); 
                case 8:
                     return redirect()->route('cadetmess.cadetmess'); 
                case 9:
                     return redirect()->route('publication.publication');
                case 10:
                    return redirect()->route('sods.sods');
                case 11:
                     return redirect()->route('tso.tso');
                case 12:
                    return redirect()->route('library.library');
                case 13:
                    return redirect()->route('accsec.accsec');
                case 14:
                    return redirect()->route('helpdesk.helpdesk');
                case 15:
                    return redirect()->route('enlistment.enlistment');
                case 16 :   
                    return redirect()->route('hostal.hostal');
                case 17:   
                    return redirect()->route('ARFDSS.ARFDSS');
                case 18:   
                    return redirect()->route('ARFMSH.ARFMSH');
                case 19:   
                    return redirect()->route('ARFOM.ARFOM');
                case 20:   
                    return redirect()->route('ARFOE.ARFOE');
                case 21:   
                    return redirect()->route('ARFOL.ARFOL');
                case 22:   
                    return redirect()->route('ARFAHS.ARFAHS');
                case 23:   
                    return redirect()->route('ARFOC.arfoc');
                case 24:   
                    return redirect()->route('ARBAS.ARBAS');
                case 25:   
                    return redirect()->route('ARFOT.ARFOT'); 
                case 27:   
                    return redirect()->route('ARFBESS.ARFBESS');        
    
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['email' => 'Unauthorized access.']);
            }
        }
        

        if ($user->is_student) {
            return redirect()->route('student.dashboard');
        }

        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Unauthorized access.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}