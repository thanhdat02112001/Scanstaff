@extends('backend.layouts.main')
@section('content')
    <div class="container p-4 pt-2">
        <div class="interviewer-wrapper">
            <div class="interviewee-title">
                <h3>Interviewee list</h3>
                <span>
                  All interviewees appear below. You can search by interviewee name,
                  or filter by join date of each interviewee
                </span>
            </div>
            <div class="row mt-3 ps-4">
                <div class="col-md-3">
                    <input class="form-control w-75" placeholder="Search Name..."/>
                </div>
                <div class="col-md-9 d-flex justify-content-end align-items-center">
                    <span>Join Date</span>
                    <div class="me-3 ms-3">
                      <select class="form-select">
                        <option value="0">Today</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                      </select>
                    </div>
                </div>
            </div>
            <div class="interviewee-table">
                <table class="table table-bordered mt-1">
                    <thead>
                      <tr>
                        <th rowspan="2">Name</th>
                        <th class="colspan2" colSpan="2">
                          Pads
                        </th>
                        <th rowspan="2">Joined at</th>
                        <th rowspan="2">View pad</th>
                      </tr>
                      <tr>
                        <th class="width-50">Title</th>
                        <th class="width-50">Language</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td rowspan="2">Dat09</td>
                        <td rowspan="2">untitle-pad</td>
                        <td rowspan="2">php</td>
                      </tr>
                      <tr>
                        <td class="width-50">3 day agos</td>
                        <td class="width-50">
                          <i
                            class="fa fa-eye text-success fs-4 ms-4"
                            aria-hidden="true"
                          ></i>
                        </td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
@endsection
