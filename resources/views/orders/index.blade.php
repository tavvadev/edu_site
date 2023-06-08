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
            <th>Order Id</th>
            <th>Indent</th>
            <th>School</th>
            <th>HM</th>
            <th>Contact Number</th>
            <th>Status</th>
            <th>Order Id</th>

        </tr>
        </thead>
        <tbody>
	    @foreach ($orders as $order)
        <?php
       // echo "<pre>";print_r($order);exit;
        ?>
	    <tr>
            <td>{{ $order->oid }}</td>
            <td>{{ $order->cat_name }}</td>
            <td>{{ $order->school_name }}</td>
            <td>{{ $order->hm_name }}</td>
            <td>{{ $order->hm_contact_num }}</td>

            <td><span class="pending ">{{ $order->invoice_status==0?"Pending":($order->invoice_status==1?"Completed":"Acknoledged") }}</span> @if($order->invoice_status==0) / <span class="pending ">{{ $order->apc_approved_status==0?"Yet to Approve":"Approved by APC" }}</span>@endif</td>
            <td ><a class=" btn btn-link" role="button" href="/order/view/{{ $order->oid }}">{{ $order->order_num }}</a></td>
	    </tr>
	    @endforeach
        </tbody>
    </table>
    <div class="row align-items-center justify-content-end">
<div class="col-md-3">



    <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item active" aria-current="page"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav>
</div>
</div>
    </div>

   <!--  {!! $orders->links() !!} -->
    </div>
</div>
@endsection