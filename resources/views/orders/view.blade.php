@extends('layouts.master')

@section('content')
<div class="contianer-fluid ed-inner-pg ">


    <div class="top-banner ">

<div class="container">


<div class="row justify-content-between align-items-center">
  <div class="col-auto flex-grow-1">
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item fs-5"><a href="/orders">Orders</a></li>
     <li class="breadcrumb-item active fs-5" aria-current="page">{{$orderDetails->cat_name}} Order Details </li>
  </ol>
</nav>
  </div>

  <div class="col-auto ">
  <?php
                if(session('user.info.role_id')==2 || session('user.info.role_id')==3){
              ?>




              <a class="btn btn-warning text-white py-3 px-4" href="/orders/category"> Create your New Order</a>


              <?php
                }
                ?>
  </div>
</div>



              <!--   <h2 class="fw-bold text-white fs-4 ">Orders</h2> -->



               </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                {{ $message }}
                </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

    </div>


    <form action="/order/updateorder" class=" " method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="order_id" value="{{$orderDetails->orderId}}" />
    <div class="tb-sec">
   <div class="table-responsive ">



    <h2 class="fs-5 fw-bold title-clr mb-2">Order Details</h2>
   <div class="d-flex mb-4 flex-wrap justify-content-start">
    <div class="col-auto mt-3 mb-2 me-4">
    <p class=" pe-4 lh-base mb-1 fs-6 fw-normal text-muted"><small>Order Id:</small></p>
    <p class="mb-0 fs-5"><b> {{$orderDetails->invoice_num}}</b></p>


    </div>

    <div class="col-auto mt-3 mb-2 me-5">

    <p class=" pe-4 lh-base mb-1 fs-6 fw-normal text-muted"><small>School:</small></p>
    <p class="mb-0 fs-5"><b>  {{$orderDetails->school_name}}</b></p>
    </div>
    <div class="col-auto mt-3 mb-2 me-5">

    <p class=" pe-4 lh-base mb-1 fs-6 fw-normal text-muted"><small>Head Master:</small></p>
    <p class="mb-0 fs-5"><b>  {{$orderDetails->hm_name}}</b></p>
    </div>
    <div class="col-auto mt-3 mb-2 me-5">

    <p class=" pe-4 lh-base mb-1 fs-6 fw-normal text-muted"><small>Head Master Contact:</small></p>
    <p class="mb-0 fs-5"><b>  {{$orderDetails->hm_contact_num}}</b></p>
    </div>
    <div class="col-auto mt-3 mb-2 me-5">

    <p class=" pe-4 lh-base mb-1 fs-6 fw-normal text-muted"><small>Indent Items:</small></p>
    <p class="mb-0 fs-5"><b>Nil</b></p>
    </div>
    </div>

    <table class="table table-bordered ">
        <thead class="table-dark">
        <tr>
            <th>Product Name</th>
            <th>Ordered Qty</th>
            <th>Price</th>
            <th>Deilvered Qty</th>
            <th>Amount</th>
            @if($user['role'] == 'HM' && ($orderDetails->invoice_status==1 || $orderDetails->invoice_status==2))
            <th>Ack Qty</th>
            @endif
            @if($user['role'] == 'EE' && ($orderDetails->invoice_status==1 || $orderDetails->invoice_status==2))
            <th>Ack Qty</th>
            @endif
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
            @if($user['role'] == 'HM' )
                @if($user['role'] == 'HM' && $orderDetails->invoice_status==1)
                <td><input type="number" value="{{$product->bill_qty}}" name="ack_qty[{{$product->pid}}]" max="{{$product->quantity}}" min="0" /></td>
                @else
                <td>{{$product->bill_qty}}</td>
                @endif
                <td>@php echo $product->bill_qty*$product->productPrice @endphp</td>
                @if($user['role'] == 'HM' && $orderDetails->invoice_status==2)
                <td>{{$product->ack_qty}}</td>
                @endif
            @endif

            @if($user['role'] == 'EE' )
                @if($user['role'] == 'EE' && $orderDetails->invoice_status==1)
                <td><input type="number" value="{{$product->bill_qty}}" name="ack_qty[{{$product->pid}}]" max="{{$product->quantity}}" min="0" /></td>
                @else
                <td>{{$product->bill_qty}}</td>
                @endif
                <td>@php echo $product->bill_qty*$product->productPrice @endphp</td>
                @if($user['role'] == 'EE' && $orderDetails->invoice_status==2)
                <td>{{$product->ack_qty}}</td>
                @endif
            @endif

              @if($user['role'] == 'APC' || $user['role'] == 'FAO' )
                <td>{{$product->bill_qty}}</td>
                <td>@php echo $product->bill_qty*$product->productPrice @endphp</td>
              @endif

              @if($user['role'] == 'Supplier')

                  @if($user['role'] == 'Supplier' && $orderDetails->invoice_status==0)
                  <td><input type="number" onChange="ProductPriceChange({{$product->pid}}, {{$product->productPrice}});" id="delivered_qty_{{$product->pid}}"  name="delivered_qty[{{$product->pid}}]" max="{{$product->quantity}}" min="0" /></td>
                  @else
                  <td>{{$product->bill_qty}}</td>
                  @endif


                  @if($user['role'] == 'Supplier' && $orderDetails->invoice_status==0)
                  <td><input type="number" value="" id="ack_qty_price_{{$product->pid}}" name="ack_qty_price_[{{$product->pid}}]"  min="0" readonly /></td>
                  @else
                  <td>@php echo $product->bill_qty*$product->productPrice @endphp</td>
                  @endif
              @endif

	    </tr>
	    @endforeach
        </tbody>
    </table>
    @if($user['role'] == 'Supplier' && $orderDetails->invoice_status==0)
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary mt-3 px-4 py-3">Update</button>
</div>
@endif

@if($user['role'] == 'HM' && $orderDetails->invoice_status==1)
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary mt-3 px-4 py-3">Acknowledge Order</button>
</div>
@endif

@if( $user['role'] == 'EE' && $orderDetails->is_acknowledge_ee==1)
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary mt-3 px-4 py-3">Acknowledge Order</button>
</div>
@endif

   </div>

   <div class="pt-5 ">


    @if($user['role'] == 'Supplier' && $orderDetails->invoice_status==0)
    <p class="mb-1"><span class="text-muted">Invoice No: </span><input type='text' name="invoice_no" id="invoice_no" value="" /></p>
    <p class="mb-1"><span class="text-muted">Upload File: </span><input type='file' name="invoice" id="invoice" /></p>
    <p class="mb-1"><span class="text-muted">Invoice Date:</span> <input type='date' name="invoice_date" id="invoice_date" /></p>


    @elseif(($user['role'] == 'Supplier' || $user['role'] == 'HM' || $user['role'] == 'APC') && $orderDetails->invoice_status>0)
    <p class="mb-1"><span class="text-muted">Invoice No:</span> <span class="ps-2">{{$orderDetails->invoice_no}}</span></p>
    <p class="mb-1"><span class="text-muted">Invoice File:</span> <span class="ps-2"><a href="{{asset($orderDetails->invoice_file_path)}}"
     target="_blank">Download Inovice</a></span></p>
    <p class="mb-1"><span class="text-muted">Invoice Date:</span> <span class="ps-2">{{$orderDetails->invoice_date}}</span></p>
    @endif

    </div>


    @if($user['role'] != 'Supplier')
    @if($orderDetails->invoice_status == 0)
    Status: <span class="pending">Pending</span>
    @elseif($orderDetails->invoice_status == 1)
    Status: <span class="pending">Invoiced</span>
    @elseif($orderDetails->invoice_status == 2)
    Status: <span class="pending">Acknowledged fffddfgg</span>
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