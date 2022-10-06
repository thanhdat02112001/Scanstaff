import React from "react";
import UserSidebar from "../../components/Sidebar/UserSidebar";
import TopBar from "../../components/TopBar/TopBar";

import styled from "styled-components";
import UserWrapper from "../../components/Interviewer/UserWrapper";
import PadFilter from "../../components/UserPad/PadFilter";
import PadTable from "../../components/UserPad/PadTable";
import { Row } from "reactstrap";
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
  .body {
    height: 85vh;
  }

  .title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 10px;
    border-bottom: 1px solid rgb(210, 175, 233);
  }
  .title h3 {
    padding: 0 !important;
    border-bottom: none !important;
  }
`;

const UserHome = (props) => {
  return (
    <div>
      <UserSidebar />
      <TopBar current="Userhome" link="/user-home"/>
      <Content>
        <UserWrapper>
          <div className="body">
            <div className="title">
              <div>
                <h3>Manage Pads</h3>
                <span>
                  Your pads appear below. You can search by interviewee name,
                  and filter by pad status or pad's language.
                </span>
              </div>
              <div>
                <button className="btn btn-success me-3">Create Pad</button>
              </div>
            </div>
            <Row className="mt-3 ps-4">
              <PadFilter />
            </Row>
            <div className="interviewee-table">
              <PadTable />
            </div>
          </div>
        </UserWrapper>
      </Content>
    </div>
  );
};

export default UserHome;
