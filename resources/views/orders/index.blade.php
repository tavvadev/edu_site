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
    <table class="table table-bordered ">
        <thead class="table-dark">


        <tr>

            <th>School</th>
            <th>HM</th>
            <th>Contact Number</th>
            <th>Order Id</th>
        </tr>
        </thead>
        <tbody>
	    @foreach ($products as $order)
        <?php
       // echo "<pre>";print_r($order);exit;
        ?>
	    <tr>
            <td>{{ $order->school_name }}</td>
            <td>{{ $order->hm_name }}</td>
            <td>{{ $order->hm_contact_num }}</td>
            <td class="text-center"><a class=" btn btn-link" role="button" href="/order/view/{{ $order->oid }}">{{ $order->oid }}</a></td>
	    </tr>
	    @endforeach
        </tbody>
    </table>
    </div>

    {!! $products->links() !!}
    </div>

<p class="text-center text-primary"><small>Tutorial by edutechsolutions</small></p>

</div>
@endsection