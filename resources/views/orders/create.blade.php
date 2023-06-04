@extends('layouts.master')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Order</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('orders.index') }}"> Back</a><br/><br/>
            </div>
        </div>
    </div>


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


    <form action="{{ route('api.store') }}" method="POST">
    	@csrf
       
         <div class="row">
            @foreach ($product as $product)
            <?php 
         //   echo "<pre>";print_r(Session::all());exit;
            ?>
                <div class="col-xs-6 col-sm-6 col-md-6">
                
                    <div class="form-group">
                    {{ $product->name }}<input type="text" id="item_qty" name="item_qty[]" class="form-control" placeholder="Qty">
                    <input type="hidden" name="prodct_id[]" class="form-control" value="{{ $product->id }}" >
                    <input type="hidden" name="school_id" class="form-control" value="1" >
                    </div>
                </div>
               
            @endforeach
            

		    <div class="col-xs-6 col-sm-6 col-md-6 text-center">
		            <button type="submit" class="btn btn-primary">Submit</button>
		    </div>
		</div>
       

    </form>


<p class="text-center text-primary"><small>Tutorial by edutechsolutions</small></p>
@endsection