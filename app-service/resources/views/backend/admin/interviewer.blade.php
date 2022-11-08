@extends('backend.layouts.main')
@section('content')
    <div class="container p-4 pt-2">
        <div class="interviewer-wrapper">
            <h3>List of unapproved interviewer</h3>
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
                    <tr>
                      <th>1</th>
                      <td>Mark</td>
                      <td>thanhdat@gmail.com</td>
                      <td>
                        <i
                          class="fa fa-check-circle-o text-success fs-4 ps-3"
                          aria-hidden="true"
                        ></i>
                      </td>
                      <td>
                        <i
                          class="fa fa-ban text-danger fs-4 ps-3"
                          aria-hidden="true"
                        ></i>
                      </td>
                    </tr>
                    <tr>
                      <th>2</th>
                      <td>Jacob</td>
                      <td>Thornton</td>
                      <td>
                        <i
                          class="fa fa-check-circle-o text-success fs-4 ps-3"
                          aria-hidden="true"
                        ></i>
                      </td>
                      <td>
                        <i
                          class="fa fa-ban text-danger fs-4 ps-3"
                          aria-hidden="true"
                        ></i>
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
        <div class="interviewer-wrapper">
            <h3>Interviewer list</h3>
            <div class="filter mt-3 ms-4 col-md-2">
                <input type="text" class="form-control" placeholder="Search Interviewer...">
            </div>
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
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>thanhdat@gmail.com</td>
                    <td class="ps-4">0</td>
                    <td class="ps-3">2</td>
                    <td>Active</td>
                    <td>Ban</td>
                    <td>
                    <a href="/interviewer/pad">
                        <i
                        class="fa fa-eye text-success fs-4 ms-4"
                        aria-hidden="true"
                        ></i>
                    </a>
                    </td>
                </tr>
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>thanhdat@gmail.com</td>
                    <td class="ps-4">0</td>
                    <td class="ps-3">2</td>
                    <td>Active</td>
                    <td>Ban</td>
                    <td>
                    <a href="/interviewer/pad">
                        <i
                        class="fa fa-eye text-success fs-4 ms-4"
                        aria-hidden="true"
                        ></i>
                    </a>
                    </td>
                </tr>
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
                <a href=""><i class="fa fa-check-circle-o yes" aria-hidden="true"></i></a>
            </td>
            <td class="action decl">
                <a href=""><i class="fa fa-ban no" aria-hidden="true"></i></a>
            </td>
        </tr>
    </template>
@endsection
