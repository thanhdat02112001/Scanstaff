import React, { useRef, useState } from "react";
import {
  Card,
  CardBody,
  Col,
  Container,
  Row,
  Label,
  Form,
} from "reactstrap";
import { Link, useNavigate } from "react-router-dom";
import { CircleSpinnerOverlay} from "react-spinner-overlay"
import logo from "../../assets/images/logo.png";

// import images
import profile from "../../assets/images/profile-img.png";
import axios from "axios";

export default function Register(props) {
  const nameRef = useRef();
  const mailRef = useRef();
  const passRef = useRef();
  const passCfRef = useRef();
  const [errors, setErrors] = useState({});
  const [isLoading, setIsLoading] = useState(false);
  const navigate = useNavigate();

  const handlerRegister = async (e) => {
    e.preventDefault();
    const enterName = nameRef.current.value;
    const enterMail = mailRef.current.value;
    const enterPass = passRef.current.value;
    const enterPassCf = passCfRef.current.value;
    setIsLoading(true);
    await axios
      .post("https://staffscan.com.vn/api/register", {
        name: enterName,
        email: enterMail,
        password: enterPass,
        password_confirmation: enterPassCf,
      })
      .then((res) => {
        if (res.status === 200) {
          setIsLoading(false);
          navigate("/verification-notice");
        }
      })
      .catch((error) => {
        setIsLoading(false);
        setErrors(error.response.data.errors);
      });
  };
  return (
    <React.Fragment>
      <div className="account-pages my-5 pt-sm-5">
        <Container>
          {isLoading  && <CircleSpinnerOverlay color="#259aee"/>}
          <Row className="justify-content-center">
            <Col md={8} lg={6} xl={5}>
              <Card className="overflow-hidden">
                <div className="bg-primary bg-soft">
                  <Row>
                    <Col className="col-7">
                      <div className="text-primary p-4">
                        <h5 className="text-light">Free Register !</h5>
                        <p className="text-light">
                          Get your StaffScan's acount now.
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
                      onSubmit={handlerRegister}
                    >
                      <div className="mb-3">
                        <Label for="name" className="form-label">
                          User Name
                        </Label>
                        <div className="input-group ">
                          <input
                            name="name"
                            type="text"
                            ref={nameRef}
                            className={
                              "form-control" +
                              (errors["name"] ? " is-invalid" : "")
                            }
                          />
                        </div>
                        {errors["name"] && (
                          <span className="text-danger">{errors["name"]}</span>
                        )}
                      </div>
                      <div className="mb-3">
                        <Label for="email" className="form-label">
                          Email
                        </Label>
                        <input
                          name="email"
                          type="text"
                          ref={mailRef}
                          className={
                            "form-control" +
                            (errors["email"] ? " is-invalid" : "")
                          }
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
                            ref={passRef}
                            autoComplete="true"
                            className={
                              "form-control" +
                              (errors["password"] ? " is-invalid" : "")
                            }
                          />
                        </div>
                        {errors["password"] && (
                          <span className="text-danger">
                            {errors["password"]}
                          </span>
                        )}
                      </div>

                      <div className="mb-3">
                        <Label
                          for="password_confirmation"
                          className="form-label"
                        >
                          Password Confirmation
                        </Label>
                        <div className="input-group auth-pass-inputgroup">
                          <input
                            name="password_confirmation"
                            type="password"
                            ref={passCfRef}
                            autoComplete="true"
                            className={
                              "form-control" +
                              (errors["password"] ? " is-invalid" : "")
                            }
                          />
                        </div>
                      </div>

                      <div className="mt-3 d-grid">
                        <button
                          className="btn btn-primary btn-block"
                          type="submit"
                        >
                          Register
                        </button>
                      </div>

                      <div className="mt-4 text-center">
                        By registering you agree to the StaffScan
                        <Link to="#" className="ms-2">
                          Term of Use
                        </Link>
                      </div>
                    </Form>
                  </div>
                </CardBody>
              </Card>
              <div className="mt-5 text-center">
                <p>
                  Already have an account ? <></>
                  <Link to="/login" className="fw-medium text-primary">
                    Login
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
