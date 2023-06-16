@extends('layouts.master')
@section('content')
<div class="contianer-fluid ed-inner-pg ">
    <div class="top-banner">
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
    <table class="table table-bordered ">
        <thead class="table-dark">
        <tr>
            <th>Product Name</th>
            <th>Product Rate</th>
            <th>Ordered Qty</th>
            <th>Amount</th>
            <th>Net Payable (80%)</th>
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
    <div>
    <button type="submit" class="btn btn-primary mt-3 px-4 py-3">Pay</button>
    </div>
    </div>
    </div>
</form>

    
</div>
@endsection