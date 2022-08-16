@extends('frontend.layouts.main')
@section('content')
@push('stylesheet')
    <style>
        .content {
            text-align: center;
            margin-top: 20%;
        }
        .title {
            font-size: 84px;
            color:  #66b4ec;
        }
        .m-b-md {
            margin-bottom: 30px;
        }
        .subtitle {
            color:  #66b4ec;
            font-size: 24px
        }
    </style>
@endpush
    <div class="container">
        <div class="content">
            <div class="title m-b-md">
                Scan Interviewer Test
            </div>
            <div class="subtitle">
                <p>Ready to go? Enter code here</p>
            </div>
            <div class="m-b-md input-code">
                <div class="d-flex justify-content-center">
                    <input type="text" name="code" id="code" class="form-control w-25 me-2">
                    <button type="submit" class="btn btn-primary fw-bold" id="btn-submit">Go <i class="fa fa-arrow-right"></i></button>
                </div>
                <div class="error-code">
                </div>
            </div>
        </div>
    </div>
@endsection
