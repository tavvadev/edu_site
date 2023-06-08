@extends('layouts.master')

@section('content')
<div class="contianer-fluid ed-inner-pg ">


    <div class="top-banner">

<div class="container">
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Library</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data</li>
  </ol>
</nav>
              <!--   <h2 class="fw-bold text-white fs-4 ">Orders</h2> -->


              <div class="row justify-content-end pt-3 pb-2">
                <div class="col-md-3 text-end">


              <a class="btn btn-warning text-white py-3 px-4" href="/orders/category"> Create your New Order</a>
              </div>
              </div>

               </div>

    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif
    <form action="/order/updateorder" class="card cat-crd pt-4 px-4 pb-3 p-md-5 pb-md-4" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="order_id" value="{{$orderDetails->orderId}}" />
    <div class="tb-sec">
    
    
    <div class="table-responsive ">
        <h1>{{$orderDetails->cat_name}} Order Details </h1>
    <p><b>Order Id:</b> {{$orderDetails->invoice_num}}</p>
    <p><b>School:</b>  {{$orderDetails->school_name}}</p>
    <p><b>Head Master:</b>  {{$orderDetails->hm_name}}</p>
    <p><b>Head Master Contact:</b>  {{$orderDetails->hm_contact_num}}</p>
    <p><b>Indent Items:</b></p>
    <table class="table table-bordered ">
        <thead class="table-dark">
        <tr>
            <th>Product Name</th>
            <th>Ordered Qty</th>
            <th>Price</th>
            <th>Deilvered Qty</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($orderDetails->products as $product)
	    <tr>
            <td>{{$product->product_name}}</td>
            <td>{{$product->quantity}}</td>
            <td>{{$product->productPrice * $product->quantity}}</td>
            @if($user['role'] == 'Supplier' && $orderDetails->invoice_status==0)
            <td><input type="number" name="delivered_qty[{{$product->pid}}]" max="{{$product->quantity}}" min="0" /></td>
            @else
            <td>{{$product->bill_qty}}</td>
            @endif
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
    @else
    <p>Invoice No: {{$orderDetails->invoice_no}}</p>
    <p>Invoice File: <a href="{{asset('storage/'.$orderDetails->invoice_file_path)}}" target="_blank">{{$orderDetails->invoice_no}}</a></p>
    <p>Invoice Date: {{$orderDetails->invoice_date}}</p>
    <p>Invoice Status: <button class="btn btn-success">{{$orderDetails->invoice_status == 1?"Waiting for Acknowledge":"Acknowledged"}}</button></p>
    @endif

    @if($user['role'] != 'Supplier')    
    @if($orderDetails->invoice_status == 0) 
    <button class="btn btn-warning">Pending</button>
    @elseif($orderDetails->invoice_status == 1) 
    <button class="btn btn-success">Acknowledged</button>
    @elseif($orderDetails->invoice_status == 2) 
    <button class="btn btn-failure">Acknowledged</button>
    @endif
    @endif
    </div>
    </div>
</form>

    
</div>
@endsection