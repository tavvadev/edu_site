@extends('layouts.master')




@section('content')
<div class="main-bg">
<div class="container pt-5 pb-4">
    <div class="row">
                <h2 class="fw-bold fs-3 pb-3 title-clr ">Track Order</h2>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    <?php
   // echo "<pre>";print_r($orderDetails);exit;
    ?>

    <div class="row"  >
        <form class="row g-12" method="POST" action="/trackorder">
        @csrf
            <div class="col-auto">
            <label for="staticEmail2" class="visually-hidden">Track Order</label>
            <input type="text" class="form-control" id="order_id" name="order_id" placeholder="Enter Order ID" value="<?php if(isset($searchOrderId) && $searchOrderId!=""){ echo $searchOrderId;} ?>">
            </div>
            <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3">Search</button>
            </div>
        </form>

        <?php

        if(isset($orderDetails) && $orderDetails !=""){
        ?>
        
        <!--<h2>{{$orderDetails->invoice_num}} Order Details </h2>-->
        <br/>
        <br/>
        <p><b>Order Id:</b> {{$orderDetails->invoice_num}}</p>
        <p><b>District:</b> {{$orderDetails->dist_name}}</p>
        <p><b>Mandal:</b> {{$orderDetails->mandal_name}}</p>
        <p><b>Village:</b> {{$orderDetails->village_name}}</p>
        <p><b>School ID:</b> {{$orderDetails->UDISE_code}}</p>
        <p><b>Order raise school Name:</b> {{$orderDetails->school_name}}</p>
        <p><b>Order rises date:</b> {{$orderDetails->created_by}}</p>
        <p><b>Order Component:</b> {{$orderDetails->cat_name}}</p>
        <p><b>Order supply company Name:</b> {{$orderDetails->supplierName}}</p>
        <p><b>Status of Order:</b> {{$orderDetails->invoice_status}}</p>
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
