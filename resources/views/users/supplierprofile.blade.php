@extends('layouts.master')


@section('content')
<div class="main-bg">
<h1 class="display-5 pt-5 text-center fw-bold title-clr lh-base text-capitalize mb-2">
        <small>Supplier Profile</small></h1>
<div class="container pt-5 pb-4">

@if ($message = Session::get('success'))
<div class="alert alert-success">
  {{ $message }}
</div>
@endif

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
    <form action="/updatesuppilerprofile" class="card cat-crd pt-4 px-4 pb-3 p-md-5 pb-md-4" method="POST">
    @csrf
         <div class="row flex-wrap">
            <?php $i=0; ?>
            <input type="hidden" name="supplier_details_id" value="<?php if(isset($supplier_details->supplier_details_id) && $supplier_details->supplier_details_id!=""){ echo $supplier_details->supplier_details_id;} ?>" />

            <div class="form-group row flex-wrap pb-3 pt-3 align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Firm Name </label>
                    <div class="col-md-6 ">
                       <input type="text" class="form-control" id="firm_name" name="firm_name" value="<?php if(isset($supplier_details->firm_name) && $supplier_details->firm_name!=""){ echo $supplier_details->firm_name;} ?>" >
                    </div>
                </div>
                <div class="form-group row flex-wrap pb-3 pt-3 align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Bank Account Number</label>
                    <div class="col-md-6 ">
                        <input type="number" class="form-control" id="bank_account_number" name="bank_account_number" value="<?php if(isset($supplier_details->bank_account_number) && $supplier_details->bank_account_number!=""){ echo $supplier_details->bank_account_number;} ?>" >
                    </div>
                </div>
                <div class="form-group row flex-wrap pb-3 pt-3 align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Bank Account Name</label>
                    <div class="col-md-6 ">
                        <input type="text" class="form-control" id="bank_account_name" name="bank_account_name" value="<?php if(isset($supplier_details->bank_account_name) && $supplier_details->bank_account_name!=""){ echo $supplier_details->bank_account_name;} ?>" >
                    </div>
                </div>

                <div class="form-group row flex-wrap pb-3 pt-3 align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Bank IFSC </label>
                    <div class="col-md-6 ">
                        <input type="text" class="form-control" id="bank_ifsc" name="bank_ifsc" value="<?php if(isset($supplier_details->bank_ifsc) && $supplier_details->bank_ifsc!=""){ echo $supplier_details->bank_ifsc;} ?>" >
                    </div>
                </div>
                <div class="form-group row flex-wrap pb-3 pt-3 align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Firm Pan Number</label>
                    <div class="col-md-6 ">
                    <input type="text" class="form-control" id="firm_pan_number" name="firm_pan_number" value="<?php if(isset($supplier_details->firm_pan_number) && $supplier_details->firm_pan_number!=""){ echo $supplier_details->firm_pan_number;} ?>" >
                    </div>
                </div>
                <div class="form-group row flex-wrap pb-3 pt-3 align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">GST Number </label>
                    <div class="col-md-6 ">
                        <input type="text" class="form-control" id="gst_number" name="gst_number" value="<?php if(isset($supplier_details->gst_number) && $supplier_details->gst_number!=""){ echo $supplier_details->gst_number;} ?>" >
                    </div>
                </div>
                <div class="form-group row flex-wrap pb-3 pt-3 align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">AADHAAR Number</label>
                    <div class="col-md-6 ">
                        <input type="text" class="form-control" id="aadhaar_number" name="aadhaar_number" value="<?php if(isset($supplier_details->aadhaar_number) && $supplier_details->aadhaar_number!=""){ echo $supplier_details->aadhaar_number;} ?>" >
                    </div>
                </div>

		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		            <button type="submit" class="btn btn-default mt-3 px-4 py-3">Submit</button>
		    </div>

    </form>
    </div>
    </div>
</div>
</div>
@endsection