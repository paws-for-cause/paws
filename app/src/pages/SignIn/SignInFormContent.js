import React from "react";

import {FormDebugger} from "../../shared/components/FormDebugger";

import Form from "react-bootstrap/Form";
import InputGroup from "react-bootstrap/InputGroup";
import FormControl from "react-bootstrap/FormControl";
import Button from "react-bootstrap/Button";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import './SignIn.css'

import emailIcon from '../page-images/Email Logo.jpg'
import passIcon from '../page-images/Password Logo.jpg'

export const SignInFormContent = (props) => {

	const {
		status,
		values,
		errors,
		touched,
		dirty,
		isSubmitting,
		handleChange,
		handleBlur,
		handleSubmit,
		handleReset
	} = props;

	return (
		<>
			<main className="subg d-flex align-items-center mh-80">
				<Container fluid="true" className="mx-auto">
					<Row>
						<Col>
							<Card bg="transparent" className="border-0 rounded-0">
								<Card.Body>

									<Form onSubmit={handleSubmit}>

										<Form.Group>
											<InputGroup>
												<InputGroup.Prepend>
													<InputGroup.Text>
														<img src={emailIcon} alt='email icon here'/>
													</InputGroup.Text>
												</InputGroup.Prepend>
												<FormControl
													id="userEmail"
													onChange={handleChange}
													onBlur={handleBlur}
													placeholder="Your Email"
													type="email"
													value={values.userEmail}
												/>
											</InputGroup>
											{
												errors.userEmail && touched.userEmail && (
													<div className="alert alert-danger">
														{errors.userEmail}
													</div>
												)
											}
										</Form.Group>

										<Form.Group>
											<InputGroup>
												<InputGroup.Prepend>
													<InputGroup.Text>
														<img src={passIcon} alt='Password icon here'/>
													</InputGroup.Text>
												</InputGroup.Prepend>
												<FormControl
													id="userPassword"
													onChange={handleChange}
													onBlur={handleBlur}
													placeholder="Password"
													type="password"
													value={values.userPassword}
												/>
											</InputGroup>
											{
												errors.userPassword && touched.userPassword && (
													<div className="alert alert-danger">
														{errors.userPassword}
													</div>
												)
											}
										</Form.Group>

										<Form.Group className="text-md-right">
											<Button variant="primary" type="submit">
												<FontAwesomeIcon icon="paw"/>&nbsp;Sign In!
											</Button>
										</Form.Group>
										<FormDebugger {...props}/>
									</Form>
									{console.log(status)}
									{status && (<div className={status.type}>{status.message}</div>)}
								</Card.Body>
							</Card>
						</Col>
					</Row>
				</Container>
			</main>
		</>
	)
};
