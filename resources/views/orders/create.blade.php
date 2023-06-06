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

<p class="fw-normal fs-5 text-capitalize pb-0 mb-0 text-muted text-center">Add number of quantities to </p>
<h2 class="title-clr text-center display-3 fw-bold mb-5">your order</h2>



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


    <div class="row justify-content-center">
   <div class="col-md-6">
    <form action="{{ route('orders.store') }}" class="card cat-crd p-4 p-md-5" method="POST">
    	@csrf
         <div class="row">
            @foreach ($product as $product)
            <?php
         //   echo "<pre>";print_r(Session::all());exit;
            ?>
                <div class="col-md-12">
                    <div class="form-group mb-4">
                    <label class="fw-bold">{{ $product->name }}</label>
                    <input type="text" id="item_qty" name="item_qty[]" class="form-control" placeholder="Qty">
                    <input type="hidden" name="prodct_id[]" class="form-control" value="{{ $product->id }}" >
                    <input type="hidden" name="school_id" class="form-control" value="1" >
                    </div>
                </div>

            @endforeach


		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		            <button type="submit" class="btn btn-primary mt-3 px-4 py-3">Submit</button>
		    </div>
		</div>


    </form>
    </div>
    </div>
<p class="text-center text-primary"><small>Tutorial by edutechsolutions</small></p>
</div>
</div>
@endsection