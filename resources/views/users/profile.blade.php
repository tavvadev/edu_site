@extends('layouts.master')


@section('content')
<div class="main-bg">
<div class="container pt-5 pb-4">



<h1 class="display-5 text-center fw-bold title-clr text-capitalize mb-5">
        <small>Profile Update</small></h1>

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
    <form action="/updateprofile" class="card cat-crd pt-4 px-4 pb-3 p-md-5 pb-md-4" method="POST">
    @csrf
         <div class="row flex-wrap">
            <?php $i=0; ?>
            <input type="hidden" name="id" value="<?php if(isset($user->id) && $user->id!=""){ echo $user->id;} ?>" />


            <div class="d-flex flex-wrap">


            <div class="col-sm-12">


            <h2 class="fs-5 fw-bold text-body mb-1 mt-4 text-start w-100">Profile update Details </h2>
            <p class="fs-6 fw-normal text-muted mb-4 text-start w-100">You can update or edit your already updated profile
                details
                 here</p>
                 </div>
                 <div class="col-sm-12">

                 </div>
                </div>
            <div class="form-group col-md-12  mb-4">
                    <label class="fw-bold text-muted">First Name </label>

                       <input type="text" class="form-control" required="required" id="name" name="name" value="<?php if(isset($user->name) && $user->name!=""){ echo $user->name;} ?>" >

                </div>

                <div class="form-group col-md-12  mb-4">
                    <label class="fw-bold text-muted">Email</label>

                        <input type="email" required="required" class="form-control" id="email" name="email" value="<?php if(isset($user->email) && $user->email!=""){ echo $user->email;} ?>" >

                </div>
                <div class="form-group col-md-12  mb-4">
                    <label class="fw-bold text-muted">Contact Number</label>

                    <input type="text" required="required" class="form-control" id="contact_number" name="contact_number" value="<?php if(isset($user->contact_number) && $user->contact_number!=""){ echo $user->contact_number;} ?>" >

                </div>

               <!--  <h2 class="fs-5 fw-bold text-body mb-2 mt-4 text-start w-100">Secure Questions </h2> -->

                <div class="form-group col-md-12 mt-4  mb-4">
                    <label class="fw-bold text-muted">Secret Question </label>


                    <select id="question"  name="question" class="form-control">
                        <?php
                        foreach($questions as $question){
                            if($question->id == $user->question_id){
                        ?>
                            <option value="{{$question->id}}" selected >{{$question->name}}?</option>
                            <?php
                            }else{
                            ?>
                            <option value="{{$question->id}}" >{{$question->name}}?</option>
                        <?php
                             }
                        }
                        ?>
                    </select>

                </div>
                <div class="form-group col-md-12  mb-4">

                    <label class="fw-bold text-muted">Answer </label>

                    <input type="text" required="required" class="form-control" id="answer" name="answer" value="<?php if(isset($user->answer) && $user->answer!=""){ echo $user->answer;} ?>" >


                </div>
                <div class="form-group col-md-12  mb-4">

                    <label class="fw-bold text-muted">Confirm Answer </label>

                    <input type="text" required="required" class="form-control" id="confirm_ans" name="confirm_ans" value="<?php if(isset($user->answer) && $user->answer!=""){ echo $user->answer;} ?>" >

                </div>


		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		            <button type="submit" class="btn btn-primary mt-3 px-4 py-3">Submit</button>
		    </div>

    </form>
    </div>
    </div>
</div>
</div>
@endsection