import React from "react"

import {SignInForm} from "./SignInForm";

import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";

import signPets from "../page-images/Paws Image 3.jpg";



const SignIn = () => {
	return (
		<>
			<main>
				<img src= {signPets} alt='Missing Image'/>
				<Container fluid="true" className="py-5">
					<Row>
						<Col>
							<Card bg="transparent" className="border-0 rounded-0">
								<Card.Header>
									<h3 className="text-center">P.A.W.S.</h3>
									<h6 className="text-center">Pet Adoption and Welfare Solutions</h6>
								</Card.Header>
								<Card.Body>
									<SignInForm/>
								</Card.Body>
							</Card>
						</Col>
					</Row>
				</Container>
			</main>
		</>
	)
};

export default SignIn;