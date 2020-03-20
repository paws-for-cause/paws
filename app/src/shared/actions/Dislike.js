import React from 'react';

const Dislike = () => (
    <button
        type="button"
        onClick={() => modifyAnimalChoices(animalId, 'ADD_TO_DISLIKED_USERS')}
    >
        <img src="images/misc/dislike.png" alt="Dislike Animal" />
    </button>
);

export default Dislike;