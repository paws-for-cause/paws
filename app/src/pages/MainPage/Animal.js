import React from 'react';
import Container from "react-bootstrap/Container";

export const Animal = (props) => {


const {animal: {animalName, animalBreed, animalPhotoUrl, animalSpecies}} = props;


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
               >
                  <img src="images/misc/dislike.png" alt="Dislike Animal" />
               </button>
               <button
                  type="button"
               >
                  <img src="images/misc/like.png" alt="Like Animal" />
               </button>
            </div>
         </Container>
      </>
   );
};
