import React from "react";
import styled from "styled-components";
import UserWrapper from "../../components/Interviewer/UserWrapper";
import QuestionFilter from "../../components/Questions/QuestionFilter";
import UserSidebar from "../../components/Sidebar/UserSidebar";
import TopBar from "../../components/TopBar/TopBar";
import styles from "../../components/Questions/Question.module.css";
import { Col } from "reactstrap";
import QuestionItem from "../../components/Questions/QuestionItem";
import { Link } from "react-router-dom";

const Content = styled.div`
  margin-top: 100px;
  margin-left: 250px;
  margin-right: 30px;
`;

const QuestionDetail = () => {
  return (
    <div>
      <UserSidebar />
      <TopBar current="Questions" link="questions" />
      <Content>
        <UserWrapper>
          <div className={styles.title}>
            <div>
              <h3>Manage Questions</h3>
            </div>
            <div>
              <button className="btn btn-success me-3">Create Questions</button>
            </div>
          </div>
          <div className={styles.body}>
            <Col md="2" className={styles["left"]}>
              <div className={styles.filter}>
                <QuestionFilter />
              </div>
              <div className={styles["list-question"]}>
                <h6>YOUR QUESTIONS</h6>
                <Link to="/question/detail">
                  <QuestionItem />
                </Link>
              </div>
            </Col>
            <Col md="10" className={styles["question-right"]}>
              <div className={styles["question-detail"]}>
                <div className={styles.header}>
                  <div className={styles.info}>
                    <h5>Question 1</h5>
                    <span>name question</span>
                    <p>php create 2 days ago</p>
                  </div>
                  <div>
                    <button className="btn btn-primary">
                      <i
                        className="fa fa-arrow-left me-2"
                        aria-hidden="true"
                      ></i>
                      Back
                    </button>
                  </div>
                </div>
                <div className={styles["question-content"]}>
                  <div>monaco editor</div>
                </div>
                <div className={styles.action}>
                  <Link to="/question/edit">
                    {" "}
                    <button className="btn btn-outline-primary me-3">
                      Edit
                    </button>
                  </Link>
                  <button className="btn btn-outline-success">
                    Create pad with this question
                  </button>
                </div>
              </div>
            </Col>
          </div>
        </UserWrapper>
      </Content>
    </div>
  );
};

export default QuestionDetail;
