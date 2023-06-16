@extends('layouts.master')

@section('content')
<div class="contianer-fluid ed-inner-pg ">


    <div class="top-banner">

<div class="container">
               </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                {{ $message }}
                </div>
    @endif

    </div>

   
    <form action="/order/updateorder" class="card cat-crd pt-4 px-4 pb-3 p-md-5 pb-md-4" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="order_id" value="{{$orderDetails->orderId}}" />
    <div class="tb-sec">
    
    
    <div class="table-responsive ">
    <p><b>Category: </b>{{$orderDetails->cat_name}}</p>
    <p><b>Bill No: </b>{{$orderDetails->invoice_num}}</p>
    <p><b>Bill Date: </b>{{$orderDetails->ack_date}}</p>
    <p><b>Inovice Number: </b>{{$orderDetails->invoice_no}}</p>
    <p><b>Total Amount:</b>  {{$orderDetails->total_price}}</p>
    <p><b>Indent Items:</b></p>
    <table class="table table-bordered ">
        <thead class="table-dark">
        <tr>
            <th>Product Name</th>
            <th>Product Rate</th>
            <th>Ordered Qty</th>
            <th>Amount</th>
            <th>Net Payable</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($orderDetails->products as $product)
	    <tr>
            <td>{{$product->product_name}}</td>
            <td>{{$product->productPrice}}</td>
            <td>{{$product->ack_qty}} {{$product->units}}</td>
            <td>{{$product->productPrice * $product->ack_qty}}</td>
            <td>{{$product->netpayable_price}}</td>
	    </tr>
	    @endforeach
        </tbody>
    </table>


    @if($user['role'] == 'Supplier' && $orderDetails->invoice_status==0)
    <p>Invoice No: <input type='text' name="invoice_no" id="invoice_no" value="" /></p>
    <p>Upload File: <input type='file' name="invoice" id="invoice" /></p>
    <p>Invoice Date: <input type='date' name="invoice_date" id="invoice_date" /></p>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary mt-3 px-4 py-3">Update</button>
</div>
    @elseif(($user['role'] == 'Supplier' || $user['role'] == 'HM' || $user['role'] == 'APC') && $orderDetails->invoice_status>0)
    <p>Invoice No: {{$orderDetails->invoice_no}}</p>
    <p>Invoice File: <a href="{{asset('storage/'.$orderDetails->invoice_file_path)}}" target="_blank">{{$orderDetails->invoice_no}}</a></p>
    <p>Invoice Date: {{$orderDetails->invoice_date}}</p>
    @endif
    @if($user['role'] == 'HM' && $orderDetails->invoice_status==1)
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary mt-3 px-4 py-3">Acknowledge Order</button>
</div>
@endif


    @if($user['role'] != 'Supplier')    
    @if($orderDetails->invoice_status == 0) 
    Status: <span class="pending">Pending</span>
    @elseif($orderDetails->invoice_status == 1) 
    Status: <span class="pending">Invoiced</span>
    @elseif($orderDetails->invoice_status == 2) 
    Status: <span class="pending">Acknowledged</span>
    @endif
    @endif
    <div>
    @if($user['role'] == 'APC' && $orderDetails->invoice_status==0)
    <button type="submit" class="btn btn-primary mt-3 px-4 py-3">Approve</button>
    <button type="button" class="btn btn-primary mt-3 px-4 py-3">Reject</button>
    @endif
    </div>
    </div>
    </div>
</form>

    
</div>
@endsection