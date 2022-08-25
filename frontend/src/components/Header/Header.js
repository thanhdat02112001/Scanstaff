import React, { Fragment } from "react";
import { Nav } from "react-bootstrap";
import { Link } from "react-router-dom";
import classes from "./Header.module.css";
import logo from "../../assets/images/logo.png";

export default function Header() {
  return (
    <Fragment>
      <div className={classes.header}>
        <Link to="/" id="logo">
          <img src={logo} alt="Logo" height="200" />
        </Link>

        <Nav className={classes.action}>
          <Link to="/login" className="me-3">
            <i className="fa fa-sign-in me-2"></i>Login
          </Link>

          <Link to="/register">
            <i className="fa fa-user-plus me-2"></i>Register
          </Link>
        </Nav>
      </div>
    </Fragment>
  );
}
