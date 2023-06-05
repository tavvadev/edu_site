<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoices;
use App\Models\InvoiceProducts;
use App\Models\User;
use App\Models\Schoolusers;
use App\Models\Schools;
use Illuminate\Support\Str;


use Auth;

class ApiController extends Controller
{
  public function login(Request $request)
  {
      $credentials = $request->only('login_id', 'password');
      // echo $request->type;
      if (Auth::attempt($credentials)) {
          // Authentication successful
          $user = Auth::user();
          $schools = [];
                      
          $role = User::leftJoin('roles','roles.id','=','users.role_id')->where('users.id', $user->id)->first('roles.name as roleName');
          //echo $role->roleName;exit;
          $user['roleName']= $role['roleName'];
          if($role->roleName == 'FAO' || $role->roleName == 'APC') {
              // Find the district of this logged in User/Role if they are distrcit level officer.
              $district_details = User::leftJoin('districts','districts.id','=','users.district_id')->where('users.id', $user->id)->first('districts.*');    
              
              $district_details = User::leftJoin('districts','districts.id','=','users.district_id')->where('users.id', $user->id)->first('districts.*');
              // get all the schools and villages in this district
              $schoolResults = Schools::where('district_id', $user->district_id)->get();
              foreach($schoolResults as $school) {
                  $schools[] = $school->id;
              }
              $user['schools'] = $schools;
          } else {

              $results = Schoolusers::where('user_id', $user->id)->get();
              foreach ($results as $res) {
                  $schools[] = $res->school_id;
              }
              $user['schools'] = $schools;
          }
          $uniqueId = Str::uuid()->toString();

              // Get the session ID
              // Return the authenticated user and session ID
              return response()->json([
                  'user' => $user,
                  'sessionId' => $uniqueId
              ]);
          


          return redirect()->intended('/home');
      } else {
          // Authentication failed
          // Perform error handling or redirection

          return redirect()->back()->withErrors([
              'message' => 'Invalid credentials',
          ]);
      }
  }
    //
    public function createOrder(Request $request){
      // echo '<pre>';print_r($request['products']); exit;
      // // echo $data['user'];exit;
      // echo '<pre>';print_r($data['user']['schools']);
      // print_r($data['user']['role']);
      // echo '<pre>';print_r($data['user']['info']->id);exit;
      //      echo '<pre>';
      //     print_r($request->all());exit; 
          $validator = \Validator::make($request->all(), 
          [
            //   'invoice_num'         =>     'required|min:1|regex:/^[a-zA-Z\s]*$/',
            //   'supplier_id'          =>     'required|min:1|',
              'school_id'            =>     'required|min:1|',
            //   'requester_id'         =>   'required|min:1|',
            //  'approved_by'          => 'required|min:1|',
            //  'total_qty'        => 'required|min:1|',
            //   'invoice_status'    =>'required|min:1|',
          ],
          [
              'invoice_num.required' => 'invoice_num is required',
            //   'supplier_id.required' => 'supplier_id format is invalid',
              'school_id.required' => 'school_id is required',
              'requester_id.required' => 'requester_id is required',
            //   'approved_by.required' => 'approved_by is required',
              'total_qty.required' => 'total_qty is required',
              'invoice_status.required' => 'invoice_status is required'
          ]
      );
      
      //dd($request->invoice_data);
      if ($validator->passes()) {
        $total = 0;
          foreach($request['products'] as $key =>$val){
            $total+=$val['quantity'];
          }
         // return response()->json(['status' => 200, 'Success' => 'Success']);
            $invoice_data = [ 
              'invoice_data'=>$request->invoice_data,
              'supplier_id'=>$request->supplier_id,
              'school_id'=>$request->school_id,
              'requester_id'=>$request->requester_id,
              // 'approved_by'=>$request->approved_by,
              'total_qty'=>$total,
              'invoice_status'=>$request->invoice_status
              ];
        //   echo '<pre>';print_r($request['products']); exit;         
          $invoice_data = Invoices::create($invoice_data);
          $invoice_id =  $invoice_data->id;
          
          foreach($request['products'] as $key =>$val){
              // echo $val;
              $invoice_pr_data = ['invoice_id'=>$invoice_id,'product_id'=>$val['product_id'],'quantity'=>$val['quantity']];
              $invoice_products = InvoiceProducts::create($invoice_pr_data);  
          }
          return response()->json([
            'message' => 'Order created successfully.',
            'order_id' => $invoice_id
        ]);
         
  
      }else{
          return response()->json(['status' => 401, 'error' => $validator->errors()]);
           
          }
      }
      public function ssss() {
        echo 'sadfasdf';exit;
    }
}
