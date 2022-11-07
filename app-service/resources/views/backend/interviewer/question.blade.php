@extends('backend.layouts.main')
@section('content')
<div class="container p-4 pt-2">
    <div class="interviewer-wrapper">
        <div class="interviewer-title">
            <div>
                <h3>Manage Questions</h3>
            </div>
            <div>
                <button class="btn btn-success me-3">Create Questions</button>
            </div>
        </div>
        <div class="row question-body">
            <div class="col-md-2 left p-0">
                <div class="filter">
                    <input class="form-control mb-2" placeholder="Search..." />
                    <select class="form-select form-control">
                        <option value="any" selected>Any language</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="list-question">
                    <h6>YOUR QUESTIONS</h6>
                    <div class="question">
                        <h5>Question 1</h5>
                        <span>PHP by admin</span>
                    </div>
                </div>
            </div>
            <div class="col-md-10 right">
                <div>
                    <h2>Welcome to your Question Library</h2>
                    <p>Questions you have written are listed on the left.</p>
                    <p>
                      You can search for questions you want to use, edit existing
                      questions, and create new ones.
                    </p>
                    <button class="btn btn-success">Create new Question</button>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
