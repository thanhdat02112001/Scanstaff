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

const Questions = () => {
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
                <Link to="/question/detail"><QuestionItem/></Link>
              </div>
            </Col>
            <Col md="10" className={styles.right}>
              <div>
                <h2>Welcome to your Question Library</h2>
                <p>Questions you have written are listed on the left.</p>
                <p>
                  You can search for questions you want to use, edit existing
                  questions, and create new ones.
                </p>
                <button className="btn btn-success">Create new Question</button>
              </div>
            </Col>
          </div>
        </UserWrapper>
      </Content>
    </div>
  );
};

export default Questions;
