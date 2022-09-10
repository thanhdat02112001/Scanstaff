import React from 'react'
import Chart from '../../components/Chart/Chart'
import AdminSidebar from '../../components/Sidebar/AdminSidebar'
import TopBar from '../../components/TopBar/TopBar'

export default function Home() {
  return (
    <div>
        <AdminSidebar/>
        <TopBar current="dashboard" link="/home"/>
        <Chart/>
    </div>
  ) 
}
