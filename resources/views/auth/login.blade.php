@extends('layouts.master')

@section('content')
<div class="container-fluid login-pg">

        <div class="container pt-5 mt-5 pb-5 mb-4">

        <div class="card" >


        <div class="row justify-content-center ">
        <div class="col-md-6 p-0">
            <img src="assets/images/campus.jpg" style="width:100%;min-height:520px;object-fit:cover;" width="400" height="400" class="img-fluid"/>
        </div>
        <div class="col-md-6 p-0">

        <div class="form-container">

        <div class="inner-cont">
        <h2 class="fs-4 fw-bold title-clr text-center pb-5">{{ __('Login') }}</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                            <div class="form-group mb-4">
                            <label for="email" class="fw-bold pb-1">{{ __('Login ID') }}</label>
                               <input id="login_id" type="text" class="form-control @error('login_id') is-invalid @enderror" name="login_id" value="{{ old('login_id') }}" required autocomplete="login_id" autofocus>
                                @error('email')
                                    <p class="text-danger " role="alert">
                                        <small>{{ $message }}</small>
</p>
                                @enderror

                        </div>



                        <div class="form-group mb-4">
                            <label    for="email" class="fw-bold pb-1">{{ __('Password') }}</label>


                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <p class="invalid-feedback" role="alert">
                                        <small>{{ $message }}</small>
</p>
                                @enderror

                        </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                    name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>



                        <div class="row my-4 pt-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn py-3 w-100 btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    </div>
        </div>
        </div>
        </div>
        </div>
        </div>
</div>
@endsection
