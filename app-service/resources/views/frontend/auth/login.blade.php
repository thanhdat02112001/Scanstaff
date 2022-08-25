@extends('frontend.layouts.main')
@section('content')
@push('stylesheet')
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
@endpush
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" id="login-form" method="POST" action="{{route('login')}}">
                    @csrf
                    <span class="login100-form-logo">
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    </span>
                    <span class="login100-form-title p-b-34 p-t-27">Log in</span>
                    <div class="wrap-input100" id="email-input">
                        <input class="input100" type="text" name="email" placeholder="Email">
                        <span class="focus-input100" data-placeholder=""></span>
                    </div>
                    <span id="error-mail" class="text-danger"></span>
                    <div class="wrap-input100 validate-input" data-validate="Enter password" id="pass-input">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100" data-placeholder=""></span>
                    </div>
                    <span id="error-pass" class="text-danger"></span>
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
                        <a class="txt1" href="{{route('forgot-password')}}">
                        Forgot Password?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@push('js')
    <script>
        $("#login-form").submit(function (e){
            e.preventDefault()
            let url = $(this).attr('action')
            let data = {
                email: $('input[name="email"]').val(),
                password: $('input[name="password').val()
            }
            //reset
            $("#error-mail").text('');
            $("#error-pass").text('');

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success:function(response) {
                    alertify.set('notifier','position', 'top-center');
                    if (response.status == 200) {
                        alertify.success(response.message)
                        setTimeout(() => {
                            window.location.replace('/home');
                        }, 500);
                    } else {
                        alertify.error(response.message)
                    }
                },
                error:function(response){
                    let errorMail = response.responseJSON.errors.email;
                    let errorPass = response.responseJSON.errors.password;
                    $("#error-mail").text(errorMail);
                    $("#error-pass").text(errorPass);
                }
            })
        })
    </script>
@endpush
@endsection
