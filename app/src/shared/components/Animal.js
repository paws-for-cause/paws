import React from 'react';
import Container from "react-bootstrap/Container";
import {handleAnimal} from "../actions/get-animal";
import {useDispatch} from "react-redux";

export const Animal = (props) => {
console.log(props)

const {animal: {animalId, animalBreed, animalName, animalPhotoUrl, animalSpecies}} = props;

const dispatch = useDispatch();

   return (
      <>
         <Container>
            <div className="animal">
               <div className="animal-photo img-fluid">
                  <img src={`${animalPhotoUrl}`} alt={animalName} />
               </div>

               <div className="animal-description">
                  <p className="animal-name-species">
                     {animalName}, <span>{animalSpecies}</span>
                  </p>
                  <p className="animal-breed">{animalBreed}</p>
               </div>
            </div>
            <div id="actions">
               <button
                  type="button"
                  onClick={() => dispatch(handleAnimal(animalId, 0))}
               >
                  <img src="images/misc/dislike.png" alt="Dislike Animal" />
               </button>
               <button
                  type="button"
                  onClick={() => dispatch(handleAnimal(animalId, 1))}
               >
                  <img src="images/misc/like.png" alt="Like Animal" />
               </button>
            </div>
         </Container>
      </>
   );
};
