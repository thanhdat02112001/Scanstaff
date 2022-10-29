import axios from "axios";
import React, { useEffect } from "react";
import { Link, Navigate, useNavigate } from "react-router-dom";
import { Breadcrumb, BreadcrumbItem, Form, Input } from "reactstrap";
import Notification from "./Notification";
import Pusher from "pusher-js";
import styles from "./Topbar.module.css";

const TopBar = (props) => {

  var pusher = new Pusher('1dcf4e7608b407bd1a07', {
    cluster: 'ap1'
  });

  var channel = pusher.subscribe('user-register');
  channel.bind('new-user', function(e) {
      var notify = JSON.parse(e.noti);
      var noti_string = `User ${notify.name} with email ${notify.email} want to register.`;
      alert(noti_string);
  });
 
  const token = localStorage.getItem("token");
  const navigate = useNavigate();
  const handlerLogout = () => {
    axios
      .post(
        "https://zcheck.zinza.com.vn/api/logout",
        {},
        {
          headers: { Authorization: `Bearer ${token}` },
        }
      )
      .then((res) => {
        if (res.status === 200) {
          localStorage.removeItem("token");
          navigate("/");
        }
      });
  };
  return (
    <React.Fragment>
      <header id={styles["page-topbar"]}>
        <div className={styles["navbar-header"]}>
          <div>
            <Breadcrumb className="fs-5">
              <BreadcrumbItem>
                <Link to="/home">Home</Link>
              </BreadcrumbItem>
              <BreadcrumbItem>
                <Link to={props.link}>{props.current}</Link>
              </BreadcrumbItem>
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
            <button className={styles.logout} onClick={handlerLogout}>
              <i className="fa fa-sign-out ms-3" aria-hidden="true"></i> Logout
            </button>
          </div>
        </div>
      </header>
    </React.Fragment>
  );
};

export default TopBar;
