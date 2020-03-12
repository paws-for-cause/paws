import React from 'react';

const Like = ({ animalId, modifyAnimalChoices }) => (
    <button
        type="button"
        onClick={() => modifyAnimalChoices(animalId, 'ADD_TO_LIKED_USERS')}
    >
        <img src="images/misc/like.png" alt="Like Animal" />
    </button>
);

export default Like;