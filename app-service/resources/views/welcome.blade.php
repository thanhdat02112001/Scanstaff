@extends('frontend.layouts.main')
@section('content')
    @include('frontend.partials.actionBar')
    <div class="title">
        <h1>Interviewee Test</h1>
        <h3>Ready to go? Enter code here</h3>
        <form action="">
            <input type="text" name="inputCode" id="testcode" class="form-control w-25">
            <button class="btn btn-primary" type="button" id="go">
                <i class="fa fa-arrow-right me-1" aria-hidden="true"></i>GO
            </button>
        </form>
    </div>
    @push('js')
        <script>
            $("#go").click(function(e) {
                let code = $("#testcode").val();
                window.location.replace('https://zcheck.zinza.com.vn/pad/'+code);
            })
        </script>
    @endpush
@endsection
