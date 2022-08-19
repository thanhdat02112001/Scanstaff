@extends('frontend.layouts.main')
@section('content')
@push('stylesheet')
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
@endpush
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form class="login100-form validate-form" action="{{route('register')}}" method="POST">
                @csrf
                <span class="login100-form-logo">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                </span>
                <span class="login100-form-title p-b-34 p-t-27">Register</span>
                <div class="wrap-input100">
                    <input class="input100" type="text" name="name" placeholder="Name">
                    <span class="focus-input100" data-placeholder=""></span>
                </div>
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="wrap-input100">
                    <input class="input100" type="text" name="email" placeholder="Email">
                    <span class="focus-input100" data-placeholder=""></span>
                </div>
                @error('email')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="wrap-input100">
                    <input class="input100" type="password" name="password" placeholder="Password">
                    <span class="focus-input100" data-placeholder=""></span>
                </div>
                @error('password')
                    <span class="text-danger">{{$message}}</span>
                @enderror
                <div class="wrap-input100">
                    <input class="input100" type="password" name="password_confirmation" placeholder="Confirm Password">
                    <span class="focus-input100" data-placeholder=""></span>
                </div>
                <div class="container-login100-form-btn mb-4">
                    <button class="login100-form-btn">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
