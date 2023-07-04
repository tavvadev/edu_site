@extends('layouts.master')

@section('content')
<div class="contianer-fluid ed-inner-pg ">


    <div class="top-banner">


<!--<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Library</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data</li>
  </ol>
</nav>-->
              <!--   <h2 class="fw-bold text-white fs-4 ">Orders</h2> -->

              <?php
                if(session('user.info.role_id')==2){
              ?>
              <div class="row justify-content-end pt-3 pb-2">
                <div class="col-md-3 text-end">


              <a class="btn btn-warning text-white py-3 px-4" href="/orders/category"> Create your New Order</a>
              </div>

              <?php
                }
                ?>

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
            @if($user['role'] == 'HM' && ($orderDetails->invoice_status==1 || $orderDetails->invoice_status==2))
            <th>Ack Qty</th>
            @endif
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($orderDetails->products as $product)
            <?php
           // echo "<pre>";print_r($product);exit;
            ?>

	    <tr>
            <td>{{$product->product_name}}</td>
            <td>{{$product->quantity}} {{$product->units}}</td>
            <td>{{$product->productPrice}}</td>
            @if($user['role'] == 'Supplier' && $orderDetails->invoice_status==0)
            <td><input type="number" onChange="ProductPriceChange({{$product->pid}}, {{$product->productPrice}});" id="delivered_qty_{{$product->pid}}"  name="delivered_qty[{{$product->pid}}]" max="{{$product->quantity}}" min="0" /></td>
            @else
            <td>{{$product->bill_qty}}</td>
            @endif
            @if($user['role'] == 'HM' && $orderDetails->invoice_status==1)
            <td><input type="number" value="{{$product->bill_qty}}" name="ack_qty[{{$product->pid}}]" max="{{$product->quantity}}" min="0" /></td>
            @endif
            @if($user['role'] == 'Supplier' && $orderDetails->invoice_status==0)
            <td><input type="number" value="" id="ack_qty_price_{{$product->pid}}"  min="0" readonly /></td>
            @else
            <td>{{$product->price}}</td>
            @endif
            @if($user['role'] == 'HM' && $orderDetails->invoice_status==2)
            <td>{{$product->ack_qty}}</td>
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
    @elseif(($user['role'] == 'Supplier' || $user['role'] == 'HM' || $user['role'] == 'APC') && $orderDetails->invoice_status>0)
    <p>Invoice No: {{$orderDetails->invoice_no}}</p>
    <p>Invoice File: <a style="color: blue;text-decoration:underline;" href="{{asset($orderDetails->invoice_file_path)}}" target="_blank">Download Inovice</a></p>
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
    @if($user['role'] == 'APC' && ($orderDetails->apc_approved_status==0))
    <button type="submit" class="btn btn-primary mt-3 px-4 py-3">Approve</button>
    <button type="button" class="btn btn-primary mt-3 px-4 py-3">Reject</button>
    @endif
    </div>
    </div>
    </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>




</div>
<script >
  function ProductPriceChange(id, price){
    var qty = $("#delivered_qty_"+id).val();
    $("#ack_qty_price_"+id).val(qty * price);
  }
  </script>
@endsection