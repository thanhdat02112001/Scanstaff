import React from "react";
import { Link } from "react-router-dom";
import UserWrapper from "./UserWrapper";

const ListInterviewer = () => {
  return (
    <UserWrapper>
      <h3>Interviewer list</h3>
      <div className="interviewer-table">
        <table className="table mt-1 table-bordered">
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
              <td className="ps-4">0</td>
              <td className="ps-3">2</td>
              <td>Active</td>
              <td>Ban</td>
              <td>
                <Link to="/interviewer/pad">
                  <i
                    className="fa fa-eye text-success fs-4 ms-4"
                    aria-hidden="true"
                  ></i>
                </Link>
              </td>
            </tr>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>thanhdat@gmail.com</td>
              <td className="ps-4">0</td>
              <td className="ps-3">2</td>
              <td>Active</td>
              <td>Ban</td>
              <td>
                <Link to="/interviewer/pad">
                  <i
                    className="fa fa-eye text-success fs-4 ms-4"
                    aria-hidden="true"
                  ></i>
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </UserWrapper>
  );
};

export default ListInterviewer;
