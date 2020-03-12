import React, { useState } from 'react';
import '../app.css';
import Header from './components/Header';
import Animal from './components/Animal';
import Lonely from './components/Lonely';
import data from './data.json';

const LikeSwitch = () => {
    const [animal, setAnimal] = useState(data);
    const [likedAnimals, setLikedAnimals] = useState([]);
    const [dislikedAnimals, setDislikedAnimals] = useState([]);
    const activeAnimal = 0;

    const removedAnimalFromDataSrc = (animalSource, animalId) =>
        animalSource.filter(animal => animal.id !== animalId);

    const modifyAnimalChoices = (animalId, action) => {
        const newAnimal = [...animal];
        const newLikedAnimals = [...likedAnimals];
        const newDislikedAnimals = [...dislikedAnimals];

        switch (action) {
            case 'ADD_TO_LIKED_USERS':
                if (!animal[activeAnimal].likedAnimals.includes(animalId)) {
                    newAnimal[activeAnimal].likedAnimals.push(animalId);
                    newLikedAnimals.push(data[animalId]);

                    setLikedAnimals(newLikedAnimals);
                    setAnimal(removedAnimalFromDataSrc(animal, animalId));
                }
                break;
            case 'ADD_TO_DISLIKED_USERS':
                if (!animal[activeAnimal].dislikedAnimals.includes(animalId)) {
                    newAnimal[activeAnimal].dislikedAnimals.push(animalId);
                    newDislikedAnimals.push(data[animalId]);

                    setDislikedAnimals(newLikedAnimals);
                    setAnimal(removedAnimalFromDataSrc(animal, animalId));
                }
            default:
                return animal;
        }
    };

    return (
        <div className="app">
            <Header />
            {animal[1] ? (
                <Animal
                    key={animal[1].id}
                    animal={animal[1]}
                    modifyAnimalChoices={modifyAnimalChoices}
                    likedAnimals={likedAnimals}
                />
            ) : (
                <Lonely
                    activeAnimalImage={animal[activeAnimal].image}
                    likedAnimals={likedAnimals}
                />
            )}
        </div>
    );
};

export default LikeSwitch;