@extends('layouts.master')

@section('content')
<div class="contianer-fluid main-bg ">
    <div class="top-banner ">

    <div class="row justify-content-between align-items-center">
    <div class="col-md-8 text-end">

  <nav aria-label="breadcrumb">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item fs-5"><a href="/orders">Orders</a></li>
     <li class="breadcrumb-item active fs-5" aria-current="page">{{$orderDetails->cat_name}} Order Details </li>
  </ol>
</nav>
    </div>

    <div class="col-md-4 text-end">
  <?php
                if(session('user.info.role_id')==2 || session('user.info.role_id')==3){
              ?>
             <a class="btn btn-warning text-white py-3 px-4" href="/orders/category"> Create your New Order</a>
              <?php
                }
                ?>
  </div>
</div>
             <!--   <h2 class="fw-bold text-white fs-4 ">Orders</h2> -->

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
    <form action="/order/updateorder" class=" " method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="order_id" value="{{$orderDetails->orderId}}" />
    <div class="tb-sec">
   <!--  <h2 class="fs-5 fw-bold title-clr mb-2">Order Details</h2> -->
    <div class="table-responsive ">
    <table class="table table-bordered " >
        <thead class="table-dark">
        <tr>
            <th>Product Name</th>
            <th>Ordered Qty</th>
            <th>Price</th>
            <th>Deilvered Qty</th>
            <th>Amount</th>
            @if($user['role'] == 'HM' && ($orderDetails->invoice_status==1 || $orderDetails->invoice_status==2))
            <th>Ack Qty</th>
            @endif
            @if($user['role'] == 'EE' && ($orderDetails->invoice_status==1 || $orderDetails->invoice_status==2))
            <th>Ack Qty</th>
            @endif
        </tr>
        </thead>
        <tbody>
            @foreach ($orderDetails->products as $product)
            <?php
           // echo "<pre>";print_r($product);exit;
            ?>

	    <tr>
            <td>{{$product->product_name}}</td>
            <td>{{$product->quantity}} {{$product->units}}</td>
            <td>{{$product->productPrice}}</td>
            @if($user['role'] == 'HM' && $orderDetails->invoice_status==1 )
                @if($user['role'] == 'HM' && $orderDetails->invoice_status==1)
                <td>{{$product->quantity}} {{$product->units}}</td>
                <td>@php echo $product->bill_qty*$product->productPrice @endphp</td>
                <td>
                <div class="form-group">
                  <input type="number" value="{{$product->bill_qty}}"
                  name="ack_qty[{{$product->pid}}]" max="{{$product->quantity}}" min="0" /></div>
                </td>
                @else
                <td>{{$product->bill_qty}}</td>
                @endif
                @if($user['role'] == 'HM' && $orderDetails->invoice_status==2)
                <td>{{$product->ack_qty}}</td>
                @endif
            @endif

            @if($user['role'] == 'EE' || $user['role'] == 'HM' && $orderDetails->invoice_status==2)
                @if($user['role'] == 'EE' && $orderDetails->invoice_status==1)
                <td>
                <div class="form-group">
                <input type="number" value="{{$product->bill_qty}}"
                name="ack_qty[{{$product->pid}}]"
                max="{{$product->quantity}}"
                min="0"/>
                </div>
                </td>
                @else
                <td>{{$product->bill_qty}}</td>
                @endif
                <td>@php echo $product->bill_qty*$product->productPrice @endphp</td>
                @if(($user['role'] == 'EE' || $user['role'] == 'HM') && $orderDetails->invoice_status==2)
                <td>{{$product->ack_qty}}</td>
                @endif
            @endif

              @if($user['role'] == 'APC' || $user['role'] == 'FAO' )
                <td>{{$product->bill_qty}}</td>
                <td>@php echo $product->bill_qty*$product->productPrice @endphp</td>
              @endif

              @if($user['role'] == 'Supplier')

                  @if($user['role'] == 'Supplier' && $orderDetails->invoice_status==0)
                  <td>   <div class="form-group w-auto">
                    <input type="number" onChange="ProductPriceChange({{$product->pid}},
                    {{$product->productPrice}});" id="delivered_qty_{{$product->pid}}"
                    name="delivered_qty[{{$product->pid}}]" max="{{$product->quantity}}" min="0" /></div></td>
                  @else
                  <td>{{$product->bill_qty}}</td>
                  @endif


                  @if($user['role'] == 'Supplier' && $orderDetails->invoice_status==0)
                  <td>   <div class="form-group"><input type="number" value="" id="ack_qty_price_{{$product->pid}}" name="ack_qty_price_[{{$product->pid}}]"  min="0" readonly />
                </div></td>
                  @else
                  <td>@php echo $product->bill_qty*$product->productPrice @endphp</td>
                  @endif
              @endif

	    </tr>
	    @endforeach
        </tbody>
    </table>
    </div>

    @if($user['role'] == 'Supplier')
  
    @if($user['role'] == 'Supplier' && $orderDetails->invoice_status!=0 && $orderDetails->delivered_qty!=$orderDetails->total_qty)
    <div class="table-responsive ">
      <table class="table table-bordered " >
          <thead class="table-dark">
          <tr>
              <th>Product Name</th>
              <th>Ordered Qty</th>
              <th>Price</th>
              <th>Deilvered Qty</th>
              <th>Amount</th>
              @if($user['role'] == 'HM' && ($orderDetails->invoice_status==1 || $orderDetails->invoice_status==2))
              <th>Ack Qty</th>
              @endif
              @if($user['role'] == 'EE' && ($orderDetails->invoice_status==1 || $orderDetails->invoice_status==2))
              <th>Ack Qty</th>
              @endif
          </tr>
          </thead>
          <tbody>
              @foreach ($orderDetails->products as $product)

  @if($product->pending_qty!=0)
        <tr>
              <td>{{$product->product_name}}</td>
              <td>{{$product->quantity}} {{$product->units}}</td>
              <td>{{$product->productPrice}}</td>
              @if($user['role'] == 'HM' )
                  @if($user['role'] == 'HM' && $orderDetails->invoice_status==1)
                  <td>
                  <div class="form-group">
                    <input type="number" value="{{$product->bill_qty}}"
                    name="ack_qty[{{$product->pid}}]" max="{{$product->quantity}}" min="0" /></div>
                  </td>
                  @else
                  <td>{{$product->bill_qty}}</td>
                  @endif
                  <td>@php echo $product->bill_qty*$product->productPrice @endphp</td>
                  @if($user['role'] == 'HM' && $orderDetails->invoice_status==2)
                  <td>{{$product->ack_qty}}</td>
                  @endif
              @endif
  
              @if($user['role'] == 'EE' )
                  @if($user['role'] == 'EE' && $orderDetails->invoice_status==1)
                  <td>
                  <div class="form-group">
                  <input type="number" value="{{$product->bill_qty}}"
                  name="ack_qty[{{$product->pid}}]"
                  max="{{$product->quantity}}"
                  min="0"/>
                  </div>
                  </td>
                  @else
                  <td>{{$product->bill_qty}}</td>
                  @endif
                  <td>@php echo $product->bill_qty*$product->productPrice @endphp</td>
                  @if($user['role'] == 'EE' && $orderDetails->invoice_status==2)
                  <td>{{$product->ack_qty}}</td>
                  @endif
              @endif
  
                @if($user['role'] == 'APC' || $user['role'] == 'FAO' )
                  <td>{{$product->bill_qty}}</td>
                  <td>@php echo $product->bill_qty*$product->productPrice @endphp</td>
                @endif
  
                @if($user['role'] == 'Supplier')
  
                    @if($user['role'] == 'Supplier' && $orderDetails->invoice_status!=0)
                    <td>   <div class="form-group w-auto">
                      <input type="number" onChange="ProductPriceChange({{$product->pid}},
                      {{$product->productPrice}});" value="{{$product->pending_qty}}" id="delivered_qty_{{$product->pid}}"
                      name="delivered_qty[{{$product->pid}}]" max="{{$product->quantity}}" min="0" /></div></td>
                    @else
                    <td>{{$product->bill_qty}}</td>
                    @endif
                    
  
                    @if($user['role'] == 'Supplier' && $orderDetails->invoice_status!=0)
                    <td>   <div class="form-group"><input type="number" value="" id="ack_qty_price_{{$product->pid}}" name="ack_qty_price_[{{$product->pid}}]"  min="0" readonly />
                  </div></td>
                    @else
                    <td>@php echo $product->bill_qty*$product->productPrice @endphp</td>
                    @endif
                @endif
  
        </tr>
        @endif
        @endforeach
          </tbody>
      </table>
      </div>

      <div class="col-md-4">
        <div class="form-group mb-3">
        <label class="text-body">Invoice No: </label>
        <input type='text' name="invoice_no" id="invoice_no" value="" />
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group mb-3">
        <label class="text-body">Invoice Date:</label>
         <input type='date' name="invoice_date" id="invoice_date" />
          </div>
      </div>
      <div class="col-md-4">
         <div class="form-group mb-3">
         <label class="text-body">Upload File: </label>
         <input type='file' name="invoice" id="invoice" />
          </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 mt-4 text-center">
        <button type="submit" class="btn btn-default  px-5 mb-2 py-3">Update</button>
</div>

      @endif
      @endif

    <div class=" row justify-content-start pt-4 pb-4 mb-3 border-bottom">
<div class="col-md-6">
<p class="mt-2 mb-3 pt-2 fw-bold title-clr fs-6">Order Details</p>
   <p class="mb-2"><span class="text-muted">Order Id:</span>
   <span class="ps-2 text-body  fw-bold"> {{$orderDetails->invoice_num}}</span>
  </p>
  <p class="mb-2"><span class="text-muted">School:</span>
  <span class="ps-2 text-body  fw-bold">  {{$orderDetails->school_name}}</span></p>
 <p class="mb-2"><span class="text-muted">Head Master:</span>
  <span class="ps-2 text-body  fw-bold"> {{$orderDetails->hm_name}}</span></p>
  <p class="mb-2"><span class="text-muted">Head Master Contact:</span>
  <span class="ps-2 text-body  fw-bold"> {{$orderDetails->hm_contact_num}}</span></p>

  @if($user['role'] != 'Supplier')
@if($orderDetails->invoice_status == 0)
<p class="mb-2"><span class="text-muted">Status:</span>
<span class="ps-2 text-body  fw-bold">Pending</span>
</p>

@elseif($orderDetails->invoice_status == 1)
<p class="mb-2"><span class="text-muted">Status:</span>
<span class="ps-2 text-body  fw-bold">Invoiced</span>
</p>

@elseif($orderDetails->invoice_status == 2)
<p class="mb-2"><span class="text-muted">Status:</span>
<span class="ps-2 text-body  fw-bold"> Acknowledged</span>
</p>
@elseif($orderDetails->invoice_status == 3)
<p class="mb-2"><span class="text-muted">Status:</span>
<span class="ps-2 text-body  fw-bold"> Rejected</span>
</p>

@endif
@endif


    </div>





    <!--   <p class="fw-bold fs-6 title-clr mb-2 lh-base">Invoice Details</p> -->
    <div class="col-md-6">
    
      <div class="row">



      @if($user['role'] == 'Supplier' && $orderDetails->invoice_status==0)
      <div class="col-md-4">
      <div class="form-group mb-3">
    <label class="text-body">Invoice No: </label>
    <input type='text' name="invoice_no" id="invoice_no" value="" />
    </div>
      </div>

<div class="col-md-4">
  <div class="form-group mb-3">
  <label class="text-body">Invoice Date:</label>
   <input type='date' name="invoice_date" id="invoice_date" />
    </div>
</div>
<div class="col-md-8">
   <div class="form-group mb-3">
   <label class="text-body">Upload File: </label>
   <input type='file' name="invoice" id="invoice" />
    </div>
</div>

@elseif(($user['role'] == 'Supplier' || $user['role'] == 'HM' || $user['role'] == 'APC') && $orderDetails->invoice_status>0)
<p class="mt-2 mb-3 pt-2 fw-bold title-clr fs-6">Invoice Details</p>    
@foreach ($orderDetails->invoices as $invoice)
    <p class="mb-2"><span class="text-muted">Invoice No:</span> <span class="ps-2 text-body  fw-bold">{{$invoice->invoice_no}}</span></p>
    <p class="mb-2"><span class="text-muted">Invoice File:</span> <span class="ps-2 text-primary fw-bold"><a href="{{asset($invoice->invoice_file_path)}}"
     target="_blank">Download Invoice</a></span></p>
    <p class="mb-2"><span class="text-muted">Invoice Date:</span> <span class="ps-2 text-body fw-bold">{{$invoice->invoice_date}}</span></p>
    @endforeach
    @endif
      </div>
    </div>
    </div>
    @if($user['role'] == 'Supplier' && $orderDetails->invoice_status==0)
    <div class="col-xs-12 col-sm-12 col-md-12 mt-4 text-center">
        <button type="submit" class="btn btn-default  px-5 mb-2 py-3">Update</button>
</div>
@endif

@if($user['role'] == 'HM' && $orderDetails->invoice_status==1)
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-default mt-4 px-5 mb-2 py-3">Acknowledge Order</button>
</div>
@endif

@if( $user['role'] == 'EE' && $orderDetails->is_acknowledge_ee==1)
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-default mt-4 px-5 mb-2 py-3">Acknowledge Order</button>
</div>
@endif

    @if($user['role'] == 'APC' && ($orderDetails->apc_approved_status==0 && $orderDetails->invoice_status!=3))
    <button type="submit" class="btn btn-primary mt-3 px-4 py-3">Approve</button>
    <button type="button" onClick="rejectedOrder();"  class="btn btn-primary mt-3 px-4 py-3">Reject</button>
    @endif
 </div>
    </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <form >
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Order Rejected?</h5>
        <button type="button" onClick="closeOrder();" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      @csrf
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Reason</label>
                <input type="text" class="form-control" id="reject_reason" name="reject_reason" value="" >
                <span id="reason_error" name="reason_error" style="color:red"></span>
                <input type="hidden" class="form-control" id="reject_order_id" name="reject_order_id" value="{{$orderDetails->orderId}}" >

              </div>

      </div>
      <div class="modal-footer">
        <button type="button" onClick="closeOrder();" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onClick="saveRejectedOrder();" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>




</div>
<script >
  function ProductPriceChange(id, price){
    var qty = $("#delivered_qty_"+id).val();
    $("#ack_qty_price_"+id).val(qty * price);
  }

  function rejectedOrder(){
    $('#exampleModalCenter').modal('show');
  }

  function closeOrder(){
    $('#reject_reason').val('');
    $('#exampleModalCenter').modal('hide');
  }

  function saveRejectedOrder(){
    var flag=true;
    var reject_reason = $('#reject_reason').val();
    var order_id = $('#reject_order_id').val();
    if(reject_reason==""){
      flag=false;
      $('#reason_error').html('Please enter reason.');
    }

    if(flag==true){
      $.ajax({
          type: "POST",
          url: 'http://3.91.54.205/api/rejectedorder',
          contentType: "application/json",
          dataType: "json",
          data: JSON.stringify({
            reason: reject_reason,
            order_id: order_id
          }),
          success: function(response) {
            alert('Order rejected successfully.');
            window.location.reload();
          },
          error: function(response) {
              console.log(response);
          }
      });
  }






  }
  </script>
@endsection