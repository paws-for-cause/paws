import React, {useEffect, useState} from 'react'
import Container from 'react-bootstrap/Container'
import './main-page.css'
import Header from './Header'
import {Animal} from './Animal'
import Lonely from './Lonely'
import data from './data.json'
import {useDispatch, useSelector} from "react-redux";
import {getAllAnimals} from "../../shared/actions/get-animal";
import {httpConfig} from "../../shared/utils/http-config";

export const MainPage = () => {

   const dispatch = useDispatch();

   const [status, setStatus] = useState(null)

   const sideEffects = () => {
      dispatch(getAllAnimals());
   };

   useEffect(sideEffects, []);

   const animals = useSelector(state => (
      state.animals ? state.animals:[]
   ));

   console.log(animals);

   const handleClick = (likeAnimalId, isAnimalLiked) => {
      const likeApproved = isAnimalLiked ? 1:0
      httpConfig.post("/apis/like/", {likeAnimalId, likeApproved})
         .then(reply => {

         })
   }

    return (
       <div className="mpbg">
           <Container fluid="true" className="mainPage">
               <Header/>
              {animals.length >= 1 && <Animal animal = {animals[0]}
              handleClick = {handleClick}/>}
              {status && (<div className={status.type}>{status.message}</div>)}
           </Container>
       </div>
    )
}