@extends('layouts.master')

@section('content')
<div class="contianer-fluid ed-inner-pg ">
    <div class="top-banner">
<div class="container">
<!--<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Library</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data</li>
  </ol>
</nav>-->
              <!--   <h2 class="fw-bold text-white fs-4 ">Orders</h2> -->

              <?php
                if(session('user.info.role_id')==2){
              ?>
              <div class="row justify-content-end pt-3 pb-2">
                  <div class="col-md-3 text-end">
                    <a class="btn btn-warning text-white py-3 px-4" href="/orders/category"> Create your New Order</a>
                  </div>
              </div>
              <?php
                }
                ?>

            </div>
              @if ($message = Session::get('success'))
              <div class="alert alert-success">
              {{ $message }}
              </div>
              @endif
    </div>

    <div class="tb-sec">
    <div class="table-responsive ">
    <table class="table table-bordered ">
        <thead class="table-dark">
        <tr>
            <th>Component</th>
            <th>Supplier Name</th>
            <th>Contact Number</th>
            <th>School Name</th>
            <th>HM Name</th>
            <th>Contact Number</th>
            <th>Bill Status</th>
            <th>Order Name</th>

        </tr>
        </thead>
        <tbody>
      @php
        $i=1;
      @endphp

	    @foreach ($orders as $order)
        <?php
       //echo "<pre>";print_r($order);exit;
        ?>
	    <tr>
            <td>{{ $order->cat_name }}</td>
            <td>{{ $order->supplierName }}</td>
            <td>{{ $order->supplierNumber }}</td>
            <td>{{ $order->school_name }}</td>
            <td>{{ $order->hm_name }}</td>
            <td>{{ $order->hm_contact_num }}</td>
            <td>{{ $order->bill_generated==1?"Generated":"Not Yet Generated" }}</td>
            <td ><a class=" btn btn-link" role="button" href="/order/view/{{ $order->oid }}">{{ $order->order_num }}</a></td>
	    </tr>
      @php
      $i++;
      @endphp
	    @endforeach
        </tbody>
    </table>
    <div class="row align-items-center justify-content-end">
<div class="col-md-3">



{!! $orders->links('vendor.pagination.table') !!}
</div>
</div>
    </div>


    </div>
</div>
@endsection