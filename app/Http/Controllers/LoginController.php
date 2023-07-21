<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Schoolusers;
use App\Models\Schools;

use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
            } else if($role->roleName == 'Supplier') {
                $schoolResults = Schools::get();
                foreach($schoolResults as $school) {
                    $schools[] = $school->id;
                }
                // echo '<pre>';print_r($schools);exit;
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
            
            if(isset($user->password_changed) && $user->password_changed==0){
                 return redirect()->intended('change-password');
              }else{
                return redirect()->intended('/home');
              }


            
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

    public function forgotpassword()
    {
        if(isset($_POST['user_id']) && $_POST['user_id']!=""){

            $user = DB::select('SELECT * FROM users where login_id = "'.$_POST['user_id'].'"');

            $userAnswers = DB::select('SELECT * FROM user_answers where user_id = "'.$user[0]->id.'"');
            
            $question = DB::select('SELECT * FROM questions where id = "'.$userAnswers[0]->question_id.'"');

            return view('auth.passwords.forgotquestion',compact('user','userAnswers', 'question'));
        }else{
            return view('auth.passwords.email');
        }
       
    }

    public function forgotquestion()
    {
        if(isset($_POST['user_id']) && $_POST['user_id']!="" && isset($_POST['user_answer']) && $_POST['user_answer']!=""){

            $user_answers = DB::select('SELECT * FROM user_answers where user_id = "'.$_POST['user_id'].'" and answer = "'.$_POST['user_answer'].'"');

            if(count($user_answers) ==1){
                return view('auth.passwords.reset',compact('user_answers'));
            }
        }else{
            return view('auth.passwords.email');
        }
       
    }

    public function resetpassword()
    {
        if(isset($_POST['user_id']) && $_POST['user_id']!="" ){
            //Change Password
            $user = User::find($_POST['user_id']);
            $user->password =  Hash::make($_POST['password']);
            $user->password_changed =  1;
            $user->save();

        }else{
            return view('auth.passwords.email');
        }
       
    }

}
