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
                                    <h5 class="text-light">Free Register !</h5>
                                    <p class="text-light">
                                        Get your Zcheck's acount now.
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
                            <form action="" class="form-horizontal">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        User Name
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
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
                                <div class="mb-3">
                                    <label for="password_confirm" class="form-label">
                                        Password Confirmation
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirm" class="form-control">
                                </div>
                                <div class="mt-3 d-grid">
                                    <button
                                      class="btn btn-primary btn-block"
                                      type="submit"
                                    >
                                      Register
                                    </button>
                                </div>
                                <div class="mt-4 text-center">
                                    By registering you agree to the Zcheck
                                    <a href="#" class="ms-1">
                                      Term of Use
                                    </a>
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-2 text-center">
                    <p>
                        Already have an account ?
                        <a href="/login" className="fw-medium text-primary">
                          Login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>x`
@endsection
