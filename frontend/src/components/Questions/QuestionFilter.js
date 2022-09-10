import React, { Fragment } from "react";

const QuestionFilter = () => {
  return (
    <Fragment>
      <input className="form-control mb-2" placeholder="Search..." />
      <select className="form-select form-control">
        <option defaultValue={"any"}>Any language</option>
        <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option>
      </select>
    </Fragment>
  );
};

export default QuestionFilter;
