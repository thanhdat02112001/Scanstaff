import React, { useState } from "react";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import Welcome from "./pages/Welcome";
//import Login from "./components/Login/Login";
import Login from "./pages/authentication/Login";
import Register from "./pages/authentication/Register";
import ForgetPassword from "./pages/authentication/ForgetPassword";
import NotiEmail from "./pages/authentication/NotiEmail";
import Home from "./pages/admin/Home";
import Interviewer from "./pages/admin/Interviewer";
import Interviewee from "./pages/admin/Interviewee";
import { Interviewee as UserInterviewee } from "./pages/user/Interviewee";
import ChangePassword from "./pages/ChangePassword";
import InterviewerPad from "./pages/admin/InterviewerPad";
import UserHome from "./pages/user/UserHome";
import Questions from "./pages/user/Questions";
import QuestionDetail from "./components/Questions/QuestionDetail";
import EditQuestion from "./components/Questions/EditQuestion";

export default function App() {
  const [isAdmin, setIsAdmin] = useState(false);
  const handlerLogin = (token, isAdmin) => {
    localStorage.setItem("token", token);
    setIsAdmin(isAdmin);
  };
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Welcome />}></Route>
        <Route path="/login" element={<Login onLogin={handlerLogin} />}></Route>
        <Route path="/register" element={<Register />}></Route>
        <Route path="/forgot-password" element={<ForgetPassword />}></Route>
        <Route path="/verification-notice" element={<NotiEmail />}></Route>
        <Route path="/home" element={isAdmin ? <Home /> : <UserHome />}></Route>
        <Route path="/interviewer" element={<Interviewer />}></Route>
        <Route path="/interviewee" element={<Interviewee />}></Route>
        <Route path="/password-change" element={<ChangePassword />}></Route>
        <Route path="/interviewer/pad" element={<InterviewerPad />}></Route>
        <Route path="/user-home" element={<UserHome />}></Route>
        <Route path="/questions" element={<Questions />}></Route>
        <Route path="/user/interviewee" element={<UserInterviewee />}></Route>
        <Route path="/question/detail" element={<QuestionDetail />}></Route>
        <Route path="/question/edit" element={<EditQuestion />}></Route>
      </Routes>
    </BrowserRouter>
  );
}
