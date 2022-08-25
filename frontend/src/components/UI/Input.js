import React from "react";
import { Form } from "react-bootstrap";
export default function Input(props) {
  return (
    <div>
      <Form.Group className="mb-3">
        <Form.Label>{props.label}</Form.Label>
        <Form.Control type={props.type} placeholder={props.placeholder} />
      </Form.Group>
    </div>
  );
}
