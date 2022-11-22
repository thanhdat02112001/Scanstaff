@extends('backend.layouts.main')
@section('content')
<div class="container p-4 pt-2">
    @include('partials.alerts')
    <div class="interviewer-wrapper">
        <div class="interviewer-title">
            <div>
                <h3>Manage Questions</h3>
            </div>
            <div>
                <a class="btn btn-success me-3" href="{{route('interviewer.question.create')}}">Create Questions</a>
            </div>
        </div>
        <div class="row question-body">
            <div class="col-md-2 left p-0">
                <div class="filter">
                    <input class="form-control mb-2" placeholder="Search..." />
                    <select class="form-select form-control">
                        <option value="any" selected>Any language</option>
                        @foreach ($langs as $lang)
                            <option value="{{ $lang->language_id }}">{{ $lang->name }}</option>
                        @endforeach
                    </select>
                </div>
                <ul class="list-question">
                    <li class="header">YOUR QUESTIONS</li>
                    <div class="list-wrapper">
                        @foreach ($questions as $question)
                            <li class="question">
                                <a href="{{route('interviewer.question.show', $question->id)}}">
                                    <h5>{{$question->title}}</h5>
                                    <span>{{$question->language->name}} by {{Auth::user()->name}}</span>
                                </a>
                            </li>
                        @endforeach
                    </div>
                </ul>
            </div>
            <div class="col-md-10 right">
                <div>
                    <h2>Welcome to your Question Library</h2>
                    <p>Questions you have written are listed on the left.</p>
                    <p>
                    You can search for questions you want to use, edit existing
                    questions, and create new ones.
                    </p>
                    <a class="btn btn-success" href="{{route('interviewer.question.create')}}">Create new Question</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
