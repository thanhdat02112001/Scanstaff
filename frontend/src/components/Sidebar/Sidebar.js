import React, { Fragment } from "react";
import { Link } from "react-router-dom";
import logo from "../../assets/images/logo.png";
import classes from "./Sidebar.module.css";

export default function Sidebar() {
  return (
    <Fragment>
      <div className={classes["vertical-menu"]}>
        <div className={classes["navbar-brand-box"]}>
          <Link to="/" className="logo logo-dark">
            <span className="logo-sm">
              <img src={logo} alt="" height="200" />
            </span>
          </Link>
        </div>
        <div className={classes["sidebar-item"]}>
          <ul>
            <li className={classes.active}>
              <Link to="/dashboard">
                <i className="fa fa-tachometer me-1"></i> Dashboard
              </Link>
            </li>
            <li>
              <Link to="/interviewer">
                <i className="fa fa-users me-1"></i> Interviewers
              </Link>
            </li>
            <li>
              <Link to="/interviewee">
                <i className="fa fa-graduation-cap"></i> Interviewees
              </Link>
            </li>
            <li>
              <Link to="/change-password">
                <i className="fa fa-key me-1"></i> Change password
              </Link>
            </li>
          </ul>
        </div>
        <div className={classes["sidebar-background"]}></div>
      </div>
    </Fragment>
  );
}
