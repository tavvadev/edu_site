<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Schoolusers;


use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        // echo '<pre>';print_r($user);
        // Perform additional session-related tasks
        // ...
        $schools = [];
        $results = Schoolusers::where('user_id', $user->id)->get();
        foreach ($results as $res) {
            // echo $res->school_id.' --- '.$res->user_id.' <br/>';
            array_push($schools,$res->school_id);
        }
        $data = $request->session()->all();
        // echo '<pre>';print_r($data);exit;

        return view('home');
    }
}
