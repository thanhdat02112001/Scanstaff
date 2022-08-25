import React from "react";
import { Form, Button } from "react-bootstrap";
import classes from "./InputCode.module.css";
export default function InputCode() {
  return (
    <div className={classes.title}>
      <h1>Interviewee Test</h1>
      <h3>Ready to go? Enter code here</h3>
      <Form>
        <Form.Group className="mb-3">
          <Form.Control type="text" className="w-25" />
          <Button variant="primary" type="submit">
            <i className="fa fa-arrow-right me-1"></i>Go
          </Button>
        </Form.Group>
      </Form>
    </div>
  );
}
