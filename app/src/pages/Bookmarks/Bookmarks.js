import React from 'react';
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import './Bookmarks.css';
import Container from "react-bootstrap/Container";

const Bookmarks = () => {
    console.log(this)
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


