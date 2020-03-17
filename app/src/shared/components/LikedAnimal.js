import React from 'react';

const LikedAnimal = ({ animal }) => (
    <div className="liked-animal">
        <div className="liked-animal-image">
            <img
                src={`/images/animals/${animal.image}`}
                alt={`You liked ${animal.name}`}
            />
        </div>
    </div>
);

export default LikedAnimal;