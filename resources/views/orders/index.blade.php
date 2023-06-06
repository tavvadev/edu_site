@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Orders</h2>
            </div>
            <div class="pull-right">
               <a class="btn btn-success" href="/orders/category"> Create New Order</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Order Id</th>
            <th>School</th>
            <th>HM</th>
            <th>Contact Number</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($products as $order)
        <?php
       // echo "<pre>";print_r($order);exit;
        ?>

	    <tr>
	        <td>{{ ++$i }}</td>
            <td>{{ $order->id }}</td>
            <td>{{ $order->school_name }}</td>
            <td>{{ $order->hm_name }}</td>
            <td>{{ $order->hm_contact_num }}</td>
	        <td>
            <a class="btn btn-info" href="#">View Order</a>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $products->links() !!}


<p class="text-center text-primary"><small>Tutorial by edutechsolutions</small></p>
@endsection