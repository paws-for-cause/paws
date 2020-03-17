import React from 'react';
import Rewind from '../actions/Rewind';
import Dislike from '../actions/Dislike';
import Like from '../actions/Like';

const Actions = ({ animal, modifyAnimalChoices }) => (
    <div id="actions">
        <Rewind animalId={animal.id} />
        <Dislike
            animalId={animal.id}
            modifyAnimalChoices={modifyAnimalChoices}
        />
        <Like
            animalId={animal.id}
            modifyAnimalChoices={modifyAnimalChoices}
        />
    </div>
);

export default Actions;