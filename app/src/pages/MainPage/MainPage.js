import React, {useEffect, useState} from 'react'
import Container from 'react-bootstrap/Container'
import './main-page.css'
import Header from './Header'
import {Animal} from './Animal'
import Lonely from './Lonely'
import data from './data.json'
import {useDispatch, useSelector} from "react-redux";
import {getAllAnimals} from "../../shared/actions/get-animal";

export const MainPage = () => {

   const dispatch = useDispatch();

   const sideEffects = () => {
      dispatch(getAllAnimals());
   };

   useEffect(sideEffects, []);

   const animals = useSelector(state => (
      state.animals ? state.animals:[]
   ))
   console.log(animals);

    return (
       <div className="mpbg">
           <Container fluid="true" className="mainPage">
               <Header/>
               <Animal/>
           </Container>
       </div>
    )
}