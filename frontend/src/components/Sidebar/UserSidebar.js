import React, { Fragment } from "react";
import { Link } from "react-router-dom";
import logo from "../../assets/images/logo.png";
import classes from "./Sidebar.module.css";

export default function UserSidebar() {
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
              <Link to="/user-home">
              <i className="fa fa-file me-2" aria-hidden="true"></i>Pads
              </Link>
            </li>
            <li>
              <Link to="/questions">
                <i className="fa fa-question-circle me-1 ms-1" ></i>
                Questions
              </Link>
            </li>
            <li>
              <Link to="/user/interviewee">
                <i className="fa fa-graduation-cap"></i> Interviewees
              </Link>
            </li>
            <li>
              <Link to="/password-change">
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
