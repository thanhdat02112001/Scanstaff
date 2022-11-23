@extends('backend.layouts.main')
@section('content')
    <div class="container p-4 pt-2">
        <div class="interviewer-wrapper page-interviewees">
            <div class="interviewee-title">
                <h3>Interviewee list</h3>
                <span>
                  All interviewees appear below. You can search by interviewee name,
                  or filter by join date of each interviewee
                </span>
            </div>
            <div class="row mt-3 ps-4">
                <div class="col-md-3">
                    <input class="form-control w-75" id="search-name" data-url="{{route('interviewer.interviewee.search')}}" placeholder="Search Name..."/>
                </div>
                <div class="col-md-9 d-flex justify-content-end align-items-center">
                    <span>Join Date</span>
                    <div class="me-3 ms-3">
                        <select id="filter-date">
                            <option value="all">All time</option>
                            <option value="today">Today</option>
                            <option value="7 days ago">1 week ago</option>
                            <option value="month">This month</option>
                            <option value="year">This year</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="interviewee-table">
                <table class="table table-bordered mt-1">
                    <thead>
                      <tr>
                        <th rowspan="2">Name</th>
                        <th colspan="2">
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
                    <tbody id="tbody">
                    @if (count($interviewees))
                    @foreach ($interviewees as $interviewee)
                        <tr>
                            <td rowspan="{{ count($interviewee->pads) }}" style="vertical-align: middle">{{ $interviewee->name }}</td>
                            @foreach ($interviewee->pads as $pad)
                                @if ($loop->first)
                                        <td>{{ $pad->title }}</td>
                                        <td>{{ $pad->name }}</td>
                                        <td>{{ $pad->created }}</td>
                                        <td>
                                            <a href="{{ route('pad.show', $pad->id) }}" target="_blank"><i
                                                class="fa fa-eye text-success fs-4 ms-4"
                                                aria-hidden="true"
                                              ></i></a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $pad->title }}</td>
                                        <td>{{ $pad->name }}</td>
                                        <td>{{ $pad->created }}</td>
                                        <td>
                                            <a href="{{ route('pad.show', $pad->id) }}" target="_blank">
                                                <i class="fa fa-eye text-success fs-4 ms-4"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">No matching records found</td>
                    </tr>
                @endif
                  </table>
            </div>
        </div>
    </div>
@endsection
