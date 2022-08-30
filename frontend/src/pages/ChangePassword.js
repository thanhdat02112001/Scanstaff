import React from "react";
import {
  Card,
  CardBody,
  Col,
  Container,
  Row,
  Label,
  Form,
} from "reactstrap";

// import images
import profile from "../assets/images/profile-img.png";
import logo from "../assets/images/logo.png";
import { Link } from "react-router-dom";

const ChangePassword = () => {
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
                      <div className="text-primary p-4">
                        <h5 className="text-light">Welcome!</h5>
                        <p className="text-light">
                          Change your password here.
                        </p>
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
                    <Form className="form-horizontal">
                      <div className="mb-3">
                        <Label for="old_password" className="form-label">
                          Old Password
                        </Label>
                        <input
                          name="old_password"
                          type="text"
                          className={"form-control"}
                        />
                      </div>

                      <div className="mb-3">
                        <Label for="password" className="form-label">
                          New Password
                        </Label>
                        <div className="input-group auth-pass-inputgroup">
                          <input
                            name="password"
                            type="password"
                            autoComplete="true"
                            className={"form-control"}
                          />
                        </div>
                      </div>
                      <div className="mb-3">
                        <Label
                          for="password_confirmation"
                          className="form-label"
                        >
                          New Password Confirmation
                        </Label>
                        <div className="input-group auth-pass-inputgroup">
                          <input
                            name="password_confirmation"
                            type="password"
                            autoComplete="true"
                            className={"form-control"}
                          />
                        </div>
                      </div>

                      <div className="mt-3 d-grid">
                        <button
                          className="btn btn-primary btn-block"
                          type="submit"
                        >
                          Change Password
                        </button>
                      </div>
                    </Form>
                  </div>
                </CardBody>
              </Card>
            </Col>
          </Row>
        </Container>
      </div>
    </React.Fragment>
  );
};

export default ChangePassword;
