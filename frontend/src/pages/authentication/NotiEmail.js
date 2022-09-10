import axios from 'axios'
import React from 'react'
import { Link } from 'react-router-dom'
import { Card, CardBody, Col, Container, Row } from "reactstrap"
import logo from "../../assets/images/logo.png"
export default function NotiEmail() {

  const resendEmailVerify = async () => {
    await axios.get("https://zcheck.com.vn/api/resend").then((res) => {
      console.log(res)
    })
  }
  return (
    <React.Fragment>
        <div className="account-pages pt-sm-5">
          <Container>
            <Row>
              <Col lg={12}>
                <div className="text-center mb-5 text-muted">
                  <Link to="/" className="d-block auth-logo">
                    <img
                      src={logo}
                      alt=""
                      height="200"
                    />
                  </Link>
                  <p className="mt-3 text-primary fs-3">Email Verification Notice</p>
                </div>
              </Col>
            </Row>
            <Row className="justify-content-center">
              <Col md={8} lg={6} xl={5}>
                <Card>
                  <CardBody>
                    <div className="p-2">
                      <div className="text-center">
                        <div className="avatar-md mx-auto">
                          <div className="avatar-title rounded-circle bg-light">
                            <i className="bx bxs-envelope h1 mb-0 text-primary"></i>
                          </div>
                        </div>
                        <div className="p-2 mt-2 mb-3">
                          <h3>Verify your email</h3>
                          <p>
                            We have sent you verification email{" "}
                            <span className="font-weight-semibold">
                              example@abc.com
                            </span>
                            , Please check it
                          </p>
                          <div className="mt-4">
                            <a
                              href="/login"
                              className="btn btn-primary w-md"
                            >
                              Go to Login
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </CardBody>
                </Card>
                <div className="mt-5 text-center">
                  <p>
                    Didn&apos;t receive an email ?{" "}
                    <button className='btn btn-link shadow-none' type='button' onClick={resendEmailVerify}>Resend</button>
                  </p>
                </div>
              </Col>
            </Row>
          </Container>
        </div>
      </React.Fragment>
  )
}
