@extends('backend.layouts.main')
@section('content')
<div class="container p-4 pt-2">
    @include('partials.alerts')
    <div class="interviewer-wrapper page-pads">
       <div class="body">
        <div class="interviewer-title">
            <div>
                <h3>Manage Pads</h3>
                <span>
                  Your pads appear below. You can search by interviewee name,
                  and filter by pad status or pad's language.
                </span>
            </div>
            <div>
                <form action="{{route('interviewer.pad.create')}}" method="POST" target="_blank">
                    @csrf
                    <button class="btn btn-success me-3" type="submit">Create Pad</button>
                </form>

            </div>
        </div>
        <div class="mt-3 ps-4">
            <div class="row">
                <div class="col-md-3">
                    <input class="form-control w-50" id="interviewer-search-pad" data-url="{{route('interviewer.pad.search')}}" placeholder="Search..."/>
                </div>
                <div class="col-md-9 d-flex justify-content-end align-items-center">
                    <div class="me-3">
                        <select class="form-select" id="filter-pad-status">
                          <option value="all" selected>Any pad status</option>
                          <option value="{{App\Models\Pad::STATUS_UNUSED}}">Unused pads</option>
                          <option value="{{App\Models\Pad::STATUS_INPROGRESS}}">In progress pads</option>
                          <option value="{{App\Models\Pad::STATUS_ENDED}}">Ended pads</option>
                        </select>
                      </div>
                      <div class="me-3">
                        <select class="form-select" id="filter-pad-lg">
                          <option value="all" selected>Any language</option>
                          @foreach ($langs as $lang)
                            <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                          @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="interviewee-table">
            <table class="table mt-1 table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col">Interviewees</th>
                    <th scope="col">Created</th>
                    <th scope="col">Language</th>
                    <th scope="col" colspan="2">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if (count($pads))
                    @foreach ($pads as $pad)
                    <tr>
                        <td>{{ $pad->title }}</td>
                        <td>{{ $pad->status }}</td>
                        <td>{{ $pad->interviewees }}</td>
                        <td>{{ $pad->created_at->diffForHumans() }}</td>
                        <td>{{ $langs->find($pad->language_id)->name }}</td>
                        @switch($pad->status)
                            @case(\App\Models\Pad::STATUS_UNUSED)
                                <td>
                                    <a href="{{ route('pad.show', $pad->id) }}" class="btn btn-success" target="_blank">Start</a>
                                </td>
                                <td>
                                    <a href="{{ route('pad.delete', $pad->id) }}" class="btn btn-danger Delete">Delete</a>
                                </td>
                                @break
                            @case(\App\Models\Pad::STATUS_INPROGRESS)
                                <td>
                                    <a href="{{ route('pad.show', $pad->id) }}" class="btn btn-primary" target="_blank">Edit</a>
                                </td>
                                <td>
                                    <a href="{{ route('pad.end', $pad->id) }}" class="btn btn-warning End">End</a>
                                </td>
                                @break
                            @case(\App\Models\Pad::STATUS_ENDED)
                                <td>
                                    <a href="{{ route('pad.show', $pad->id) }}" class="btn btn-primary" target="_blank">View</a>
                                </td>
                                <td>
                                    <a href="{{ route('pad.delete', $pad->id) }}" class="btn btn-danger Delete">Delete</a>
                                </td>
                        @endswitch
                    </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="6">No matching records found</td>
                        </tr>
                    @endif
                </tbody>
              </table>
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
            <a href="" class="goto-pad btn btn-primary" target="_blank"></a>
        </td>
        <td>
            <a href="" class="btn red-btn btn-danger"></a>
        </td>
    </tr>
</template>

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
@endsection
