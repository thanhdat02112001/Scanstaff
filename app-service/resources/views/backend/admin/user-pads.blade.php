@extends('backend.layouts.main')
@section('content')
    <div class="container p-4 pt-2">
        <div class="interviewer-wrapper">
            <h3>List pad of {{$user->name}}</h3>
            <p class="ps-2">All pads created by {{$user->name}} appear below</p>
        </div>
        <div class="interviewer-wrapper">
            <h3>Pads</h3>
            <div class="interviewer-table">
            <table class="table mt-1 table-bordered border-collapse">
                <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col">Interviewees</th>
                    <th scope="col">Created</th>
                    <th scope="col">Language</th>
                    <th scope="col">View pads</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($pads as $pad)
                    <tr>
                        <td>{{ $pad->title }}</td>
                        <td>{{ $pad->status }}</td>
                        <td>{{ $pad->interviewees }}</td>
                        <td>{{ $pad->created_at->diffForHumans() }}</td>
                        <td>{{ $langs->find($pad->language_id)->name }}</td>
                        <td>
                            <a href="{{ route('pad.show', $pad->id) }}" target="_blank"><i class="fa fa-eye text-success fs-4"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
@endsection
