import React, {useEffect} from 'react';
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import './Bookmarks.css';
import Container from "react-bootstrap/Container";
import {UseJwtUserId} from "../../shared/utils/JwtHelpers";
import {useDispatch, useSelector} from "react-redux";
import {getAnimalByLikeUserId} from "../../shared/actions/get-animal";

const Bookmarks = () => {
const userId = UseJwtUserId();
const dispatch = useDispatch();
console.log(userId);
const sideEffects = () => {
    dispatch(getAnimalByLikeUserId(userId))
}
const sideEffectInputs = [userId];
useEffect(sideEffects,sideEffectInputs)
    const animals = useSelector(state=>{
        console.log(state)
        return state.animals? state.animals : []
    })
    console.log(animals)
    return (
        <>
            <Container>
                <Row>
                    <Col>




                        <div className="card">
                            <div className="content">
                                <div className="front">
                                    animalId
                                </div>
                                <div className="back">
                                    animalShelterId!
                                </div>
                            </div>
                        </div>
                    </Col>

                    <Col>
                        <div className="card">
                            <div className="content">
                                <div className="front">
                                    check
                                </div>
                                <div className="back">
                                    Back!
                                </div>
                            </div>
                        </div>
                    </Col>
                </Row>
            </Container>
        </>

    )
};



export default Bookmarks;
