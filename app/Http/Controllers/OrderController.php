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
        // echo $data['user'];exit;
        // echo '<pre>';print_r($data['user']['schools']);
        // print_r($data['user']['role']);
        $user_id = $data['user']['info']->id;
        //echo '<pre>';print_r($data['user']['info']->id);exit;

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

        $orders = Orders::leftjoin('schools as s',"orders.school_id","=",'s.id')
        ->leftjoin('categories as c',"c.id","=",'orders.order_category')
        ->select('c.cat_name','orders.id as oid','orders.invoice_num as order_num','orders.total_qty','orders.invoice_status','s.school_name','s.UDISE_code','s.hm_name',"s.hm_contact_num")->paginate(3);
        $i =0;
        foreach($orders as $order) {
            $orders[$i] = $order;
            $results = InvoiceProducts::leftjoin('products as p',"order_products.invoice_id","=",'p.id')->where('invoice_id', $order->oid)
            ->select("p.name as product_name","p.units","order_products.*")->get();
            $orders[$i]['products'] = $results;
            $i++;
        }
        // echo '<pre>';print_r($orders);exit;

        return view('orders.index',compact('orders'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
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

    public function createOrder(Request $request){
        $data = request()->session()->all();
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
            // echo '<pre>';print_r($request['products']);exit;
           // return response()->json(['status' => 200, 'Success' => 'Success']);
           foreach($request['products'] as $key =>$val){
            if($val['quantity']!='') {
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
                            'order_category'=>$request->category,
                            'invoice_status'=>0
                             ];
          //   echo '<pre>';print_r($request['products']); exit;
            $invoice_data = Invoices::create($invoice_data);
            $invoice_id =  $invoice_data->id;
            $total = 0;
            foreach($request['products'] as $key =>$val){
                if($val['quantity']!='') {
                    $invoice_pr_data = ['invoice_id'=>$invoice_id,'product_id'=>$val['product_id'],'quantity'=>$val['quantity']];
                    $invoice_products = InvoiceProducts::create($invoice_pr_data);
                }

            }
            $order = Invoices::find($invoice_id);
            $order->invoice_num = $data['user']['info']->login_id.$invoice_id;
            $order->save();

            return redirect()->route('orders.index')
            ->with('success','Order created successfully.Order ID:'.$invoice_id);
        }else{
            return response()->json(['status' => 401, 'error' => $validator->errors()]);

            }
        }
        public function view(Request $request): View
        {
            if($request->id!=''){
                $orderId = $request->id;
            }

            $orderDetails = Invoices::leftjoin('schools as s',"orders.school_id","=",'s.id')
            ->leftjoin('districts as d',"s.district_id","=",'d.id')
            ->leftjoin('villages as v',"s.village_id","=",'v.id')
            ->leftjoin('categories as c',"c.id","=",'orders.order_category')
            ->where('orders.id', $orderId)->select("d.dist_name","c.cat_name","v.village_name","orders.*","orders.id as orderId","s.*")
            ->first();

                $results = InvoiceProducts::leftjoin('products as p',"order_products.invoice_id","=",'p.id')->where('invoice_id', $orderDetails->orderId)
                ->select("p.name as product_name","p.units","order_products.*")->get();
                $orderDetails['products'] = $results;

            // echo '<pre>';print_r($orderDetails);exit;
            return view('orders.view',compact('orderDetails'));

        }

}