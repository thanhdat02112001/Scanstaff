import React from "react";
import AdminSidebar from "../../components/Sidebar/AdminSidebar";
import TopBar from "../../components/TopBar/TopBar";
import styled from "styled-components";
import UserWrapper from "../../components/Interviewer/UserWrapper";
import IntervieweeTable from "../../components/Interviewee/IntervieweeTable";
import { Row } from "reactstrap";
import IntervieweeFilter from "../../components/Interviewee/IntervieweeFilter";

const Content = styled.div`
  margin-top: 100px;
  margin-left: 250px;
  margin-right: 30px;
  table {
    border: 1px solid rgb(210, 175, 233);
    text-align: center;
  }
  .interviewee-table {
    padding: 20px;
  }
  .title {
    padding: 10px;
    border-bottom : 1px solid rgb(210, 175, 233);
  }
  .title h3 {
    padding: 0 !important;
    border-bottom: none !important;
  }
`;

const Interviewee = () => {
  return (
    <div>
      <AdminSidebar />
      <TopBar current="Interviewee" link="/interviewee" />
      <Content>
        <UserWrapper>
          <div className="title">
            <h3>Interviewee list</h3>
            <span>
              All interviewees appear below. You can search by interviewee name,
              or filter by join date of each interviewee
            </span>
          </div>
          <Row className="mt-3 ps-4">
            <IntervieweeFilter/>
          </Row>
          <div className="interviewee-table">
            <IntervieweeTable />
          </div>
        </UserWrapper>
      </Content>
    </div>
  );
};

export default Interviewee;
