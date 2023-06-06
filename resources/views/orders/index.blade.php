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
            <th>Order Id</th>
            <th>School</th>
            <th>HM</th>
            <th>Contact Number</th>
        </tr>
	    @foreach ($products as $order)
        <?php
       // echo "<pre>";print_r($order);exit;
        ?>

	    <tr>
            <td><a href="/order/view/{{ $order->oid }}">{{ $order->oid }}</a></td>
            <td>{{ $order->school_name }}</td>
            <td>{{ $order->hm_name }}</td>
            <td>{{ $order->hm_contact_num }}</td>
	    </tr>
	    @endforeach
    </table>


    {!! $products->links() !!}


<p class="text-center text-primary"><small>Tutorial by edutechsolutions</small></p>
@endsection