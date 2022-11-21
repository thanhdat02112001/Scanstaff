@extends('backend.layouts.main')
@section('content')
<div class="container p-4 pt-2">
    <div class="interviewer-wrapper">
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
                    <input class="form-control w-50" placeholder="Search..."/>
                </div>
                <div class="col-md-9 d-flex justify-content-end align-items-center">
                    <div class="me-3">
                        <select class="form-select">
                          <option value="all" selected>Any pad status</option>
                          <option value="{{App\Models\Pad::STATUS_UNUSED}}">Unused pads</option>
                          <option value="{{App\Models\Pad::STATUS_INPROGRESS}}">In progress pads</option>
                          <option value="{{App\Models\Pad::STATUS_ENDED}}">Ended pads</option>
                        </select>
                      </div>
                      <div class="me-3">
                        <select class="form-select">
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
                    <th scope="col">Action</th>
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
                                <td class="d-flex justify-content-around">
                                    <a href="{{ route('pad.show', $pad->id) }}" class="btn btn-primary" target="_blank">Start</a>
                                    <a href="{{ route('pad.delete', $pad->id) }}" class="btn btn-danger Delete">Delete</a>
                                </td>
                                @break
                            @case(\App\Models\Pad::STATUS_INPROGRESS)
                                <td class="d-flex justify-content-around">
                                    <a href="{{ route('pad.show', $pad->id) }}" class="btn btn-primary" target="_blank">Edit</a>
                                    <a href="{{ route('pad.end', $pad->id) }}" class="btn btn-danger End">End</a>
                                </td>
                                @break
                            @case(\App\Models\Pad::STATUS_ENDED)
                                <td>
                                    <a href="{{ route('pad.show', $pad->id) }}" class="btnbtn-primary" target="_blank">View</a>
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
@endsection
