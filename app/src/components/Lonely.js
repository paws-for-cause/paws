import React from 'react';
import LikedAnimal from './LikedAnimal';

const Lonely = ({ activeAnimalImage, likedAnimals }) => (
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
);

export default Lonely;