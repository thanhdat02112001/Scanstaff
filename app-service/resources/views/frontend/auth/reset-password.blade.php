@extends('frontend.layouts.main')
@section('content')
    @push('stylesheet')
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    @endpush
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" action="" method="POST">
                    @csrf
                    <span class="login100-form-logo">
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    </span>
                    <span class="login100-form-title p-b-34 p-t-27 mt-5 mb-5">Forgot Password</span>
                    <div class="wrap-input100">
                        <input class="input100" type="text" name="email" placeholder="Email">
                        <span class="focus-input100" data-placeholder=""></span>
                    </div>
                    @error('email')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                    <div class="container-login100-form-btn mb-4">
                        <button class="login100-form-btn mt-3" type="submit">
                            Send Password Reset Link
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
