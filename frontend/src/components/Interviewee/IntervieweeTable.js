import React, { Fragment } from 'react';

const IntervieweeTable = () => {
    return (
        <Fragment>
            <table className="table table-bordered mt-1">
              <thead>
                <tr>
                  <th rowSpan="2">Name</th>
                  <th className="colspan2" colSpan="2">
                    Pads
                  </th>
                  <th rowSpan="2">Joined at</th>
                  <th rowSpan="2">View pad</th>
                </tr>
                <tr>
                  <th className="width-50">Title</th>
                  <th className="width-50">Language</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td rowSpan="2">Dat09</td>
                  <td rowSpan="2">untitle-pad</td>
                  <td rowSpan="2">php</td>
                </tr>
                <tr>
                  <td className="width-50">3 day agos</td>
                  <td className="width-50">
                    <i
                      className="fa fa-eye text-success fs-4 ms-4"
                      aria-hidden="true"
                    ></i>
                  </td>
                </tr>
              </tbody>
            </table>
        </Fragment>
    );
}

export default IntervieweeTable;
