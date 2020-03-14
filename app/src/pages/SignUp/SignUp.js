import React from "react"

import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import Form from "react-bootstrap/Form";
import InputGroup from "react-bootstrap/InputGroup";
import FormControl from "react-bootstrap/FormControl";
import Button from "react-bootstrap/Button";
import './SignUp.css'

import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";

const SignUp = () => {
	return (
		<>
			<main className="subg d-flex align-items-center mh-80">
				<Container fluid="true" className="mx-auto">
					<Row>
						<Col>
							<Card bg="transparent" className="border-0 rounded-0">
								<h2 className="text-center">Sign Up Today!</h2>
								<Card.Body>
									<Form>

										<Form.Group>
											<InputGroup>
												<InputGroup.Prepend>
													<InputGroup.Text>
														<FontAwesomeIcon icon="user"/>
													</InputGroup.Text>
												</InputGroup.Prepend>
												<FormControl type="text" placeholder="Your First Name"/>
											</InputGroup>
										</Form.Group>

										<Form.Group>
											<InputGroup>
												<InputGroup.Prepend>
													<InputGroup.Text>
														<FontAwesomeIcon icon="user"/>
													</InputGroup.Text>
												</InputGroup.Prepend>
												<FormControl type="text" placeholder="Your Last Name"/>
											</InputGroup>
										</Form.Group>

										<Form.Group>
											<InputGroup>
												<InputGroup.Prepend>
													<InputGroup.Text>
														<FontAwesomeIcon icon="user"/>
													</InputGroup.Text>
												</InputGroup.Prepend>
												<FormControl type="text" placeholder="Your Age"/>
											</InputGroup>
										</Form.Group>

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
														<FontAwesomeIcon icon="phone"/>
													</InputGroup.Text>
												</InputGroup.Prepend>
												<FormControl type="phone" placeholder="Your Phone Number"/>
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

										<Form.Group className="text-md-right">
											<Button variant="primary" type="submit">
												<FontAwesomeIcon icon="paw"/>&nbsp;<a href="main-page">Join Us!</a>
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

export default SignUp;