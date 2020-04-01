import React, {useEffect, useState} from 'react'
import Container from 'react-bootstrap/Container'
import './main-page.css'
import Header from '../../shared/components/Header'
import {Animal} from '../../shared/components/Animal'
import {useDispatch, useSelector} from "react-redux";
import {getAllAnimals} from "../../shared/actions/get-animal";
import {handleClick} from "../../shared/actions/handleClick";

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
   //TODO
   // get status from httpConfig.post *
   // putting status into redux, useSelector to get out error message from Rexux *
   // only display error message if status is not 200 from api response

   //data downloader, get more animals

   //randomizing the result from animal class getAllAnimals


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