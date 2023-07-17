@extends('layouts.master')

@section('content')
<div class="container-fluid  main-bg login-pg">

        <div class="container pt-5 pb-5 mb-4">




        <div class="row justify-content-center ">

        <div class="col-md-5 ">

        <div class="form-container">
        <div class="inner-cont">

        <h1 class="fs-6 fw-normal text-muted text-center lh-base">Welcome to our Edutech </h1>
        <h2 class="fs-4 fw-bold title-clr text-center pb-5">{{ __('Login Screen') }}</h2>
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


                                <p class="text-muted text-end pt-1"><a href="/forgotpassword" style="cursor:pointer;">Forgot Password?</a></p>
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
                                <button type="submit" class="btn py-3 w-100 btn-default">
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
@endsection
