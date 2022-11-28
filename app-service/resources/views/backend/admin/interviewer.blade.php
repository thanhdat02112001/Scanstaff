@extends('backend.layouts.main')
@section('content')
    <div class="container p-4 pt-2">
        <div class="interviewer-wrapper unapproved-list">
            <h3>List of unapproved interviewer</h3>
            @if (count($unapproved) == 0)
                <p class="is-empty ps-2">There are no unapproved users</p>
                <div class="table-responsive interviewer-table d-none">
                    <table class="table mt-1 table-bordered border-collapse unapproved">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Approve</th>
                                <th>Decline</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            @else
                <div class="interviewer-table unapproved">
                    <table class="table mt-1 table-bordered border-collapse">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Approve</th>
                                <th>Decline</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unapproved as $user)
                                <tr>
                                    <th scope="col">{{ $loop->index + 1 }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="action">
                                        <a href="{{ route('admin.approve', $user->id) }}">
                                            <i class="fa fa-check-circle-o text-success fs-4 ps-3"></i>
                                        </a>
                                    </td>
                                    <td class="action">
                                        <a href="{{ route('admin.decline', $user->id) }}">
                                            <i class="fa fa-ban text-danger fs-4 ps-3"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="interviewer-wrapper">
            <h3>Interviewer list</h3>

            <div class="interviewer-table">
            <table class="table mt-1 table-bordered border-collapse">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Questions</th>
                    <th scope="col">Pads</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ban</th>
                    <th scope="col">View pads</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($interviewers as $interviewer)
                        <tr>
                            <th>{{ $interviewer->id }}</th>
                            <td>{{ $interviewer->name }}</td>
                            <td>{{ $interviewer->email }}</td>
                            <td>{{ $interviewer->questions->count() }}</td>
                            <td>{{ $interviewer->pads->count() }}</td>
                            <td>{{ $interviewer->banned ? 'Banned' : 'Active' }}</td>
                            <td>
                                @unless (Auth::user()->id == $interviewer->id)
                                    @if ($interviewer->banned)
                                        <a href="{{ route('admin.unban', $interviewer->id) }}" class="unban">Unban</a>
                                    @else
                                        <a href="{{ route('admin.ban', $interviewer->id) }}" class="ban">Ban</a>
                                    @endif
                                @endunless
                            </td>
                            <td>
                                @if ($interviewer->pads->count() > 0)
                                    <a href="{{ route('admin.view.user.pads', $interviewer->id) }}">
                                        <i class="fa fa-eye text-success fs-4"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <template id="new-user-row">
        <tr>
            <th scope="col"></th>
            <td></td>
            <td></td>
            <td class="action acpt">
                <a href=""><i class="fa fa-check-circle-o text-success fs-4 ps-3" aria-hidden="true"></i></a>
            </td>
            <td class="action decl">
                <a href=""><i class="fa fa-ban text-danger fs-4 ps-3" aria-hidden="true"></i></a>
            </td>
        </tr>
    </template>
@endsection
