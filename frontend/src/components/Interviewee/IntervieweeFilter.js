import React, { Fragment } from "react";
import { Col } from "reactstrap";

const IntervieweeFilter = () => {
  return (
    <Fragment>
      <Col md="3">
        <input
          className="form-control w-50"
          placeholder="Search Name..."
        ></input>
      </Col>
      <Col md="9 d-flex justify-content-end align-items-center">
        <span>Join Date</span>
        <div className="me-3 ms-3">
          <select className="form-select">
            <option value="0">Today</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
        </div>
      </Col>
    </Fragment>
  );
};

export default IntervieweeFilter;
