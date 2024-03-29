@extends('layouts.master')

@section('content')
<div class="contianer-fluid main-bg ">
    <div class="top-banner">
    <div class="row justify-content-between align-items-center">
    <div class="col-md-8 text-end">
    <nav aria-label="breadcrumb">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item fs-5"><a href="/">Home</a></li>
     <li class="breadcrumb-item active fs-5" aria-current="page">
       Orders </li>
  </ol>
</nav>
    </div>
              <!--   <h2 class="fw-bold text-white fs-4 ">Orders</h2> -->

              <?php
                if(session('user.info.role_id')==2 || session('user.info.role_id')==3){
              ?>

                  <div class="col-md-4 text-end">
                    <a class="btn btn-warning text-white py-3 px-4" href="/orders/category"> Create your New Order</a>
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

              @if (session('error'))
                  <div class="alert alert-danger">
                      {{ session('error') }}
                  </div>
              @endif
    </div>

    <div class="tb-sec">
    <div class="table-responsive ">
    <table class="table table-bordered ">
        <thead class="table-dark">
        <tr>
          <?php
            if(session('user.info.role_id')==2 || session('user.info.role_id')==3){
          ?>
            <th>S.No</th>
            <th>Component</th>
            <th>Supplier Name</th>
            <th>Contact Number</th>
            <th>Status</th>
            <th>Order Id</th>
            <?php
            } else if(session('user.info.role_id')==5){
            ?>
            <th>S.No</th>
            <th>Mandal</th>
            <th>School ID</th>
            <th>School Name</th>
            <th>Order Id</th>
            <th>Order Name</th>
            <th>HM Name</th>
            <th>Contact Number</th>
            <th>Status</th>
            <?php
            } else if(session('user.info.role_id')==6){
            ?>

            <th>S.No</th>
            <th>District</th>
            <th>Mandal</th>
            <th>Village</th>
            <th>School ID</th>
            <th>School Name</th>
            <th>PIN Code</th>
            <th>Address</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>HM Name</th>
            <th>HM Contact Number</th>
            <th>Order Id</th>
            <th>Status</th>

            <?php
            }
            ?>

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
          <?php
            if(session('user.info.role_id')==2 || session('user.info.role_id')==3){
          ?>
            <td>{{ $order->oid }}</td>
            <td>{{ $order->cat_name }}</td>
            <td class="fw-bold">{{ $order->supplierName }}</td>
            <td>{{ $order->supplierNumber }}</td>
            <td><span class="acknowledge ">
            <?php
              if($order->invoice_status==0){
                echo "Pending";
              }else if($order->invoice_status==1){
                echo "Completed";
              }else if($order->invoice_status==3){
                echo "Rejected";
              }else{
                echo "Acknowledged";
              }
              ?>
              
            </span>
             @if($order->invoice_status==0) / 
             <span class="pending ">{{ $order->apc_approved_status==0?"Yet to Approve":"Approved by APC" }}</span>
             @endif
            </td>
            <td ><a class=" btn btn-link" role="button" href="/order/view/{{ $order->oid }}">{{ $order->order_num }}</a></td>

            <?php
            } else if(session('user.info.role_id')==5){
            ?>

            <td>{{ $i }}</td>
            <td>{{ $order->mandal_name }}</td>
            <td>{{ $order->school_id }}</td>
            <td>{{ $order->school_name }}</td>
            <td ><a class=" btn btn-link" role="button" href="/order/view/{{ $order->oid }}">{{ $order->order_num }}</a></td>
            <td>{{ $order->order_num }}</td>
            <td>{{ $order->hm_name }}</td>
            <td>{{ $order->hm_contact_num }}</td>
            <td><span class="acknowledge ">
            <?php
              if($order->invoice_status==0){
                echo "Pending";
              }else if($order->invoice_status==1){
                echo "Completed";
              }else if($order->invoice_status==3){
                echo "Rejected";
              }else{
                echo "Acknowledged";
              }
              ?>
              
            </span>
             @if($order->invoice_status==0) / 
             <span class="pending ">{{ $order->apc_approved_status==0?"Yet to Approve":"Approved by APC" }}</span>
             @endif
            </td>
            <?php
            } else if(session('user.info.role_id')==6){
            ?>
             <td>{{ $i }}</td>
            <td>{{ $order->dist_name }}</td>
            <td>{{ $order->mandal_name }}</td>
            <td>{{ $order->village_name }}</td>
            <td>{{ $order->school_id }}</td>
            <td>{{ $order->school_name }}</td>
            <td>{{ $order->UDISE_code }}</td>
            <td>{{ $order->school_name }}</td>
            <td>{{ $order->latitude }}</td>
            <td>{{ $order->longitude }}</td>
            <td>{{ $order->hm_name }}</td>
            <td>{{ $order->hm_contact_num }}</td>
            <td ><a class=" btn btn-link" role="button" href="/order/view/{{ $order->oid }}">{{ $order->order_num }}</a></td>
            
            <td><span class="acknowledge ">
              <?php
              if($order->invoice_status==0){
                echo "Pending";
              }else if($order->invoice_status==1){
                echo "Completed";
              }else if($order->invoice_status==3){
                echo "Rejected";
              }else{
                echo "Acknowledged";
              }
              ?>
              
            </span>
             @if($order->invoice_status==0) / 
             <span class="pending ">{{ $order->apc_approved_status==0?"Yet to Approve":"Approved by APC" }}</span>
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



{!! $orders->links('vendor.pagination.table') !!}
</div>
</div>
    </div>


    </div>
</div>
@endsection