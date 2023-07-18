@extends('layouts.master')


@section('content')
<div class="main-bg">
<div class="container pt-5 pb-4">

<div class="row justify-content-start">
    <div class="col-md-2">
<a class="btn d-flex align-items-center fw-bold text-uppercase"
href="{{ route('orders.index') }}">
<img src="/../assets/images/backarrow.svg"
class="px-1" width="48" height="48" alt="backarrow"/> Back
</a>
</div>
</div>
<p class="fw-normal fs-5 text-capitalize pb-0 mb-0 text-muted text-center">
        <small> Add number of quantities to order in </small></p>
<h2 class="title-clr text-center display-3 fw-bold mb-5">{{$category->cat_name}}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

    <div class="row justify-content-center">
   <div class="col-md-6">
    <form action="/order/create" class="card cat-crd pt-4 px-4 pb-3 p-md-5 pb-md-4" method="POST">


    @csrf
         <div class="row">
            
                <?php
                if(session('user.role')=="EE"){
                ?>
                <div class="form-group  pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-normal text-body col-md-6">Select School</label>
                    <div class="col-md-6 d-flex align-items-center">
                        <select id="school_id"  name="school_id" class="form-control">
                            <?php

                                foreach(session('user.schools') AS $school){
                                   ?>
                                   <option value="<?php echo $school['school_id'];?>" ><?php echo $school['school_name'];?></option>
                                   <?php 
                                }
                                ?>

                        </select>
                    </div>
                </div>
                <?php
                }
                ?>

            <?php $i=0; ?>
            <input type="hidden" name="category" value="{{$category->id}}" />
            @foreach ($product as $product)
            <?php
           //echo "<pre>";print_r(Session::all());exit;
            ?>
                <div class="col-md-12">
                    <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-8">{{ $product->name }} </label>
                   <div class="col-md-4 d-flex align-items-center">

<span>
                    <input type="text" id="item_qty" name="products[{{$i}}][quantity]" class="form-control" placeholder="Qty in {{ $product->units }}">
                    <input type="hidden" name="products[{{$i}}][product_id]" class="form-control " value="{{ $product->id }}" >
                    </span>
                    <small class="fw-normal ps-2 text-muted"> {{ $product->units }}</small>

                </div>

                </div>
                </div>
            <?php $i++;?>
            @endforeach

		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		    <button type="submit" class="btn btn-default mt-3 px-5 py-3">Submit</button>
		    </div>
		</div>
    </form>
    </div>
    </div>
<!-- <p class="text-center text-primary"><small>Tutorial by edutechsolutions</small></p> -->
</div>
</div>
@endsection