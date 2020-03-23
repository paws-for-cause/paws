import React from 'react';
import Container from "react-bootstrap/Container";

export const Animal = () => {


   const { name, breed, gender, image } = {"id":1,"name":"Martin","breed":"Prisoner at Federal Correctional Institution","gender":"Male","image":"2.jpg",}

   return (
      <>
         <Container>
            <div className="animal">
               <div className="animal-photo img-fluid">
                  <img src={`/images/animals/${image}`} alt={name} />
               </div>

               <div className="animal-description">
                  <p className="animal-name-gender">
                     {name}, <span>{gender}</span>
                  </p>
                  <p className="animal-breed">{breed}</p>
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
