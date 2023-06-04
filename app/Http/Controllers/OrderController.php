<?php
    
namespace App\Http\Controllers;
    
use App\Models\Orders;
use App\Models\Product;
use App\Models\Category;
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
        // echo '<pre>';print_r($data['user']['info']->id);exit;
        $products = Orders::leftjoin('schools as s',"orders.school_id","=",'s.id')->paginate(15);
        return view('orders.index',compact('products'))
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
        $product = Product::select('*')
                ->where('category_id', '=', $id)
                ->get();
        return view('orders.create',compact('product'));
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
    
}