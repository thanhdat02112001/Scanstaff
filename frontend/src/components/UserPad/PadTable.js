import React, { Fragment } from "react";

const PadTable = () => {
  return (
    <Fragment>
      <table className="table mt-1 table-bordered">
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
              <button className="btn btn-primary me-5">Start</button>
              <button className="btn btn-danger">End</button>
            </td>
          </tr>
          <tr>
            <td>Untitle</td>
            <td>Inprogress</td>
            <td>dat, abc</td>
            <td>1 hour ago</td>
            <td>Javascript</td>
            <td>
              <button className="btn btn-primary me-5">Start</button>
              <button className="btn btn-danger">End</button>
            </td>
          </tr>
        </tbody>
      </table>
    </Fragment>
  );
};

export default PadTable;
