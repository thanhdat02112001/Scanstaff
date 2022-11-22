@extends('backend.layouts.main')
@section('content')
    <div class="container p-4 pt-2 main-page-content">
        <div class="interviewer-wrapper page-edit-question">
            <div class="interviewer-title">
                <div>
                    <h3>Create Questions</h3>
                </div>
            </div>
            <div class="row p-5" >
                <form method="POST" action="{{ route('interviewer.question.update', $question->id) }}" >
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{$question->title}}">
                    </div>
                    <div class="form-group">
                        <label for="select-lg">Language</label>
                        <select class="form-control" id="select-lg-update" name="language">
                            @foreach ($languages as $lg)
                                <option value="{{ $lg->id }}" data-mode="{{ $lg->mode }}" {{$question->language_id == $lg->id ? 'selected' : ''}}>{{ $lg->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3">{{$question->description}}</textarea>
                    </div>
                    <div class="form-group ">
                        <label for="content">Content</label>
                        <textarea id="codemirror-edit-ques" data-lg="{{ $question->language->mode }}">{{ $question->content }}</textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-success mt-3" type="submit">Save</button>
                        <button class="btn btn-danger mt-3">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
