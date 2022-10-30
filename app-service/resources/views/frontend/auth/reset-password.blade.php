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
                            <form action="" class="form-horizontal">
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        Email
                                    </label>
                                    <input type="text" name="email" id="email" class="form-control">
                                </div>
                                <div class="mt-3 d-grid">
                                    <button
                                      class="btn btn-primary btn-block"
                                      type="submit"
                                    >
                                      Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <p>
                      Go back to
                      <a href="/login" class="fw-medium text-primary">
                        Login
                      </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
