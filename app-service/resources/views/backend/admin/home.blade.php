@extends('backend.layouts.main')
@section('content')
    <div class="container p-50 admin home">
        @include('partials.alerts')
        <div class="row">
            @foreach ($statics as $key => $value)
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body" style="color: #2200bb; background-color: rgb(250, 239, 251)">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                              <p class="fw-medium mb-2 fs-4">
                                {{$key}}
                              </p>
                              <h4 class="mb-0">{{$value}}</h4>
                            </div>
                            <div class="mini-stat-icon ">
                              <span class="avatar-title">
                                @switch($key)
                                    @case('Pads')
                                        <i class="fa fa-file-code-o fs-2"></i>
                                        @break
                                    @case('Interviewers')
                                    <i class="fa fa-user-o fs-2"></i>
                                        @break
                                    @case('Interviewees')
                                        <i class="fa fa-graduation-cap fs-2" aria-hidden="true"></i>
                                        @break
                                    @default
                                @endswitch
                              </span>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row p-2">
            <div class="bar-chart mt-5 p-3 card">
                <div id="container" class="w-100" ></div>
            </div>
        </div>
    </div>
@endsection
