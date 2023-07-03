@extends('layouts.master')


@section('content')
<div class="main-bg">
<div class="container pt-5 pb-4">

<h1 class="display-5 text-center fw-bold title-clr text-capitalize mb-5">
        <small>My School Profile</small></h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h2 class="fw-normal py-4 text-center"><span class="fw-bold">Whoops!</span>
             There were some problems with your input.</h2>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
    <div class="row justify-content-center">
   <div class="col-md-6">
    <?php
    //echo "<pre>";print_r($schoolDetails);exit;
    ?>
    <form action="/updateSchoolprofile" class="card cat-crd pt-4 px-4 pb-3 p-md-5 pb-md-4" method="POST">
    @csrf
         <div class="row">
            <?php $i=0; ?>
            <input type="hidden" name="school_id" value="{{$schoolDetails['id']}}" />
            <div class="col-md-12">
            <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">School ID </label>
                    <div class="col-md-6 d-flex align-items-center">
                        {{$schoolDetails['UDISE_code']}}
                    </div>
                </div>
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">School Name </label>
                    <div class="col-md-6 d-flex align-items-center">
                        {{$schoolDetails['school_name']}}
                    </div>
                </div>

                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">School Category *</label>
                    <div class="col-md-6 d-flex align-items-center">
                        <select id="school_category"  name="school_category" class="form-control">
                           <?php
                            if(isset($schoolDetails['school_category']) && $schoolDetails['school_category']==1){
                           ?>
                            <option value="1" selected>Primary</option>
                            <?php
                            }else{
                            ?>
                             <option value="1" >Primary</option>
                            <?php
                            }
                            ?>

                            <?php
                            if(isset($schoolDetails['school_category']) && $schoolDetails['school_category']==2){
                           ?>
                            <option value="2" selected>Upper Primary</option>
                            <?php
                            }else{
                            ?>
                             <option value="2" >Upper Primary</option>
                            <?php
                            }
                            ?>

                           <?php
                            if(isset($schoolDetails['school_category']) && $schoolDetails['school_category']==3){
                           ?>
                            <option value="3" selected>Secondary</option>
                            <?php
                            }else{
                            ?>
                             <option value="3" >Secondary</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">No of Teachers *</label>
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="text" id="no_of_teachers" name="no_of_teachers" class="form-control" value="<?php if(isset($schoolDetails['no_of_teachers']) && $schoolDetails['no_of_teachers']!=""){ echo $schoolDetails['no_of_teachers'];} ?>" >
                    </div>
                </div>

                <div class="form-group pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">No Of Students *</label>
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="text" id="total_strength" name="total_strength" class="form-control"  value="<?php if(isset($schoolDetails['total_strength']) && $schoolDetails['total_strength']!=""){ echo $schoolDetails['total_strength'];} ?>" >
                    </div>
                </div>

                <div class="form-group  pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Girls *</label>
                    <div class="col-md-6 d-flex align-items-center">
                    <input type="text" id="no_of_girls" name="no_of_girls" class="form-control" value="<?php if(isset($schoolDetails['no_of_girls']) && $schoolDetails['no_of_girls']!=""){ echo $schoolDetails['no_of_girls'];} ?>" >
                    </div>
                </div>

                <div class="form-group pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Boys *</label>
                    <div class="col-md-6 d-flex align-items-center">
                    <input type="text" id="no_of_boys" name="no_of_boys" class="form-control"  value="<?php if(isset($schoolDetails['no_of_boys']) && $schoolDetails['no_of_boys']!=""){ echo $schoolDetails['no_of_boys'];} ?>" >
                    </div>
                </div>


                <div class="form-group pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">No Of  Class rooms *</label>
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="text" id="no_of_class_rooms" name="no_of_class_rooms" class="form-control" placeholder="No Of  Class rooms" value="<?php if(isset($schoolDetails['no_of_class_rooms']) && $schoolDetails['no_of_class_rooms']!=""){ echo $schoolDetails['no_of_class_rooms'];} ?>" >
                    </div>
                </div>

                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">School Address </label>
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="text" id="school_address" name="school_address" class="form-control" placeholder="School Address" value="<?php if(isset($schoolDetails['school_address']) && $schoolDetails['school_address']!=""){ echo $schoolDetails['school_address'];} ?>" >
                    </div>
                </div>
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">PIN Code </label>
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="text" id="pin_code" name="pin_code" class="form-control" placeholder="Pin Code" value="<?php if(isset($schoolDetails['pin_code']) && $schoolDetails['pin_code']!=""){ echo $schoolDetails['pin_code'];} ?>" >
                    </div>
                </div>


                <p class="pb-0 pt-4 fs-5 text-body fw-bold">
                  School Location </p>



                <div class="form-group  pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">latitude *</label>
                    <div class="col-md-6 d-flex align-items-center">
                    <input type="text" id="latitude" name="latitude" class="form-control" value="<?php if(isset($schoolDetails['latitude']) && $schoolDetails['latitude']!=""){ echo $schoolDetails['latitude'];} ?>" >
                    </div>
                </div>

                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">longitude *</label>
                    <div class="col-md-6 d-flex align-items-center">
                    <input type="text" id="longitude" name="longitude" class="form-control"  value="<?php if(isset($schoolDetails['longitude']) && $schoolDetails['longitude']!=""){ echo $schoolDetails['longitude'];} ?>" >
                    </div>
                </div>
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Head Master Name *</label>
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="text" id="hm_name" name="hm_name" class="form-control" placeholder="HM Name" value="<?php if(isset($schoolDetails['hm_name']) && $schoolDetails['hm_name']!=""){ echo $schoolDetails['hm_name'];} ?>" >
                    </div>
                </div>
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Head Master Contact Number *</label>
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="text" id="hm_contact_num" name="hm_contact_num" class="form-control" placeholder="HM contact number" value="<?php if(isset($schoolDetails['hm_contact_num']) && $schoolDetails['hm_contact_num']!=""){ echo $schoolDetails['hm_contact_num'];} ?>" >

                    </div>
                </div>
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Alternate Person Name </label>
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="text" id="eng_name" name="eng_name" class="form-control" placeholder="Eng Name" value="<?php if(isset($schoolDetails['eng_name']) && $schoolDetails['eng_name']!=""){ echo $schoolDetails['eng_name'];} ?>" >

                    </div>
                </div>
            <div class="col-md-12">
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Alternative Person Contact Number </label>
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="text" id="eng_contact" name="eng_contact" class="form-control" placeholder="Eng contact number" value="<?php if(isset($schoolDetails['eng_contact']) && $schoolDetails['eng_contact']!=""){ echo $schoolDetails['eng_contact'];} ?>" >
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