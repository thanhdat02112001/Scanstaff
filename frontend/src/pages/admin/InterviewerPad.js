import React from "react";
import PadTable from "../../components/Interviewer/PadTable";
import AdminSidebar from "../../components/Sidebar/AdminSidebar";
import TopBar from "../../components/TopBar/TopBar";
import styled from "styled-components";
import UserWrapper from "../../components/Interviewer/UserWrapper";
const Content = styled.div`
  margin-top: 100px;
  margin-left: 250px;
  margin-right: 30px;

  table {
    border: 1px solid black;
    text-align: center;
  }
  .pad-table {
    padding: 20px;
  }
`;

const InterviewerPad = () => {
  return (
    <React.Fragment>
      <AdminSidebar />
      <TopBar current="Interviewer / Pad" link="/interviewer/pad" />
      <Content>
        <UserWrapper>
          <div className="title">
            <h3>
              List pads of interviewer "Thanh Dat" with email
              "dat.dt@zinza.com.vn"
            </h3>
          </div>
          <div className="pad-table">
            <PadTable />
          </div>
        </UserWrapper>
      </Content>
    </React.Fragment>
  );
};

export default InterviewerPad;
