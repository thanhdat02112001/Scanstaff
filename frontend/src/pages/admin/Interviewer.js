import React from "react";
import ListInterviewer from "../../components/Interviewer/ListInterviewer";
import ManageInterviewer from "../../components/Interviewer/ManageInterviewer";
import AdminSidebar from "../../components/Sidebar/AdminSidebar";
import TopBar from "../../components/TopBar/TopBar";
import styled from "styled-components";
const Content = styled.div`
  margin-top: 100px;
  margin-left: 250px;
  margin-right: 30px;

  table {
    border: 1px solid rgb(210, 175, 233);
    text-align: center;
  }
  .interviewer-table {
    padding: 20px;
  }
`;

const Interviewer = () => {
  return (
    <div>
      <AdminSidebar />
      <TopBar current="Interviewer" link="/interviewer" />
      <Content>
        <ManageInterviewer />
        <ListInterviewer />
      </Content>
    </div>
  );
};

export default Interviewer;
