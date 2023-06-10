@extends('layouts.master')


@section('content')
<div class="main-bg">
<div class="container pt-5 pb-4">

<p class="fw-normal fs-5 text-capitalize pb-0 mb-0 text-muted text-center">
        <small>My School Profile</small></p>

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
    <form action="/order/create" class="card cat-crd pt-4 px-4 pb-3 p-md-5 pb-md-4" method="POST">
    @csrf
         <div class="row">
            <?php $i=0; ?>
            <input type="hidden" name="school_id" value="{{$schoolDetails['id']}}" />
            <div class="col-md-12">
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-8">School Name </label>
                    <div class="col-md-4 d-flex align-items-center">
                        {{$schoolDetails['school_name']}}
                    </div>
                </div>
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-8">Login ID </label>
                    <div class="col-md-4 d-flex align-items-center">
                        {{$schoolDetails['login_id']}}
                    </div>
                </div>
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-8">School Location </label>
                    <div class="col-md-4 d-flex align-items-center">
                        {{$schoolDetails['latitude']}} - {{$schoolDetails['longitude']}}
                    </div>
                </div>
            <div class="col-md-12">
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-8">Contact Number </label>
                    <div class="col-md-4 d-flex align-items-center">
                        <input type="text" value="{{$schoolDetails['hm_contact_num']}}" id="contact_nuber" name="contact_nuber" class="form-control" placeholder="HM contact">
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-8">Head Master Name </label>
                    <div class="col-md-4 d-flex align-items-center">
                        <input type="text"  value="{{$schoolDetails['hm_name']}}" id="contact_nuber" name="contact_nuber" class="form-control" placeholder="HM contact">
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-8">Engineer Name </label>
                    <div class="col-md-4 d-flex align-items-center">
                        <input type="text" value="{{$schoolDetails['eng_name']}}" id="contact_nuber" name="contact_nuber" class="form-control" placeholder="Eng Name">
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-8">Engineer Contact No </label>
                    <div class="col-md-4 d-flex align-items-center">
                        <input type="text" value="{{$schoolDetails['eng_contact']}}" id="contact_nuber" name="contact_nuber" class="form-control" placeholder="Eng contact number">
                    </div>

                </div>
            </div>
		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		            <button type="submit" class="btn btn-primary mt-3 px-4 py-3">Submit</button>
		    </div>
		</div>
    </form>
    </div>
    </div>
<!-- <p class="text-center text-primary"><small>Tutorial by edutechsolutions</small></p> -->
</div>
</div>
@endsection