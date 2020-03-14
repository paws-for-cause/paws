import React from 'react';
import Actions from '../../components/Actions';
import Container from "react-bootstrap/Container";

const Animal = ({ animal, modifyAnimalChoices }) => {
    const { name, breed, gender, image } = animal;

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

            <Actions
                animal={animal}
                modifyAnimalChoices={modifyAnimalChoices}
            />
           </Container>
        </>
    );
};

export default Animal;