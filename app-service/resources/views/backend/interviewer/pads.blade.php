@extends('backend.layouts.main')

@section('classname', 'page-pads')

@section('content')
    <div class="top-content">
        <div class="col-lg-10">
            <h2 class="page-heading">Manage Pads</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="">User</a>
                </li>
                <li class="active">
                    <strong>Pads</strong>
                </li>
            </ol>
        </div>
    </div>t
        <div class="page-pads-container hasBorder">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show">
                    {{ session('warning') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="heading">
                <h2>Pads</h2>
                <form target="_blank" action="{{route('pad.create')}}" method="post">
                    @csrf
                    <button class="new-pad top">Create pad</button>
                </form>
            </div>
            <p class="information">Your pads appear below. You can search by interviewee name, and filter by pad status or pad's language.</p>
            <div class="pad-filters">
                <div class="search">
                    <input type="text" id="search" placeholder="Search title and people">
                </div>
                <div class="filter">
                    <select id="filter-status">
                        <option value="all">Any pad status</option>
                        <option>Unused pads</option>
                        <option >In progress pads</option>
                        <option >Ended pads</option>
                    </select>
                    <select id="filter-lg">
                        <option value="all">Any language</option>
                        @foreach ($langs as $lang)
                            <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="pads-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Interviewees</th>
                            <th>Created</th>
                            <th>Language</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @if (count($pads))
                            @foreach ($pads as $pad)
                            <tr>
                                <td>{{ $pad->title }}</td>
                                <td>{{ $pad->status }}</td>
                                <td>{{ $pad->interviewees }}</td>
                                <td>{{ $pad->created_at->diffForHumans() }}</td>
                                <td>{{ $langs->find($pad->language_id)->name }}</td>
                                @switch($pad->status)
                                    @case(\App\Pad::STATUS_UNUSED)
                                        <td>
                                            <a href="{{ route('pad.show', $pad->id) }}" class="goto-pad btn" target="_blank">Start</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('interviewer.pad.delete', $pad->id) }}" class="btn red-btn Delete">Delete</a>
                                        </td>
                                        @break
                                    @case(\App\Pad::STATUS_INPROGRESS)
                                        <td>
                                            <a href="{{ route('pad.show', $pad->id) }}" class="goto-pad btn" target="_blank">Edit</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('interviewer.pad.end', $pad->id) }}" class="btn red-btn End">End</a>
                                        </td>
                                        @break
                                    @case(\App\Pad::STATUS_ENDED)
                                        <td>
                                            <a href="{{ route('pad.show', $pad->id) }}" class="goto-pad btn" target="_blank">View</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('interviewer.pad.delete', $pad->id) }}" class="btn red-btn Delete">Delete</a>
                                        </td>
                                @endswitch
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">No matching records found</td>
                            </tr>
                        @endif --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal end pad -->
    <div class="modal fade" id="modalEnd" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">End Pad?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Ending the pad will prevent interviewees from accessing this pad. Only
                        you and your organization can see it.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form action="" method="POST">
                        @method('PATCH')
                        @csrf
                        <button class="btn btn-danger">End</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal delete pad -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Pad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this pad?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form action="" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <template id="pad-row">
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <a href="" class="goto-pad btn" target="_blank"></a>
            </td>
            <td>
                <a href="" class="btn red-btn"></a>
            </td>
        </tr>
    </template>
@endsection
