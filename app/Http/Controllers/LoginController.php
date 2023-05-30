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
            // Perform additional logic if needed
            $user = Auth::user();
            // echo '<pre>';print_r($user);
            // Perform additional session-related tasks
            // ...
            $schools = [];
            $results = Schoolusers::where('user_id', $user->id)->get();
            foreach ($results as $res) {
                array_push($schools,$res->school_id);
            }
            $request->session()->put('users.schools', $schools);

            // Get the session ID
            $sessionId = $request->session()->getId();

            // echo '<pre>';print_r( $user);
            // echo $sessionId;
            // exit;
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
