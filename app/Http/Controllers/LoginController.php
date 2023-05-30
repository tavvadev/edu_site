<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Schoolusers;


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

        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();
            $schools = [];
            $request->session()->put('user.info', $user);
            $results = Schoolusers::where('user_id', $user->id)->get();
            // echo '<pre>';print_r($results);exit;
            $role = User::leftJoin('roles','roles.id','=','users.role_id')->where('users.id', $user->id)->first('roles.name as roleName');

            foreach ($results as $res) {
                $schools[] = $res->school_id;
            }
            $request->session()->put('user.schools', $schools);
            $request->session()->put('user.role', $role->roleName);

            // Get the session ID
            $sessionId = $request->session()->getId();
            // Return the authenticated user and session ID
            // return response()->json([
            //     'user' => $user,
            //     'sessionId' => $sessionId
            // ]);


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
