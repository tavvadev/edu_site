<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoices;
use App\Models\InvoiceProducts;
class InvoiceController extends Controller
{
    //
    public function createInvoice(Request $request){
      /*   echo '<pre>';
        print_r($request->all());exit; */
        $validator = \Validator::make($request->all(), 
        [
            'invoice_num'         =>     'required|min:1|regex:/^[a-zA-Z\s]*$/',
            'supplier_id'          =>     'required|min:1|',
            'school_id'            =>     'required|min:1|',
            'requester_id'         =>   'required|min:1|',
           'approved_by'          => 'required|min:1|',
           'total_qty'        => 'required|min:1|',
            'invoice_status'    =>'required|min:1|',
        ],
        [
            'invoice_num.required' => 'invoice_num is required',
            'supplier_id.required' => 'supplier_id format is invalid',
            'school_id.required' => 'school_id is required',
            'requester_id.required' => 'requester_id is required',
            'approved_by.required' => 'approved_by is required',
            'total_qty.required' => 'total_qty is required',
            'invoice_status.required' => 'invoice_status is required'
        ]
    );
    //dd($request->invoice_data);
    if ($validator->passes()) {
       // return response()->json(['status' => 200, 'Success' => 'Success']);
        $invoice_data = [ 
                        'invoice_data'=>$request->invoice_data,
                        'supplier_id'=>$request->supplier_id,
                        'school_id'=>$request->school_id,
                        'requester_id'=>$request->requester_id,
                        'approved_by'=>$request->approved_by,
                        'total_qty'=>$request->total_qty,
                        'invoice_status'=>$request->invoice_status
                         ];
              //  print_r($request['products']); exit;         
        $invoice_data = Invoices::create($invoice_data);
        $invoice_id =  $invoice_data->id;
        $total = 0;
        
        foreach($request['products'] as $key =>$val){
            // echo $val;
            $total+=$val['quantity'];
            $invoice_pr_data = ['invoice_id'=>$invoice_id,'product_id'=>$val['product_id'],'quantity'=>$val['quantity']];
            $invoice_products = InvoiceProducts::create($invoice_pr_data);  
        }
       

    }else{
        return response()->json(['status' => 401, 'error' => $validator->errors()]);
         
        }
    }
}
