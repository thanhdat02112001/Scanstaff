import React from "react";
import UserWrapper from "./UserWrapper";

const ManageInterviewer = () => {
  return (
    <UserWrapper>
      <h3>List of unapproved interviewer</h3>
      <div className="interviewer-table">
        <table className="table mt-1 table-bordered">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Approve</th>
              <th scope="col">Decline</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>thanhdat@gmail.com</td>
              <td>
                <i
                  className="fa fa-check-circle-o text-success fs-4 ps-3"
                  aria-hidden="true"
                ></i>
              </td>
              <td>
                <i
                  className="fa fa-ban text-danger fs-4 ps-3"
                  aria-hidden="true"
                ></i>
              </td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>Jacob</td>
              <td>Thornton</td>
              <td>
                <i
                  className="fa fa-check-circle-o text-success fs-4 ps-3"
                  aria-hidden="true"
                ></i>
              </td>
              <td>
                <i
                  className="fa fa-ban text-danger fs-4 ps-3"
                  aria-hidden="true"
                ></i>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </UserWrapper>
  );
};

export default ManageInterviewer;
