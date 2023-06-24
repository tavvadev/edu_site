@extends('layouts.master')


@section('content')
<div class="main-bg">
<div class="container pt-5 pb-4">

@if ($message = Session::get('success'))
<div class="alert alert-success">
  {{ $message }}
</div>
@endif


<p class="fw-normal fs-5 text-capitalize pb-0 mb-0 text-muted text-center">
        <small>Profile Update</small></p>

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
    <form action="/updateprofile" class="card cat-crd pt-4 px-4 pb-3 p-md-5 pb-md-4" method="POST">
    @csrf
         <div class="row">
            <?php $i=0; ?>
            <input type="hidden" name="id" value="<?php if(isset($user->id) && $user->id!=""){ echo $user->id;} ?>" />
            <div class="col-md-12">
            <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">First Name </label>
                    <div class="col-md-6 d-flex align-items-center">
                       <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($user->name) && $user->name!=""){ echo $user->name;} ?>" >
                    </div>
                </div>

                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Email</label>
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="email" class="form-control" id="email" name="email" value="<?php if(isset($user->email) && $user->email!=""){ echo $user->email;} ?>" >
                    </div>
                </div>
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Contact Number</label>
                    <div class="col-md-6 d-flex align-items-center">
                    <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php if(isset($user->contact_number) && $user->contact_number!=""){ echo $user->contact_number;} ?>" >
                    </div>
                </div>

                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-12">Secret Questions</label>
                </div>

                <?php
                    foreach($questions as $question){
                       // echo "<pre>";print_r($question->name);exit;
                ?>

                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">
                    <label class="fw-bold col-md-6">Question </label>
                    <div class="col-md-6 d-flex align-items-center">
                        {{$question->name}}?
                    </div>
                </div>
                <div class="form-group border-bottom pb-3 pt-3 d-flex align-items-center justify-content-between mb-2">

                    <label class="fw-bold col-md-2">Answer </label>
                    <div class="col-md-4 d-flex align-items-center">
                    <input type="text" class="form-control" id="answer_{{$question->id}}" name="answer[]" value="<?php if(isset($user->answer) && $user->answer!=""){ echo $user->answer;} ?>" >
                    </div>

                    <label class="fw-bold col-md-2">Confirm Answer </label>
                    <div class="col-md-4 d-flex align-items-center">
                    <input type="text" class="form-control" id="confirm_ans_{{$question->id}}" name="confirm_ans[]" value="<?php if(isset($user->answer) && $user->answer!=""){ echo $user->answer;} ?>" >
                    </div>
                </div>


                <?php
                    }
                ?>
                
                    
		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		            <button type="submit" class="btn btn-primary mt-3 px-4 py-3">Submit</button>
		    </div>
		</div>
    </form>
    </div>
    </div>
</div>
</div>
@endsection