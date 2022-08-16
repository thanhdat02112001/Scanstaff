@extends('frontend.layouts.main')
@section('content')
@push('stylesheet')
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
@endpush
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form">
                    <span class="login100-form-logo">
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    </span>
                    <span class="login100-form-title p-b-34 p-t-27">Log in</span>
                    <div class="wrap-input100">
                        <input class="input100" type="text" name="email" placeholder="Email">
                        <span class="focus-input100" data-placeholder=""></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="pass" placeholder="Password">
                        <span class="focus-input100" data-placeholder=""></span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <input id="ckb1" type="checkbox" name="remember-me" class="me-3">
                        <label for="ckb1" class="text-light">Remember me</label>
                    </div>
                    <div class="container-login100-form-btn mb-4">
                        <button class="login100-form-btn">
                        Login
                        </button>
                    </div>
                    <div class="text-center p-t-90">
                        <a class="txt1" href="#">
                        Forgot Password?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
