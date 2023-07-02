<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Schools;
use App\Models\Supplier;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function districtlevelreports(Request $request): View
    {
        $districts = DB::table('districts')->orderBy('dist_name', 'ASC')->get();
        return view('reports.districtlevel',compact('districts'));

    }

    public function mandallevelreports(Request $request): View
    {
        $districts = DB::table('districts')->orderBy('dist_name', 'ASC')->get();
        return view('reports.mandallevel',compact('districts'));

    }
}
