import React, { useState } from "react";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import Welcome from "./pages/Welcome";
//import Login from "./components/Login/Login";
import Login from "./pages/authentication/Login";
import Register from "./pages/authentication/Register";
import ForgetPassword from "./pages/authentication/ForgetPassword";
import NotiEmail from "./pages/authentication/NotiEmail";
import Home from "./pages/Home";
export default function App() {
  const [token, setToken] = useState("");
  const handlerLogin = (token) => {
    setToken(token)
  }
  
  return (
    <BrowserRouter>
      <Routes>
      <Route path="/" element={<Welcome/>}></Route>
      <Route path="/login" element={<Login onLogin={handlerLogin}/>}></Route>
      <Route path="/register" element={<Register/>}></Route>
      <Route path="/forgot-password" element={<ForgetPassword/>}></Route>
      <Route path="/verification-notice" element={<NotiEmail/>}></Route>
      <Route path="/home" element={<Home/>}></Route>
      </Routes>
    </BrowserRouter>
  );
}
