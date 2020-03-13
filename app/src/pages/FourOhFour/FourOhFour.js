import React from "react"
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import './FourOhFour.css'





const FourOhFour = () => {
   return (
      <>
         <div className="bg">
         <main className="d-flex py-5" >
            <Container fluid="true">
               <Row>
                  <Col>
                     <h1 className="text-light">404 Error: Y U NO FIND?</h1>
                  </Col>
               </Row>
            </Container>
         </main>
         </div>
      </>
   )
};

export default FourOhFour;