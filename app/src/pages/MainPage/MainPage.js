import React, { useState } from 'react'
import Container from 'react-bootstrap/Container'
import './main-page.css'
import Header from './Header'
import Animal from './Animal'
import Lonely from './Lonely'
import data from './data.json'

export const MainPage = () => {
    return (
       <div className="mpbg">
           <Container fluid="true" className="mainPage">
               <Header/>
               <Animal/>
           </Container>
       </div>
    )
}