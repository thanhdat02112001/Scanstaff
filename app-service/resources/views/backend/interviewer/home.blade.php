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
                          <option value="any" selected>Any pad status</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                      <div class="me-3">
                        <select class="form-select">
                          <option value="any" selected>Any language</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
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
                  <tr>
                    <td>Untitle</td>
                    <td>Inprogress</td>
                    <td>dat, abc</td>
                    <td>1 hour ago</td>
                    <td>Javascript</td>
                    <td>
                      <button class="btn btn-primary me-5">Start</button>
                      <button class="btn btn-danger">End</button>
                    </td>
                  </tr>
                  <tr>
                    <td>Untitle</td>
                    <td>Inprogress</td>
                    <td>dat, abc</td>
                    <td>1 hour ago</td>
                    <td>Javascript</td>
                    <td>
                      <button class="btn btn-primary me-5">Start</button>
                      <button class="btn btn-danger">End</button>
                    </td>
                  </tr>
                </tbody>
              </table>
        </div>
       </div>
    </div>
</div>
@endsection
