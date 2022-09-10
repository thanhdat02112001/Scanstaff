import React, { useState } from "react";
import { Link } from "react-router-dom";
import {
  Dropdown,
  DropdownToggle,
  DropdownMenu,
  Row,
  Col,
} from "reactstrap";
import classes from "./Topbar.module.css";
import SimpleBar from "simplebar-react";
import logo from "../../assets/images/icon.png"

const Notification = () => {
  const [isOpen, setIsOpen] = useState(false);
  return (
    <React.Fragment>
      <Dropdown
        className="dropdown d-inline-block"
        tag="li"
        isOpen={isOpen}
        onClick={() => {
          setIsOpen(!isOpen);
        }}
      >
        <DropdownToggle
          className={"btn header-item " + classes["noti-icon"]}
          tag="button"
          id={classes["page-header-notifications-dropdown"]}
        >
          <i className="fa fa-bell-o" />
          <span className={classes.badge + " bg-danger rounded-pill"}>3</span>
        </DropdownToggle>

        <DropdownMenu
          className={
            classes["dropdown-menu"] + " dropdown-menu-lg dropdown-menu-end p-0"
          }
        >
          <div className="p-3">
            <Row className="align-items-center">
              <Col>
                <h6 className="m-0"> Notifications </h6>
              </Col>
              <div className="col-auto">
                <a href="/view-all" className="small">
                  {" "}
                  View All
                </a>
              </div>
            </Row>
          </div>

          <SimpleBar style={{ height: "230px" }}>
            <Link
              to=""
              className={"text-reset " + classes["notification-item"]}
            >
              <div className="d-flex">
                <img className="me-3 rounded-circle avatar-xs" alt="user-pic" src={logo} height={100}/>
                <div className="flex-grow-1">
                  <h6 className="mt-0 mb-1">James Lemire</h6>
                  <div className="font-size-12 text-muted">
                    <p className="mb-1">It will seem like simplified English</p>
                    <p className="mb-0">
                      <i className="mdi mdi-clock-outline" />1 hours ago{" "}
                    </p>
                  </div>
                </div>
              </div>
            </Link>
          </SimpleBar>
          <div className="p-2 border-top d-grid">
            <Link
              className="btn btn-sm btn-link font-size-14 text-center"
              to="#"
            >
              <i className="mdi mdi-arrow-right-circle me-1"></i>{" "}
              <span key="t-view-more">View More..</span>
            </Link>
          </div>
        </DropdownMenu>
      </Dropdown>
    </React.Fragment>
  );
};

export default Notification;
