import React from "react";
import { Col } from "react-bootstrap";

const PadFilter = () => {
  return (
    <React.Fragment>
      <Col md="3">
        <input className="form-control w-50" placeholder="Search..."></input>
      </Col>
      <Col md="9 d-flex justify-content-end align-items-center">
        <div className="me-3">
          <select className="form-select">
            <option defaultValue={"any"}>Any pad status</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
        </div>
        <div className="me-3">
          <select className="form-select">
            <option defaultValue={"any"}>Any language</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
        </div>
      </Col>
    </React.Fragment>
  );
};

export default PadFilter;
