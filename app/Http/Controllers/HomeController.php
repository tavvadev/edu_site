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
        $user = $request->session()->get('user.info');
        $schools = $request->session()->get('user.schools');
        $role = $request->session()->get('user.role');
        // echo $role;
        // echo '<pre>';print_r($schools);print_r($user->name);exit;

        return view('home');
    }
}
