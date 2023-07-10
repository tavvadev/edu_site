@extends('layouts.master')
@section('content')
<div class="main-bg">
<div class="container">
<h1 class="display-5 pt-5 text-center fw-bold title-clr lh-base text-capitalize mb-4">
        <small class="fs-5 fw-normal">Welcome to </small>
        <p> edutech Dashboard</p></h1>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 ">
               <!--  <h1 class="card-header ">{{ __('Dashboard') }}</div> -->
                <div class="card-body text-center text-muted fw-normal fs-4">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in ') }} as <span class="title-clr fw-bold">{{session('user.role')}}</span>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 text-center mt-3 mb-3">
                    <a class="btn btn-default py-3 px-4 " role="button" href="/orders">check ordered list</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
