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
    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $data = User::orderBy('id','DESC');
        $data = $data->paginate(10);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            // 'login_id' => 'required|login_id|unique:users,login_id',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
    public function schoolprofile(): View
    {
        $data = request()->session()->all();
        // echo '<pre>';print_r($data['user']);
        $user = $data['user'];
        // echo $user['schools'][0];exit;
        $schoolDetails = Schools::leftjoin('school_users_relations as su','su.school_id','schools.id')
        ->where('schools.id',$user['schools'][0])
        ->leftjoin('users as u','su.user_id','u.id')
        ->leftjoin('villages as v','v.id','schools.village_id')
        ->leftjoin('districts as d','d.id','schools.district_id')
        ->leftjoin('mandals as m','m.id','v.mandal_id')
        ->select("schools.*","su.*","u.login_id","u.name as username","u.id as userId","v.village_name","m.mandal_name","d.dist_name")->first();
        // echo '<pre>'; print_r($schoolDetails);exit;
        return view('users.schoolprofile',compact('schoolDetails'));
    }

    public function updateSchoolprofile(Request $request)
    {  
        
        $validatedData = $request->validate([
            'school_category' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'hm_name' => 'required',
            'hm_contact_num' => 'required',
        ]);

        $loginUserId = session('user.info.id');
        
        $data = request()->session()->all();
        // echo '<pre>';print_r($data['user']);
        $user = $data['user'];
        // echo $user['schools'][0];exit;
        $schoolDetails = Schools::leftjoin('school_users_relations as su','su.school_id','schools.id')
        ->where('schools.id',$user['schools'][0])
        ->leftjoin('users as u','su.user_id','u.id')
        ->leftjoin('villages as v','v.id','schools.village_id')
        ->leftjoin('districts as d','d.id','schools.district_id')
        ->leftjoin('mandals as m','m.id','v.mandal_id')
        ->select("schools.*","su.*","u.login_id","u.name as username","u.id as userId","v.village_name","m.mandal_name","d.dist_name")->first();
        // echo '<pre>'; print_r($schoolDetails);exit;

        if($schoolDetails!=""){

            $schoolDetails_data = array(
                'school_category' => $request->school_category,
                'latitude' => "$request->latitude",
                'longitude' => "$request->longitude",
                'hm_name' => "$request->hm_name",
                'hm_contact_num' => "$request->hm_contact_num",
                'eng_name' => "$request->eng_name",
                'eng_contact' => "$request->eng_contact",
            );

            DB::table('schools')
            ->where('id', $user['schools'][0])
            ->update($schoolDetails_data);
            return redirect()->back()->with("success","School details updated successfully !");


        }else{
            $schoolDetails_data = array(
                'school_category' => $request->school_category,
                'latitude' => "$request->latitude",
                'longitude' => "$request->longitude",
                'hm_name' => "$request->hm_name",
                'hm_contact_num' => "$request->hm_contact_num",
                'eng_name' => "$request->eng_name",
                'eng_contact' => "$request->eng_contact",
            );
            Schools::create($schoolDetails_data);
            return redirect()->back()->with("success","Schools details created successfully !");
        }
    
    }

    public function changepassword(Request $request)
    {
        return view('users.change-password');
    }

    public function updateChangePassword(Request $request){

        $userId = session('user.info.id');
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        //Change Password
        $user = User::find($userId);
        $user->password =  Hash::make($request->get('new-password'));
       
        $user->save();

            
       
        return redirect()->back()->with("success","Password changed successfully !");
    
    }

    public function suppilerprofile(): View
    {  
        $supplier_details = DB::table('supplier_details')->where('supplier_id', session('user.info.id'))->first();
        return view('users.supplierprofile',compact('supplier_details'));
    }

    public function updatesuppilerprofile(Request $request)
    {  
        
        $validatedData = $request->validate([
            'firm_name' => 'required',
            'bank_account_number' => 'required',
            'bank_account_name' => 'required',
            'bank_ifsc' => 'required',
            'firm_pan_number' => 'required',
            'gst_number' => 'required',
            'aadhaar_number' => 'required',
        ]);

        $loginUserId = session('user.info.id');
        
        $Supplier_details_data = Supplier::where('supplier_id',$loginUserId)->first();

        if($Supplier_details_data!=""){

        $Supplier_details = array(
            'supplier_id' => $loginUserId,
            'firm_name' => $request->firm_name,
            'bank_account_number' => "$request->bank_account_number",
            'bank_account_name' => "$request->bank_account_name",
            'bank_ifsc' => "$request->bank_ifsc",
            'firm_pan_number' => "$request->firm_pan_number",
            'gst_number' => "$request->gst_number",
            'aadhaar_number' => "$request->aadhaar_number",
        );

        DB::table('supplier_details')
        ->where('supplier_id', $loginUserId)
        ->update($Supplier_details);
        return redirect()->back()->with("success","Supplier details updated successfully !");


    }else{

        $Supplier_details = array(
            'supplier_id' => $loginUserId,
            'firm_name' => $request->firm_name,
            'bank_account_number' => "$request->bank_account_number",
            'bank_account_name' => "$request->bank_account_name",
            'bank_ifsc' => "$request->bank_ifsc",
            'firm_pan_number' => "$request->firm_pan_number",
            'gst_number' => "$request->gst_number",
            'aadhaar_number' => "$request->aadhaar_number",
        );
        Supplier::create($Supplier_details);
        return redirect()->back()->with("success","Supplier details created successfully !");

    }
            
       
    
    }



    
}