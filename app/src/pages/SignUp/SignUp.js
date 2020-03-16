import React from "react"

import {SignUpForm} from "./SignUpForm";

import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";



const SignUp = () => {
	return (
		<>
			<main>
				<Container fluid="true" className="py-5">
					<Row>
						<Col>
							<Card bg="transparent" className="border-0 rounded-0">
								<Card.Header>
									<h3 className="text-center">Sign Up!</h3>
								</Card.Header>
								<Card.Body>
									<SignUpForm/>
								</Card.Body>
							</Card>
						</Col>
					</Row>
				</Container>
			</main>
		</>
	)
};

export default SignUp;