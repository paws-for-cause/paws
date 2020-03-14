import React from "react"

import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import Form from "react-bootstrap/Form";
import InputGroup from "react-bootstrap/InputGroup";
import FormControl from "react-bootstrap/FormControl";
import Button from "react-bootstrap/Button";
import './SignIn.css'

import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";

export const SignIn = () => {
	return (
		<>
			<main className="sbg d-flex align-items-center mh-80">
				<Container fluid="true" className="mx-auto my-auto">
					<Row>
						<Col>
							<Card bg="transparent" className="border-0 rounded-0">
								<h2 className="text-center">Sign In</h2>
								<Card.Body>
									<Form>

										<Form.Group>
											<InputGroup>
												<InputGroup.Prepend>
													<InputGroup.Text>
														<FontAwesomeIcon icon="envelope"/>
													</InputGroup.Text>
												</InputGroup.Prepend>
												<FormControl type="email" placeholder="Your Email"/>
											</InputGroup>
										</Form.Group>

										<Form.Group>
											<InputGroup>
												<InputGroup.Prepend>
													<InputGroup.Text>
														<FontAwesomeIcon icon="key"/>
													</InputGroup.Text>
												</InputGroup.Prepend>
												<FormControl type="password" placeholder="Password"/>
											</InputGroup>
										</Form.Group>

										<Form.Group>
											<InputGroup>
												<InputGroup.Prepend>
													<InputGroup.Text>
														<FontAwesomeIcon icon="ellipsis-h"/>
													</InputGroup.Text>
												</InputGroup.Prepend>
												<FormControl type="password" placeholder="Confirm Password"/>
											</InputGroup>
										</Form.Group>

										<Form.Group className="text-center">
											<Button variant="primary" type="submit">
												<FontAwesomeIcon icon="paw"/>&nbsp;Sign-In!
											</Button>
										</Form.Group>
										<p>Don't have an account? Sign up today!</p>
										<Form.Group className="text-center">
											<Button variant="primary" type="link">
												<FontAwesomeIcon icon="paw"/>&nbsp;<a href="sign-up">Sign-Up!</a>
											</Button>
										</Form.Group>

									</Form>
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