<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Schoolusers;
use App\Models\Schools;



use Illuminate\Http\Request;

use Auth;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('login_id', 'password');
        // echo $request->type;
        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();
            $schools = [];
            $request->session()->put('user.info', $user);
                        
            $role = User::leftJoin('roles','roles.id','=','users.role_id')->where('users.id', $user->id)->first('roles.name as roleName');
            $request->session()->put('user.role', $role->roleName);
            //echo $role->roleName;exit;
            if($role->roleName == 'FAO' || $role->roleName == 'APC') {
                // Find the district of this logged in User/Role if they are distrcit level officer.
                $district_details = User::leftJoin('districts','districts.id','=','users.district_id')->where('users.id', $user->id)->first('districts.*');    
                
                $district_details = User::leftJoin('districts','districts.id','=','users.district_id')->where('users.id', $user->id)->first('districts.*');
                // get all the schools and villages in this district
                $schoolResults = Schools::where('district_id', $user->district_id)->get();
                foreach($schoolResults as $school) {
                    $schools[] = $school->id;
                }
                $request->session()->put('user.schools', $schools);
            } else {

                $results = Schoolusers::where('user_id', $user->id)->get();
                foreach ($results as $res) {
                    $schools[] = $res->school_id;
                }
                $request->session()->put('user.schools', $schools);
            }

            // Get the session ID
            $sessionId = $request->session()->getId();
            if($request->type=='mobile') {
                // Return the authenticated user and session ID
                return response()->json([
                    'user' => $user,
                    'sessionId' => $sessionId
                ]);
            }
            


            return redirect()->intended('/home');
        } else {
            // Authentication failed
            // Perform error handling or redirection

            return redirect()->back()->withErrors([
                'message' => 'Invalid credentials',
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
