@extends('backend.layouts.main')
@section('content')
    <div class="container p-4 pt-2">
        <div class="interviewer-wrapper">
            <div class="interviewer-title">
                <div>
                    <h3>Create Questions</h3>
                </div>
            </div>
            <div class="row">
                <form method="POST" action="{{ route('interviewer.question.store') }}" id="new-ques">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="Untitled Question">
                    </div>
                    <div class="form-group">
                        <label for="select-lg">Language</label>
                        <select class="form-control" id="select-lg" name="language">
                            @foreach ($languages as $lg)
                                <option value="{{ $lg->id }}" data-mode="{{ $lg->mode }}">{{ $lg->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" class="form-control" id="content" rows="20"></textarea>
                    </div>
                    <input type="submit" value="Save">
                </form>
            </div>
        </div>
    </div>

@endsection
