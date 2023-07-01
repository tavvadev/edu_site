<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoices;
use App\Models\InvoiceProducts;
use App\Models\User;
use App\Models\Schoolusers;
use App\Models\Schools;
use App\Models\Category;
use App\Models\Product;
use App\Models\DistrictSuppliers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        $total_price = 0;
        foreach($request['products'] as $key =>$val){
            if($val['quantity']!='') {
                $product = Product::find($val['product_id']);
                $total_price+=$product['price']*$val['quantity'];
                $total+=$val['quantity'];
            }
        }
         // return response()->json(['status' => 200, 'Success' => 'Success']);
            $invoice_data = [ 
              'invoice_data'=>$request->invoice_data,
              'supplier_id'=>$request->supplier_id,
              'school_id'=>$request->school_id,
              'requester_id'=>$request->requester_id,
              // 'approved_by'=>$request->approved_by,
              'total_qty'=>$total,
              'total_price'=>$total_price,
              'order_category' => $request->category,
              'invoice_status'=>0
              ];
          $invoice_data = Invoices::create($invoice_data);
          $invoice_id =  $invoice_data->id;

          foreach($request['products'] as $key =>$val){
            if($val['quantity']!='') {
                $product = Product::find($val['product_id']);
                $invoice_pr_data = ['invoice_id'=>$invoice_id,'product_id'=>$val['product_id'],'quantity'=>$val['quantity'],'price'=>$product['price']*$val['quantity']];
                $invoice_products = InvoiceProducts::create($invoice_pr_data);
            }

        }
            $school_details = Schools::where('id',$request->school_id)->first();
           
            $supplier_details = DistrictSuppliers::where('dist_id', $school_details['district_id'])->first();
            $order = Invoices::find($invoice_id);
            $order->supplier_id = $supplier_details['supplier_id'];
            $order->invoice_num = $request->login_id.$invoice_id;
            $order->save();
          return response()->json([
            'message' => 'Order created successfully.',
            'order_id' => $invoice_id
        ]);
         
  
      }else{
          return response()->json(['status' => 401, 'error' => $validator->errors()]);
           
          }
      }
      public function orders(Request $request) {
        $user_id = $request->user_id;
        $schools =[];
        // Get the schools using the user id.....
        $role = User::leftJoin('roles','roles.id','=','users.role_id')->where('users.id', $user_id)->first('roles.name as roleName');
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
            } else {

                $results = Schoolusers::where('user_id', $user_id)->get();
                foreach ($results as $res) {
                    $schools[] = $res->school_id;
                }
            }
        $orders = Invoices::leftjoin('schools as s',"orders.school_id","=",'s.id')
        ->leftjoin('districts as d',"s.district_id","=",'d.id')
        ->leftjoin('villages as v',"s.village_id","=",'v.id')
        ->leftjoin('users as u',"orders.supplier_id","=",'u.id')
        ->leftjoin('categories as c',"c.id","=",'orders.order_category')
        ->whereIn('s.id', $schools)->select("d.dist_name","v.village_name","s.school_name","s.hm_name","s.hm_contact_num","s.UDISE_code","s.code","orders.id as orderId",'c.cat_name','orders.id as oid','orders.invoice_num as order_num','orders.total_qty','orders.invoice_status','s.school_name','s.UDISE_code','s.hm_name',"s.hm_contact_num","orders.apc_approved_status","orders.invoice_status","u.name as supplierName","u.contact_number as supplierNumber")
        ->get();
        $allOrders = [];
        foreach($orders as $order) {
            $allOrders[$order->orderId] = $order;
            $results = InvoiceProducts::leftjoin('products as p',"order_products.invoice_id","=",'p.id')->where('invoice_id', $order->orderId)
            ->select("p.name as product_name","p.units","order_products.*")->get();
            $allOrders[$order->orderId]['products'] = $results;
        }
        $totalOrders = count($allOrders);
        $allResults['orders'] = $allOrders;
        $allResults['total'] = $totalOrders;
        return response()->json($allResults);
    }
    public function categories() {
        $categories = Category::orderBy('id','DESC')->get();
        return response()->json($categories);
    }
    public function getproducts(Request $request) {
        // echo '<pre>';print_r($request->id);exit;
        $products = Product::select('*')
        ->where('category_id', '=', $request->id)
        ->get();
        return response()->json($products);
    }
    public function updateorder(Request $request){
        $data = $request->all();
        // echo '<pre>';print_r( $data );exit;
            foreach($request->ack_qty as $product_id=>$del_qty) {
                DB::table('order_products')
                ->where('invoice_id', $request->order_id)
                ->where('product_id', $product_id)
                ->update([
                'ack_qty' => $del_qty
                ]);
                }
    
                // echo '<pre>';print_r($request->all());exit;
                $order = Invoices::find($request->order_id);
                $order->invoice_status = $request->order_status?$request->order_status:2;
                $order->reason = $request->reason?$request->reason:"";
                $order->ack_date = date('Y-m-d H:i:s');
                $order->save();
                return response()->json([
                    'message' => 'Order updated successfully.',
                    'order_id' => $request->order_id
                ]);
    }
    public function viewOrder(Request $request, $param) {
        
        $orderId = $param;
        $orderDetails = Invoices::leftjoin('schools as s',"orders.school_id","=",'s.id')
        ->leftjoin('districts as d',"s.district_id","=",'d.id')
        ->leftjoin('villages as v',"s.village_id","=",'v.id')
        ->leftjoin('categories as c',"c.id","=",'orders.order_category')
        ->leftjoin('users as u',"orders.supplier_id","=",'u.id')
        ->where('orders.id', $orderId)->select("d.dist_name","c.cat_name","v.village_name","orders.*","orders.id as orderId","s.school_name","s.hm_name","s.hm_contact_num","u.name as supplierName","u.contact_number as supplierNumber")
        ->first();
            $results = InvoiceProducts::leftjoin('products as p',"order_products.product_id","=",'p.id')->where('invoice_id', $orderId)
            ->select("p.name as product_name","p.units","order_products.product_id as pid","p.price as productPrice","order_products.*")->get();
            $orderDetails['products'] = $results;
        return response()->json([
            'message' => 'Order updated successfully.',
            'orderDetails' => $orderDetails
        ]);
    }

    public function district() {
        $districts = DB::table('districts')->orderBy('dist_name', 'ASC')->get();
        return response()->json([
            'status' => '200',
            'districts' => $districts
        ]);
    }

    public function mandals() {
        $params = (array) json_decode(file_get_contents('php://input'), TRUE);
        if(isset($params['district']) && $params['district']!=""){
            $mandals = DB::table('mandals')
            ->where('dist_id', $params['district'])
            ->orderBy('mandal_name', 'ASC')->get();
            if(count($mandals) ==0){
                return response()->json(['status' => '404', 'message' => 'Invalid district id',  'mandals' => []]);
            }else{
                return response()->json(['status' => '200', 'message' => 'success',  'mandals' => $mandals]);
            }
         }else{
                return response()->json(['status' => '404', 'message' => 'Please select district', 'mandals' => []]);
         }
    }

    public function villages() {
        $params = (array) json_decode(file_get_contents('php://input'), TRUE);

        if(isset($params['district_id']) && $params['district_id']==""){
            return response()->json(['status' => '200', 'message' => 'Please select district', 'villages' => []]);
        } 
        
        if(isset($params['mandal_id']) && $params['mandal_id']==""){
            return response()->json(['status' => '200', 'message' => 'Please select mandal', 'villages' => []]);
        }

        if(isset($params['district_id']) && $params['district_id']!="" && isset($params['mandal_id']) && $params['mandal_id']!=""){
            $villages = DB::table('villages')
            ->where('district_id', $params['district_id'])
            ->where('mandal_id', $params['mandal_id'])
            ->orderBy('village_name', 'ASC')->get();
            if(count($villages) ==0){
                return response()->json(['status' => '404', 'message' => 'Invalid district id',  'villages' => []]);
            }else{
                return response()->json(['status' => '200', 'message' => 'success',  'villages' => $villages]);
            }
         }else{
                return response()->json(['status' => '404', 'message' => 'Please select district', 'villages' => []]);
         }
    }


    public function schools() {
        $params = (array) json_decode(file_get_contents('php://input'), TRUE);

        if(isset($params['district_id']) && $params['district_id']==""){
            return response()->json(['status' => '200', 'message' => 'Please select district', 'schools' => []]);
        } 
        
        if(isset($params['village_id']) && $params['village_id']==""){
            return response()->json(['status' => '200', 'message' => 'Please select village', 'schools' => []]);
        }

        if(isset($params['district_id']) && $params['district_id']!="" && isset($params['village_id']) && $params['village_id']!=""){
            $schools = DB::table('schools')
            ->where('district_id', $params['district_id'])
            ->where('village_id', $params['village_id'])
            ->orderBy('school_name', 'ASC')->get();
            if(count($schools) ==0){
                return response()->json(['status' => '404', 'message' => 'Invalid district id',  'schools' => []]);
            }else{
                return response()->json(['status' => '200', 'message' => 'success',  'schools' => $schools]);
            }
         }else{
                return response()->json(['status' => '404', 'message' => 'Please select district', 'schools' => []]);
         }
    }

    public function districtlevelreport() {
        $params = (array) json_decode(file_get_contents('php://input'), TRUE);

        if(isset($params['district_id']) && $params['district_id']!=""){
            $districts = DB::table('districts')
            ->where('id', $params['district_id'])->get();
        }else{
            $districts = DB::table('districts')->get();
        }

        
        $districtReport = array();
        $reports = array();
        foreach($districts as $district){
            $district_name = $district->dist_name;
            $district_id = $district->id;
            $reports['dist_name'] = $district_name;
            $reports['dist_id'] = $district_id;

            if(isset($params['mandal_id']) && $params['mandal_id']!=""){
                $mandals = DB::select('SELECT count(*) as mandalcount FROM mandals where id="'.$params['mandal_id'].'" AND dist_id = '.$district_id);
            }else{
                $mandals = DB::select('SELECT count(*) as mandalcount FROM mandals where dist_id = '.$district_id);
            }
            $reports['mandals_count'] = $mandals[0]->mandalcount;

            if(isset($params['mandal_id']) && $params['mandal_id']!="" && isset($params['village_id']) && $params['village_id']!=""){
                $villages = DB::select('SELECT count(*) as villagescount FROM villages where id="'.$params['village_id'].'" AND mandal_id="'.$params['mandal_id'].'" AND district_id = '.$district_id);
            }else if(isset($params['mandal_id']) && $params['mandal_id']=="" && isset($params['village_id']) && $params['village_id']!=""){
                $villages = DB::select('SELECT count(*) as villagescount FROM villages where id="'.$params['village_id'].'" AND district_id = '.$district_id);
            }else{
                 $villages = DB::select('SELECT count(*) as villagescount FROM villages where district_id = '.$district_id);
            }

            $reports['villages_count'] = $villages[0]->villagescount;

            if(isset($params['mandal_id']) && $params['mandal_id']!="" && isset($params['village_id']) && $params['village_id']!="" && isset($params['school_id']) && $params['school_id']!="" ){
                $schools = DB::select('SELECT COUNT(*) AS schoolscount, SUM(no_of_teachers) AS teachers, SUM(no_of_boys) AS boys, SUM(no_of_girls) AS girls, SUM(total_strength) AS total_students, SUM(no_of_class_rooms) AS total_classrooms FROM schools WHERE village_id="'.$params['village_id'].'" AND district_id="'.$district_id.'"  GROUP BY district_id');
            }else if(isset($params['mandal_id']) && $params['mandal_id']!="" && isset($params['village_id']) && $params['village_id']!=""){
                $schools = DB::select('SELECT COUNT(*) AS schoolscount, SUM(no_of_teachers) AS teachers, SUM(no_of_boys) AS boys, SUM(no_of_girls) AS girls, SUM(total_strength) AS total_students, SUM(no_of_class_rooms) AS total_classrooms FROM schools WHERE village_id="'.$params['village_id'].'" AND district_id="'.$district_id.'"  GROUP BY district_id');
            }else if(isset($params['mandal_id']) && $params['mandal_id']!="" ){
                $schools = DB::select('SELECT COUNT(*) AS schoolscount, SUM(no_of_teachers) AS teachers, SUM(no_of_boys) AS boys, SUM(no_of_girls) AS girls, SUM(total_strength) AS total_students, SUM(no_of_class_rooms) AS total_classrooms FROM schools LEFT JOIN `villages` ON schools.village_id=villages.id WHERE villages.mandal_id="'.$params['mandal_id'].'" AND schools.district_id="'.$district_id.'"  GROUP BY schools.district_id');
            }else{
                $schools = DB::select('SELECT COUNT(*) AS schoolscount, SUM(no_of_teachers) AS teachers, SUM(no_of_boys) AS boys, SUM(no_of_girls) AS girls, SUM(total_strength) AS total_students, SUM(no_of_class_rooms) AS total_classrooms FROM schools WHERE district_id="'.$district_id.'"  GROUP BY district_id');
            }

            if(isset($schools[0]->schoolscount) && $schools[0]->schoolscount !=""){
                $reports['schools_count'] = $schools[0]->schoolscount;
                $reports['teachers'] = $schools[0]->teachers;
                $reports['boys'] = $schools[0]->boys;
                $reports['girls'] = $schools[0]->girls;
                $reports['total_students'] = $schools[0]->total_students;
                $reports['total_classrooms'] = $schools[0]->total_classrooms;
            }else{
                $reports['schools_count'] = 0;
                $reports['teachers'] = 0;
                $reports['boys'] = 0;
                $reports['girls'] = 0;
                $reports['total_students'] = 0;
                $reports['total_classrooms'] = 0;
            }    

            array_push($districtReport, $reports);

        }
        
        echo "<pre>";print_r($districtReport);exit;

    }




}
