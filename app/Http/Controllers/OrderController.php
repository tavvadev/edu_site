<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Schoolusers;
use App\Models\Schools;
use App\Models\Invoices;
use App\Models\InvoiceProducts;
use App\Models\Orderproducts;
use App\Models\DistrictSuppliers;
use App\Models\Payments;
use Illuminate\Support\Facades\DB;



use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {

         /*$this->middleware('permission:order-list|order-create|order-edit|order-delete', ['only' => ['index','show']]);
         $this->middleware('permission:order-create', ['only' => ['create','store']]);
         $this->middleware('permission:order-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:order-delete', ['only' => ['destroy']]);
         $this->middleware('permission:order-products', ['only' => ['products']]);
         */


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $data = request()->session()->all();
        // print_r($data['user']['role']);exit;
        $user_id = $data['user']['info']->id;
        //echo '<pre>';print_r($data['user']['info']->id);exit;
        $user = $data['user']['info'];
        $schools =[];
        // Get the schools using the user id.....
        $role = User::leftJoin('roles','roles.id','=','users.role_id')->where('users.id', $user_id)->first('roles.name as roleName');
            //echo $role->roleName;exit;
            if($role->roleName == 'FAO' || $role->roleName == 'APC') {
                // Find the district of this logged in User/Role if they are distrcit level officer.
                $district_details = User::leftJoin('districts','districts.id','=','users.district_id')->where('users.id', $user_id)->first('districts.*');

                $district_details = User::leftJoin('districts','districts.id','=','users.district_id')->where('users.id', $user_id)->first('districts.*');
                // get all the schools and villages in this district
                $schoolResults = Schools::where('district_id', $user->district_id)->get();
                foreach($schoolResults as $school) {
                    $schools[] = $school->id;
                }
            } else if($role->roleName == 'Supplier') {
                $schoolResults = Schools::where('district_id', $user->district_id)->get();
                foreach($schoolResults as $school) {
                    $schools[] = $school->id;
                }
                // echo '<pre>';print_r($schools);exit;
            } else {
                $results = Schoolusers::where('user_id', $user_id)->get();
                foreach ($results as $res) {
                    $schools[] = $res->school_id;
                }
            }
            // echo '<pre>';print_r($schools);exit;
            $query = Orders::leftjoin('schools as s',"orders.school_id","=",'s.id')
            ->leftjoin('categories as c',"c.id","=",'orders.order_category')
            ->leftjoin('villages as vi',"vi.id","=",'s.village_id')
            ->leftjoin('mandals as m',"m.id","=",'vi.mandal_id')
            ->leftjoin('districts as d',"d.id","=",'s.district_id')
            ->leftjoin('users as u',"orders.supplier_id","=",'u.id')
            ->select('c.cat_name','orders.id as oid','orders.bill_generated','orders.bill_generated_date','orders.invoice_num as order_num','orders.total_qty','orders.invoice_status','orders.school_id','vi.village_name','d.dist_name','m.mandal_name','s.latitude','s.longitude','s.code','s.school_name' ,'s.school_name','s.UDISE_code','s.hm_name',"s.hm_contact_num","orders.apc_approved_status","orders.invoice_status","u.name as supplierName","u.contact_number as supplierNumber");
            $i =0;
            if($role->roleName == 'Supplier') {
                $query->where('apc_approved_status', 1);
                $query->whereIn('school_id', $schools);
            }
            if($role->roleName == 'FAO') {
                $query->where('invoice_status', 2);
                $query->whereIn('school_id', $schools);
            }
            if($role->roleName == 'HM') {
                $query->whereIn('school_id', $schools);
            }
            if($role->roleName == 'APC') {
                $query->whereIn('school_id', $schools);
            }
            // echo '<pre>';print_r($schools);
            //  echo $query->toSql();exit;
            $orders = $query->paginate(10);
            foreach($orders as $order) {
                $orders[$i] = $order;
                $results = InvoiceProducts::leftjoin('products as p',"order_products.invoice_id","=",'p.id')->where('invoice_id', $order->oid)
                ->select("p.name as product_name","p.units","order_products.*")->get();
                $orders[$i]['products'] = $results;
                $i++;
            }     
        // echo count($orders);
        //  echo '<pre>';print_r($orders);exit;
        if($role->roleName == 'FAO') {
            return view('orders.faoindex',compact('orders','user'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
        } else {
            return view('orders.index',compact('orders','user'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
        }
        
    }

    public function category(Request $request): View
    {
        $categories = Category::orderBy('id','DESC')->paginate(10);
        return view('orders.category',compact('categories'))
            ->with('i', ($request->input('page', 1) - 1) * 10);

    }


    public function edit($id): View
    {
        $category = Category::find($id);
        $product = Product::select('*')
                ->where('category_id', '=', $id)
                ->get();
        // echo "<pre>";print_r($category);exit;
        return view('orders.create',compact('product','category'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request): RedirectResponse
    {

       // echo "<pre>";print_r($request->prodct_id[$i]);exit;
        $order_table_data = array(
            'invoice_num' => 'ABCTesting',
            'school_id' => $request->school_id,
            'created_by' => now(),
            'updated_by' => now()
        );

        $OrderId = Orders::create($order_table_data);


        $i = 0;
        foreach($request->item_qty as $value){

            if($value !=""){
                 $order_products = array(
                    'invoice_id' => $OrderId->id,
                    'product_id' => $request->prodct_id[$i],
                    'quantity' => $value,
                    'requested_qty' => $value
                );
                Orderproducts::create($order_products);
            }
            $i++;

        }



        return redirect()->route('orders.index')
                        ->with('success','Order created successfully.');
    }
    public function updateorder(Request $request){
        $data = request()->session()->all();
        if($data['user']['role'] == 'Supplier') {
            // Validate the uploaded file
            $request->validate([
            'invoice' => 'mimes:pdf|max:2048', // Adjust the allowed file types and size as needed
            ]);

            if ($request->hasFile('invoice')) {
            $file = $request->file('invoice');
            // echo "<pre>";print_r($request->file());
            $path = $file->store('uploads', 'public');

            // echo '<pre>';print_r($file);
            }
            // echo '<pre>';print_r($request->all());exit;
            foreach($request->delivered_qty as $product_id=>$del_qty) {
            DB::table('order_products')
            ->where('invoice_id', $request->order_id)
            ->where('product_id', $product_id)
            ->update([
            'bill_qty' => $del_qty,
            'price' => DB::raw('price *'.$del_qty) 
            ]);
            }

            // echo '<pre>';print_r($request->all());exit;
            $order = Invoices::find($request->order_id);
            $order->invoice_date = $request->invoice_date;
            $order->invoice_no = $request->invoice_no;
            $order->invoice_created_at = date('Y-m-d H:i:s');
            $order->invoice_file_path = $path;
            $order->invoice_status = 1;
            $order->save();
            
        } else if($data['user']['role'] == 'HM') {
            $totalnetpayable_price = 0;
            // echo '<pre>';print_r($request->ack_qty);exit;
            foreach($request->ack_qty as $product_id=>$del_qty) {
                $product = Product::find($product_id);
                $totalnetpayable_price+= $product['price']*$del_qty;
                DB::table('order_products')
                ->where('invoice_id', $request->order_id)
                ->where('product_id', $product_id)
                ->update([
                'ack_qty' => $del_qty,
                'price' => $product['price']*$del_qty,
                'netpayable_price' => $product['price']*$del_qty * 0.80
                ]);
                }
    
                // echo '<pre>';print_r($request->all());exit;
                $order = Invoices::find($request->order_id);
                $order->invoice_status = 2;
                $order->total_price = $totalnetpayable_price;
                $order->ack_date = date('Y-m-d H:i:s');
                $order->save();
        } else if($data['user']['role'] == 'APC') {
                // echo '<pre>';print_r($request->all());exit;
                // echo '<pre>';print_r($request->all());exit;
                $order = Invoices::find($request->order_id);
                $order->apc_approved_status = 1;
                $order->apc_approved_date = date('Y-m-d H:i:s');
                $order->apc_approved_by = $data['user']['info']->id;
                $order->save();
        }
         
        return redirect()->route('orders.index')
        ->with('success','Order updated successfully.');
        
    }
    public function createOrder(Request $request){

        $data = request()->session()->all();

        $orders = DB::select('SELECT * FROM orders where order_category = "'.$request->category.'" and school_id ="'.$data['user']['schools'][0].'"');

        if(count($orders) !=0){
            return redirect()->back()->with("error","Already this order category placed.");
        }else{
        // echo $data['user'];exit;
        // echo $request->school_id;
        // echo '<pre>';print_r($data['user']['schools'][0]);
        // // print_r($data['user']['role']);
        //  echo '<pre>';print_r($data['user']);
        // echo '<pre>';
        //  print_r($request->all());exit;
            $validator = \Validator::make($request->all(),
            [
              //   'invoice_num'         =>     'required|min:1|regex:/^[a-zA-Z\s]*$/',
              //   'supplier_id'          =>     'required|min:1|',
                // 'school_id'            =>     'required|min:1|',
              //   'requester_id'         =>   'required|min:1|',
              //  'approved_by'          => 'required|min:1|',
              //  'total_qty'        => 'required|min:1|',
              //   'invoice_status'    =>'required|min:1|',
            ],
            [
                'invoice_num.required' => 'invoice_num is required',
              //   'supplier_id.required' => 'supplier_id format is invalid',
                // 'school_id.required' => 'school_id is required',
                'requester_id.required' => 'requester_id is required',
              //   'approved_by.required' => 'approved_by is required',
                'total_qty.required' => 'total_qty is required',
                'invoice_status.required' => 'invoice_status is required'
            ]
        );

        //dd($request->invoice_data);
        if ($validator->passes()) {
            $total = 0;
            $total_price=0;
            // echo '<pre>';print_r($request['products']);exit;
           // return response()->json(['status' => 200, 'Success' => 'Success']);
           foreach($request['products'] as $key =>$val){
            if($val['quantity']!='') {
                $product = Product::find($val['product_id']);
                $total_price+=$product['price']*$val['quantity'];
                $total+=$val['quantity'];
            }
        }

                // echo $request->category;exit;
                    $invoice_data = [
                                    'invoice_data'=>$request->invoice_data,
                                    'supplier_id'=>$request->supplier_id,
                                    'school_id'=>$data['user']['schools'][0],
                                    'requester_id'=>$data['user']['info']->id,
                                    // 'approved_by'=>$request->approved_by,
                                    'total_qty'=>$total,
                                    'total_price'=>$total_price,
                                    'order_category'=>$request->category,
                                    'invoice_status'=>0
                                    ];
                //   echo '<pre>';print_r($request['products']); exit;
                    $invoice_data = Invoices::create($invoice_data);
                    $invoice_id =  $invoice_data->id;
                    $total = 0;
                    foreach($request['products'] as $key =>$val){
                        if($val['quantity']!='') {
                            $product = Product::find($val['product_id']);
                            $invoice_pr_data = ['invoice_id'=>$invoice_id,'product_id'=>$val['product_id'],'quantity'=>$val['quantity']];
                            $invoice_products = InvoiceProducts::create($invoice_pr_data);
                        }

                    }
                    $school_details = Schools::where('id',$data['user']['schools'][0])->first();
                    $supplier_details = DistrictSuppliers::where('dist_id', $school_details['district_id'])->first();
                    $order = Invoices::find($invoice_id);
                    $order->supplier_id = $supplier_details['supplier_id'];
                    $order->invoice_num = $data['user']['info']->login_id.$invoice_id;
                    $order->save();

                    return redirect()->route('orders.index')
                    ->with('success','Order created successfully.Order ID:'.$invoice_id);
                }else{
                    return response()->json(['status' => 401, 'error' => $validator->errors()]);

                }

            }    
            
        }
        public function view(Request $request): View
        {
            if($request->id!=''){
                $orderId = $request->id;
            }
            $data = request()->session()->all();
            // echo '<pre>';print_r($data['user']);exit;
            $user = $data['user'];
            $user_id = $data['user']['info']->id;
            $orderDetails = Invoices::leftjoin('schools as s',"orders.school_id","=",'s.id')
            ->leftjoin('districts as d',"s.district_id","=",'d.id')
            ->leftjoin('villages as v',"s.village_id","=",'v.id')
            ->leftjoin('categories as c',"c.id","=",'orders.order_category')
            ->leftjoin('users as u',"orders.supplier_id","=",'u.id')
            ->where('orders.id', $orderId)->select("d.dist_name","c.cat_name","v.village_name","orders.*","orders.id as orderId","s.*","u.name as supplierName","u.contact_number as supplierNumber")
            ->first();

                $results = InvoiceProducts::leftjoin('products as p',"order_products.product_id","=",'p.id')->where('invoice_id', $orderDetails->orderId)
                ->select("p.name as product_name","p.units","order_products.product_id as pid","p.price as productPrice","order_products.*")->get();
                $orderDetails['products'] = $results;

            // echo '<pre>';print_r($orderDetails);exit;
            if($data['user']['role'] == 'FAO') {
                return view('orders.faoview',compact('orderDetails','user'));
            } else {
                return view('orders.view',compact('orderDetails','user'));
            }
            

        }
        public function generatebill(Request $request): RedirectResponse {
            if($request->order_id!=''){
                $orderId = $request->order_id;
            }
            $orderDetails = Invoices::leftjoin('schools as s',"orders.school_id","=",'s.id')
            ->leftjoin('users as u',"orders.supplier_id","=",'u.id')
            ->where('orders.id', $orderId)->select("orders.*","orders.id as orderId","u.name as supplierName","u.contact_number as supplierNumber")
            ->first();
            $results = InvoiceProducts::leftjoin('products as p',"order_products.product_id","=",'p.id')->where('invoice_id', $orderDetails->orderId)
                ->select("p.name as product_name","p.units","order_products.product_id as pid","p.price as productPrice","order_products.*")->get();
                $orderDetails['products'] = $results;

            $payments = new Payments();
            $payments->order_id = $orderDetails->orderId;
            $payments->supplier_id = $orderDetails->supplier_id;
            $payments->bill_amount = $orderDetails->total_price*0.8;
            $payments->tds_amount = ($orderDetails->total_price*0.8)*0.02;
            $payments->total_amount = $orderDetails->total_price;
            $payments->remaining_balance = $orderDetails->total_price*0.2;
            $payments->save();

            $order = Invoices::find($request->order_id);
            $order->bill_generated = 1;
            $order->bill_generated_date = Date('Y-m-d H:i:s');
            $order->save();
            return redirect()->back()->with("success","Bill generated successfully");
        }
        public function payments(Request $request): View {
            
        $data = request()->session()->all();
        $user_id = $data['user']['info']->id;
        $user = $data['user']['info'];
        $schools =[];
        // Get the schools using the user id.....
        $role = User::leftJoin('roles','roles.id','=','users.role_id')->where('users.id', $user_id)->first('roles.name as roleName');
            if($role->roleName == 'APC') {
                // Find the district of this logged in User/Role if they are distrcit level officer.
                $district_details = User::leftJoin('districts','districts.id','=','users.district_id')->where('users.id', $user_id)->first('districts.*');
                $district_details = User::leftJoin('districts','districts.id','=','users.district_id')->where('users.id', $user_id)->first('districts.*');
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
            $query = Payments::leftjoin('orders as o',"o.id","=",'payments.order_id')
            ->leftjoin('schools as s',"o.school_id","=",'s.id')
            ->leftjoin('users as u',"u.id","=",'payments.supplier_id')
            ->select('u.name as supplierName','u.contact_number as supplierNumber','s.school_name','payments.*','o.id as oid','o.bill_generated','o.bill_generated_date','o.invoice_num as order_num','o.total_qty','o.invoice_status','o.school_id',"o.apc_approved_status","o.invoice_status");
            $i =0;
            if($role->roleName == 'APC') {
                $query->whereIn('s.id', $schools);
                $query->where('o.bill_generated',1);
            }

            $paymentsList = $query->paginate(10);
            // echo '<pre>';print_r($paymentsList);exit;
                
            return view('orders.payments',compact('paymentsList'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        }


        public function trackorder(Request $request): View
        {
            $data = request()->session()->all();
            $user = $data['user'];
            $user_id = $data['user']['info']->id;
            $searchOrderId = "";

            if(isset($request->order_id) && $request->order_id!=""){
          
                if($request->order_id!=''){
                    $orderId = $request->order_id;
                }
                
                $orderDetails = Invoices::leftjoin('schools as s',"orders.school_id","=",'s.id')
                ->leftjoin('districts as d',"s.district_id","=",'d.id')
                ->leftjoin('villages as v',"s.village_id","=",'v.id')
                ->leftjoin('mandals as m',"v.mandal_id","=",'m.id')
                ->leftjoin('categories as c',"c.id","=",'orders.order_category')
                ->leftjoin('users as u',"orders.supplier_id","=",'u.id')
                ->where('orders.invoice_num', $orderId)->select("d.dist_name","c.cat_name","v.village_name","m.mandal_name","orders.*","orders.id as orderId","s.*","u.name as supplierName","u.contact_number as supplierNumber")
                ->first();
                 //echo '<pre>';print_r($orderDetails);exit;
                 if(isset($orderDetails)  && $orderDetails ==""){
                    $orderDetails = '';
                 }
                 $searchOrderId = $request->order_id;

            }else{
                $orderDetails = '';
                $searchOrderId = $request->order_id;
            }
          
            return view('orders.trackorder',compact('orderDetails','user', 'searchOrderId'));
            

        }

}