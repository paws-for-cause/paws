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

   //if like button pressed kill one animal child

   //first attempt

   /*const newAnimal = {...animals};
   newAnimal.splice(animals.index, 1);
   return newAnimal;*/

   //second attempt
   /*let pushAnimal = (state, action) => {
   switch (action.type) {
      case 'LIKE':
         let newAnimal = {animals: action.data}
         return state.concat([newAnimal]);
         let animalId = action.data;
      default:
         return state || [];
   }
}
   pushAnimal(onclick);*/


    return (
       <div className="mpbg">
           <Container fluid="true" className="mainPage">
               <Header/>
               <Animal/>
           </Container>
       </div>
    )
}