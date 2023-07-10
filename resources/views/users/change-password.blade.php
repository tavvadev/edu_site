@extends('layouts.master')
@section('content')
<div class="main-bg">
<h1 class="display-5 pt-5 text-center fw-bold title-clr lh-base text-capitalize mb-2">
        <small>Change password</small></h1>
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


<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-8 ">
            <div class="card p-4">

                <div class="card-heading display-4 text fw-bold py-4">

                <h2 class="fs-5 fw-bold mb-0 lh-base text-body">Chang your Password here? </h2>
            <h3 class="fs-6 fw-normal mb-4 text-muted"> changing password freequently will protect your account from scammers. </h3>
            </div>

                <div class="card-body">

                        <div class="row">
<div class="col-md-6">



                    <form method="POST" action="/updateChangePassword">
                        {{ csrf_field() }}
                        <div class="col-md-12">
                        <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                            <!-- <label for="new-password" class=" control-label">Current Password</label> -->
                                <input id="current-password" type="password"
                                 class="form-control" name="current-password" placeholder="Current Password" required>
                                @if ($errors->has('current-password'))
                                    <span class="help-block">
                                        <strong style="color:red">{{ $errors->first('current-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                        <div class="mt-4 form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                            <!-- <label for="new-password" class=" control-label">New Password</label> -->
                                <input id="new-password" type="password" placeholder="New Password" class="form-control" name="new-password" required>
                                @if ($errors->has('new-password'))
                                    <span class="help-block">
                                        <strong style="color:red">{{ $errors->first('new-password') }}</strong>
                                    </span>
                                @endif
                                </div>
                        </div>

                        <div class="col-md-12">
                        <div class="form-group mt-4">
                           <!--  <label for="new-password-confirm" class=" control-label">Confirm New Password</label> -->
                                <input id="new-password-confirm" type="password" placeholder="Confirm New Password" class="form-control" name="new-password_confirmation" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                        <div class="form-group mt-4">
                                <button type="submit" class="btn btn-default p-3 w-100">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                    <div class="col-md-6 col-sm-8 ps-0 ps-md-4">
            <div class="row justify-content-center">
            <h4 class="fs-5 fw-bold mb-4 title-clr pt-5 pt-md-0">Password must contain:</h4>

            <p class="mb-2 fs-6 fw-normal text-muted ps-3"><i class="bi bi-check-lg text-success me-2"></i>At least 6 characters</p>
            <p class="mb-2 fs-6 fw-normal text-muted ps-3"><i class="bi bi-check-lg text-success me-2"></i>At least 1 uppercase letter</p>
            <p class="mb-2 fs-6 fw-normal text-muted ps-3"><i class="bi bi-check-lg text-success me-2"></i>At least 1 lowercase letter</p>
            <p class="mb-2 fs-6 fw-normal text-muted ps-3"><i class="bi bi-check-lg text-success me-2"></i>At least 1 number</p>
            <p class="mb-2 fs-6 fw-normal text-muted ps-3"><i class="bi bi-check-lg text-success me-2"></i>At least 1 special character</p>


            </div>
        </div>
                </div>


                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection