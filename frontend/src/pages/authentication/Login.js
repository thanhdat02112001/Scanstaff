import React, { useRef, useState } from "react";
import {
  Alert,
  Card,
  CardBody,
  Col,
  Container,
  Row,
  Label,
  Form,
} from "reactstrap";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";

// import images
import profile from "../../assets/images/profile-img.png";
import logo from "../../assets/images/logo.png";

export default function Login(props) {
  const mailRef = useRef();
  const passRef = useRef();
  const [loginSuccess, setLoginSuccess] = useState(true);
  const [errors, setErrors] = useState("");
  const [message, setMessage] = useState("");
  const navigate = useNavigate();
  const handlerFormSubmit = (e) => {
    e.preventDefault();
    setErrors("");
    const enterMail = mailRef.current.value;
    const enterPass = passRef.current.value;

    axios
      .post("https://staffscan.com.vn/api/login", {
        email: enterMail,
        password: enterPass,
      })
      .then((res) => {
        if (res.data.status === 200) {
          props.onLogin(res.data.access_token, res.data.isAdmin);
          navigate("/home");
        }
      })
      .catch((error) => {
        if (error.response.status === 401) {
          setMessage(error.response.data.message);
          setLoginSuccess(false);
        } else {
          setErrors(error.response.data.errors);
        }
      });
  };
  return (
    <React.Fragment>
      <div className="account-pages my-5 pt-sm-5">
        <Container>
          <Row className="justify-content-center">
            <Col md={8} lg={6} xl={5}>
              {!loginSuccess && (
                <Alert
                  color="danger"
                  className="text-center"
                  onClick={() => {
                    setLoginSuccess(true);
                  }}
                >
                  {message}
                </Alert>
              )}
              <Card className="overflow-hidden">
                <div className="bg-primary bg-soft">
                  <Row>
                    <Col className="col-7">
                      <div className="text-primary p-4">
                        <h5 className="text-light">Welcome Back !</h5>
                        <p className="text-light">
                          Sign in to continue to StaffScan.
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
                    <Form
                      className="form-horizontal"
                      onSubmit={handlerFormSubmit}
                    >
                      <div className="mb-3">
                        <Label for="email" className="form-label">
                          Email
                        </Label>
                        <input
                          name="email"
                          type="text"
                          className={
                            "form-control" +
                            (errors["email"] ? " is-invalid" : "")
                          }
                          ref={mailRef}
                        />
                      </div>
                      {errors["email"] && (
                        <span className="text-danger">{errors["email"]}</span>
                      )}
                      <div className="mb-3">
                        <Label for="password" className="form-label">
                          Password
                        </Label>
                        <div className="input-group auth-pass-inputgroup">
                          <input
                            name="password"
                            type="password"
                            autoComplete="true"
                            className={
                              "form-control" +
                              (errors["password"] ? " is-invalid" : "")
                            }
                            ref={passRef}
                          />
                        </div>
                        {errors["password"] && (
                          <span className="text-danger">
                            {errors["password"]}
                          </span>
                        )}
                      </div>

                      <div className="form-check">
                        <input
                          type="checkbox"
                          className="form-check-input"
                          id="customControlInline"
                        />
                        <label
                          className="form-check-label"
                          htmlFor="customControlInline"
                        >
                          Remember me
                        </label>
                      </div>

                      <div className="mt-3 d-grid">
                        <button
                          className="btn btn-primary btn-block"
                          type="submit"
                        >
                          Log In
                        </button>
                      </div>

                      <div className="mt-4 text-center">
                        <Link to="/forgot-password" className="text-muted">
                          <i className="mdi mdi-lock me-1" /> Forgot your
                          password?
                        </Link>
                      </div>
                    </Form>
                  </div>
                </CardBody>
              </Card>
              <div className="mt-5 text-center">
                <p>
                  Don&apos;t have an account ? <></>
                  <Link to="/register" className="fw-medium text-primary">
                    Signup Now
                  </Link>
                </p>
              </div>
            </Col>
          </Row>
        </Container>
      </div>
    </React.Fragment>
  );
}
