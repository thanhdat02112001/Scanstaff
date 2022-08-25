import React from "react";
import { Link } from "react-router-dom";
import { Breadcrumb, BreadcrumbItem, Form, Input } from "reactstrap";

import Notification from "./Notification";

import styles from "./Topbar.module.css";

const TopBar = () => {
  return (
    <React.Fragment>
      <header id={styles["page-topbar"]}>
        <div className={styles["navbar-header"]}>
          <div>
            <Breadcrumb className="fs-5">
              <BreadcrumbItem href="/home"  >Home</BreadcrumbItem>
              <BreadcrumbItem href="/dashboard">dashboard</BreadcrumbItem>
            </Breadcrumb>
          </div>
          <div className="d-flex align-item-center">
            <Notification />
            <Form className="ms-3">
              <Input className="w-100" bsSize="sm" type="select">
                <option>Admin</option>
                <option>User</option>
              </Input>
            </Form>
            <Link to="/logout" className="mt-1">
              <i className="fa fa-sign-out ms-3" aria-hidden="true"></i> Logout
            </Link>
          </div>
        </div>
      </header>
    </React.Fragment>
  );
};

export default TopBar;
