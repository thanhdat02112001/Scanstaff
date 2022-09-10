import React from 'react';
import { Col, Card, CardBody } from "reactstrap"
import styles from "./DashboardItem.module.css"

const DashboardItem = (props) => {
    return (
        <React.Fragment>
        <Col md="4">
          <Card className={styles["mini-stats-wid"] + styles.card }>
            <CardBody>
              <div className="d-flex">
                <div className="flex-grow-1">
                  <p className="text-muted fw-medium mb-2">
                    {props.title}
                  </p>
                  <h4 className="mb-0">{props.text}</h4>
                </div>

                <div className="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                  <span className="avatar-title">
                    <i
                      className={"fa " + props.iconClass + " fs-2 text-light"}
                    />
                  </span>
                </div>
              </div>
            </CardBody>
          </Card>
        </Col>
      </React.Fragment>
    );
}

export default DashboardItem;
