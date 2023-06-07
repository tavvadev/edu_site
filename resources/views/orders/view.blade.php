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

    <div class="tb-sec">
    
    
    <div class="table-responsive ">
        <h1>{{$orderDetails->cat_name}} Order Details </h1>
    <p><b>Order Id:</b> {{$orderDetails->invoice_num}}</p>
    <p><b>School:</b>  {{$orderDetails->school_name}}</p>
    <p><b>Head Master:</b>  {{$orderDetails->hm_name}}</p>
    <p><b>Head Master Contact:</b>  {{$orderDetails->hm_contact_num}}</p>
    <p><b>Indent Items:</b></p>
    @foreach ($orderDetails->products as $product)
        <p>{{$product->product_name}} Qty: {{$product->quantity}} {{$product->units}}</p>
    @endforeach
    
    @if($orderDetails->invoice_status == 0) 
    <button class="btn btn-warning">Pending</button>
    @elseif($orderDetails->invoice_status == 1) 
    <button class="btn btn-success">Acknowledged</button>
    @elseif($orderDetails->invoice_status == 2) 
    <button class="btn btn-failure">Acknowledged</button>
    @endif
    </div>
    </div>


</div>
@endsection