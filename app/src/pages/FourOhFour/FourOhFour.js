import React from "react"
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import './FourOhFour.css'

const FourOhFour = () => {
   return (
      <>
         <div className="bg">
         <main className="d-flex py-5" >
               <Row className="ml-auto">
                  <Col>
                     <h1 className="text-white">404 Error: CaN I HaZ PaGe?</h1>
                  </Col>
               </Row>
         </main>
         </div>
      </>
   )
};

export default FourOhFour;