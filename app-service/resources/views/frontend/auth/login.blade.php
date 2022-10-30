@extends('frontend.layouts.main')
@section('content')
<div class="account-page my-4 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="bg-primary bg-soft">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-4">
                                    <h5 class="text-light">Welcome Back !</h5>
                                    <p class="text-light">
                                    Sign in to continue to Zcheck.
                                    </p>
                                </div>
                            </div>

                            <div class="col-5 align-self-end">
                                <img src="{{asset('/images/profile-img.png')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="avatar-md profile-user-wid d-flex justify-content-center">
                            <a href="">
                              <span class="avatar-title rounded-circle">
                                <img
                                  src={{asset('/images/logo.png')}}
                                  alt=""
                                  class="rounded-circle"
                                  height="150"
                                />
                              </span>
                            </a>
                        </div>
                        <div class="p-2">
                            <form action="{{route('login')}}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        Email
                                    </label>
                                    <input type="text" name="email" id="email" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        Password
                                    </label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <div class="form-check">
                                    <input
                                      type="checkbox"
                                      class="form-check-input"
                                      id="customControlInline"
                                    />
                                    <label
                                      class="form-check-label"
                                      htmlFor="customControlInline"
                                    >
                                      Remember me
                                    </label>
                                </div>
                                <div class="mt-3 d-grid">
                                    <button
                                      class="btn btn-primary btn-block"
                                      type="submit"
                                    >
                                      Log In
                                    </button>
                                </div>
                                <div class="mt-4 text-center">
                                    <a href="/password/reset" class="text-muted">
                                      <i class="mdi mdi-lock me-1"> Forgot your password?</i>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <p>
                      Don&apos;t have an account ?
                      <a href="/register" class="fw-medium text-primary">
                        Signup Now
                      </a>
                    </p>
                </div>
            </div>
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
