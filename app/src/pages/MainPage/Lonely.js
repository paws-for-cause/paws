import React from 'react';
import LikedAnimal from '../../shared/components/LikedAnimal';
import Container from "react-bootstrap/Container";

const Lonely = ({ activeAnimalImage, likedAnimals }) => (
   <Container>
    <div id="lonely">
        <p>There's no new animals around you.</p>

        <span className="pulse">
      <img src={`/images/animals/${activeAnimalImage}`} alt="You..." />
    </span>

        <div id="liked-animal">
            <p>
                {likedAnimals.length > 0
                    ? "Animals you liked...let's hope they like you too!"
                    : ''}
            </p>
            {likedAnimals.map(item => (
                <LikedAnimal key={item.id} animal={item} />
            ))}
        </div>
    </div>
   </Container>
);


export default Lonely;