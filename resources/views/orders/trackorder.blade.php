@extends('layouts.master')
@section('content')
<div class="main-bg">
<div class="container pt-5 pb-4">
<div class="row">
<a class="btn d-flex align-items-center fw-bold text-uppercase" href="/orders">
<img src="/../assets/images/backarrow.svg" class="px-1" width="48" height="48" alt="backarrow"> Back
</a>
    </div>
    <div class="row">
    <h1 class="display-5 text-center fw-bold title-clr text-capitalize mb-5">Your Track Order</h1>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    <?php
   // echo "<pre>";print_r($orderDetails);exit;
    ?>

    <div   >
        <form class="row justify-content-center" method="POST" action="/trackorder">
        @csrf
        <div class="col-md-5 d-flex gap-1 align-items-center  ">


            <div class="col-auto flex-grow-1 form-group">
            <label for="staticEmail2" class="visually-hidden">Track Order</label>
            <input type="text" class="form-control" id="order_id" name="order_id" placeholder="Enter Order ID" value="<?php if(isset($searchOrderId) && $searchOrderId!=""){ echo $searchOrderId;} ?>">
            </div>
            <div class="col-auto">
            <button type="submit" class="btn btn-default w-100 my-3 px-4 " style="height:45px;">Search</button>
            </div>
            </div>
        </form>

        <?php

        if(isset($orderDetails) && $orderDetails !=""){
            //echo "<pre>";print_r($orderDetails);exit;
        ?>

        <!--<h2>{{$orderDetails->invoice_num}} Order Details </h2>-->

        <div class="row justify-content-center">
            <div class="col-md-5 pt-4">
                <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">Order Id:</span> <span class="fw-bold col-md-6 ps-4">{{$orderDetails->invoice_num}}</span></p>
        <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">District:</span> <span class="fw-bold col-md-6 ps-4">{{$orderDetails->dist_name}}</span></p>
        <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">Mandal:</span> <span class="fw-bold col-md-6 ps-4">{{$orderDetails->mandal_name}}</span></p>
        <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">Village:</span> <span class="fw-bold col-md-6 ps-4">{{$orderDetails->village_name}}</span></p>
        <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">School ID:</span> <span class="fw-bold col-md-6 ps-4">{{$orderDetails->UDISE_code}}</span></p>
        <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">Order raise school Name:</span> <span class="fw-bold col-md-6 ps-4">{{$orderDetails->school_name}}</span></p>
        <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">Order rises date:</span> <span class="fw-bold col-md-6 ps-4">{{$orderDetails->created_by}}</span></p>
        <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">Order Component:</span> <span class="fw-bold col-md-6 ps-4">{{$orderDetails->cat_name}}</span></p>
        <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">Order supply company Name:</span><span class="fw-bold col-md-6 ps-4">{{$orderDetails->supplierName}}</span></p>

        <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">Invoice/supply date:</span> <span class="fw-bold col-md-6 ps-4">{{$orderDetails->invoice_date}}</span></p>
        <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">Order quantity:</span> <span class="fw-bold col-md-6 ps-4">{{$orderDetails->total_qty}}</span></p>
        <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">Invoice quantity:</span><span class="fw-bold col-md-6 ps-4">{{$orderDetails->delivered_qty}}</span></p>
        <?php
        if(isset($orderDetails->reason) && $orderDetails->reason!=""){
        ?>
        <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">Rejected Reason:</span><span class="fw-bold col-md-6 ps-4">{{$orderDetails->reason}}</span></p>
        <?php
        }
        ?>

        <p class="card p-4 mb-2 d-flex flex-row justify-content-start"><span class="fw-normal col-md-6 text-muted">Status of Order:</span> <span class="fw-bold col-md-6 ps-4">
        <?php
              if($orderDetails->invoice_status==0){
                echo "Pending";
              }else if($orderDetails->invoice_status==1){
                echo "Completed";
              }else if($orderDetails->invoice_status==3){
                echo "Rejected";
              }else{
                echo "Acknowledged";
              }
              ?>    
        @if($orderDetails->invoice_status==0) / {{ $orderDetails->apc_approved_status==0?"Yet to Approve":"Approved by APC" }}</span>@endif</p>
            </div>

        </div>

        <?php
        }else{

            if(isset($searchOrderId) && $searchOrderId!=""){
                echo "<p><b>Order Details Not Found</b> </p>";
            }
        }
        ?>

    </div>

</div>
</div>
@endsection
