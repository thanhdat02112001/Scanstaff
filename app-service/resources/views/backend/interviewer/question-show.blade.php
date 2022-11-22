@extends('backend.layouts.main')
@section('content')
<div class="container p-4 pt-2">
    @include('partials.alerts')
    <div class="interviewer-wrapper page-questions">
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
            <div class="col-md-10 question-right">
                <div class="question-detail">
                    <div class="header">
                      <div class="info">
                        <h5>{{$ques->title}}</h5>
                        <span>{{$ques->description}}</span>
                        <p>{{$ques->language->name}} created {{$ques->created_at->diffForHumans()}}</p>
                      </div>
                      <div>
                        <a href="{{route('interviewer.question')}}" class="btn btn-primary">
                          <i
                            class="fa fa-arrow-left me-2"
                            aria-hidden="true"
                          ></i>
                          Back
                        </a>
                      </div>
                    </div>
                    <div class="question-content">
                        <textarea id="cmr" data-lg="{{ $ques->language->mode }}">{{ $ques->content }}</textarea>
                    </div>
                    <div class="action d-flex justify-content-center">
                      <a href="{{route('interviewer.question.edit', $ques->id)}}">
                        <button class="btn btn-outline-primary me-3">
                          Edit
                        </button>
                      </a>
                      <form target="_blank" action="{{ route('interviewer.pad.create') }}" method="post">
                        @csrf
                        <input type="hidden" name="ques_id" value="{{ $ques->id }}">
                        <input type="submit" value="Create pad with this question" class="btn btn-outline-success">
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
