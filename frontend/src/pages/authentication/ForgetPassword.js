import React from "react";
import { Link } from "react-router-dom";
import {
  Alert,
  Card,
  CardBody,
  Col,
  Container,
  Label,
  Row,
  Form,
} from "reactstrap";

import profile from "../../assets/images/profile-img.png";
import logo from "../../assets/images/logo.png";

export default function ForgetPassword(props) {
  return (
    <React.Fragment>
      <div className="account-pages my-5 pt-sm-5">
        <Container>
          <Row className="justify-content-center">
            <Col md={8} lg={6} xl={5}>
              <Card className="overflow-hidden">
                <div className="bg-primary bg-soft">
                  <Row>
                    <Col className="col-7">
                      <div className="text-light p-4">
                        <h5 className="text-light">Welcome Back !</h5>
                        <p>Enter your email to receive reset password mail.</p>
                      </div>
                    </Col>
                    <Col className="col-5 align-self-end">
                      <img src={profile} alt="" className="img-fluid" />
                    </Col>
                  </Row>
                </div>
                <CardBody className="pt-0">
                  <div className="avatar-md profile-user-wid d-flex justify-content-center">
                    <Link to="/">
                      <span className="avatar-title rounded-circle">
                        <img
                          src={logo}
                          alt=""
                          className="rounded-circle"
                          height="150"
                        />
                      </span>
                    </Link>
                  </div>
                  <div className="p-2">
                    {props.forgetError && props.forgetError ? (
                      <Alert color="danger" style={{ marginTop: "13px" }}>
                        {props.forgetError}
                      </Alert>
                    ) : null}
                    {props.forgetSuccessMsg ? (
                      <Alert color="success" style={{ marginTop: "13px" }}>
                        {props.forgetSuccessMsg}
                      </Alert>
                    ) : null}

                    <Form className="form-horizontal">
                      <div className="mb-3">
                        <Label for="email" className="form-label">
                          Email
                        </Label>
                        <input
                          name="email"
                          type="text"
                          className="form-control"
                        />
                      </div>
                      <div className="text-end">
                        <button className="btn btn-primary w-md" type="submit">
                          Reset
                        </button>
                      </div>
                    </Form>
                  </div>
                </CardBody>
              </Card>
              <div className="mt-5 text-center">
                <p>
                  Go back to{" "}
                  <Link to="/login" className="fw-medium text-primary">
                    Login
                  </Link>{" "}
                </p>
              </div>
            </Col>
          </Row>
        </Container>
      </div>
    </React.Fragment>
  );
}
