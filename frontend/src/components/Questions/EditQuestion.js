import React from "react";
import styled from "styled-components";
import UserWrapper from "../../components/Interviewer/UserWrapper";
import UserSidebar from "../../components/Sidebar/UserSidebar";
import TopBar from "../../components/TopBar/TopBar";
import styles from "../../components/Questions/Question.module.css";

const Content = styled.div`
  margin-top: 100px;
  margin-left: 250px;
  margin-right: 30px;
`;

const EditQuestion = () => {
  return (
    <div>
      <UserSidebar />
      <TopBar current="Questions/edit" link="question/edit" />
      <Content>
        <UserWrapper>
          <div className={styles.title}>
            <div className="ms-3">
              <h3>Edit Questions</h3>
            </div>
            <div>
              <button className="btn btn-primary me-5">
                <i className="fa fa-arrow-left me-2" aria-hidden="true"></i>
                Back
              </button>
            </div>
          </div>
          <div className={styles["question-edit"]}>
            <form>
              <div className={styles["form-group"]}>
                <label>Title</label>
                <input className="form-control"></input>
              </div>
              <div className={styles["form-group"]}>
                <label>Language</label>
                <select className="form-select">
                  <option>Javascript</option>
                  <option>Javascript</option>
                  <option>Javascript</option>
                  <option>Javascript</option>
                </select>
              </div>
              <div className={styles["form-group"]}>
                <label>Description</label>
                <textarea className="form-control"></textarea>
              </div>
              <div className={styles["form-group"]}>
                <label>Content</label>
                <textarea className={"form-control "+ styles.monaco }></textarea>
              </div>
              <div className={styles["edit-action"]}>
                <button className="btn btn-success me-5">Save</button>
                <button className="btn btn-danger">Delete</button>
              </div>
            </form>
          </div>
        </UserWrapper>
      </Content>
    </div>
  );
};

export default EditQuestion;
