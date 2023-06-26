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
          <?php
            if(session('user.info.role_id')==5){
            ?>
            <th>School</th>
            <th>Supplier</th>
            <th>Bill Amount</th>
            <th>TDS amount</th>
            
            <th>Bill Date</th>
            <th>Status</th>
            <th>Order No</th>
            <th>Action</th>
            <?php
            } 
            ?>
        </tr>
        </thead>
        <tbody>
      @php
        $i=1;
      @endphp

	    @foreach ($paymentsList as $payment)
        <?php
       //echo "<pre>";print_r($order);exit;
        ?>
	    <tr>
          <?php
            if(session('user.info.role_id')==5){
          ?>
            <td>{{ $payment->school_name }}</td>
            <td>{{ $payment->supplierName }}</td>
            <td>{{ $payment->bill_amount }}</td>
            <td>{{ $payment->tds_amount }}</td>
            
            <td>{{ Date('Y-m-d',strtotime($payment->bill_generated_date)) }}</td>
            <td>{{ $payment->paid_status==0?'Not Paid':"Paid" }}</td>
            <td >{{ $payment->order_num }}</td>
            <td>@if($payment->paid_status == 0)
              <a class=" btn btn-link" role="button" href="javascript:alert('payment in progress')">Pay</a>
              @else
              <a class=" btn btn-link" role="button" href="javascript:alert('payment in progress')">>Paid</a>
              @endif
            </td>
            <?php
            } 
            ?>


	    </tr>
      @php
      $i++;
      @endphp
	    @endforeach
        </tbody>
    </table>
    <div class="row align-items-center justify-content-end">
<div class="col-md-3">



{!! $paymentsList->links('vendor.pagination.table') !!}
</div>
</div>
    </div>

  
    </div>
</div>
@endsection