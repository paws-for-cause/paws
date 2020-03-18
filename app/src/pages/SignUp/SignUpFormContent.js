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
import './SignUp.css'

export const SignUpFormContent = (props) => {

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
															<FontAwesomeIcon icon="user-circle"/>
														</InputGroup.Text>
													</InputGroup.Prepend>
													<FormControl
														name="userFirstName"
														onChange={handleChange}
														onBlur={handleBlur}
														placeholder="Your First Name"
														type="text"
														value={values.userFirstName}
													/>
												</InputGroup>
												{
													errors.userFirstName && touched.userFirstName && (
														<div className="alert alert-danger">
															{errors.userFirstName}
														</div>
													)
												}
											</Form.Group>

											<Form.Group>
												<InputGroup>
													<InputGroup.Prepend>
														<InputGroup.Text>
															<FontAwesomeIcon icon="user-circle"/>
														</InputGroup.Text>
													</InputGroup.Prepend>
													<FormControl
														id="userLastName"
														onChange={handleChange}
														onBlur={handleBlur}
														placeholder="Your Last Name"
														type="text"
														value={values.userLastName}
													/>
												</InputGroup>
												{
													errors.userLastName && touched.userLastName && (
														<div className="alert alert-danger">
															{errors.userLastName}
														</div>
													)
												}
											</Form.Group>

											<Form.Group>
												<InputGroup>
													<InputGroup.Prepend>
														<InputGroup.Text>
															<FontAwesomeIcon icon="user-circle"/>
														</InputGroup.Text>
													</InputGroup.Prepend>
													<FormControl
														id="userAge"
														onChange={handleChange}
														onBlur={handleBlur}
														placeholder="Your Age"
														type="text"
														value={values.userAge}
													/>
												</InputGroup>
												{
													errors.userAge && touched.userAge && (
														<div className="alert alert-danger">
															{errors.userAge}
														</div>
													)
												}
											</Form.Group>

											<Form.Group>
												<InputGroup>
													<InputGroup.Prepend>
														<InputGroup.Text>
															<FontAwesomeIcon icon="envelope"/>
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
															<FontAwesomeIcon icon="phone-rotary"/>
														</InputGroup.Text>
													</InputGroup.Prepend>
													<FormControl
														id="userPhone"
														onChange={handleChange}
														onBlur={handleBlur}
														placeholder="Your Phone Number"
														type="phone"
														value={values.userPhone}
													/>
												</InputGroup>
												{
													errors.userPhone && touched.userPhone && (
														<div className="alert alert-danger">
															{errors.userPhone}
														</div>
													)
												}
											</Form.Group>


											<Form.Group>
												<InputGroup>
													<InputGroup.Prepend>
														<InputGroup.Text>
															<FontAwesomeIcon icon="key"/>
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

											<Form.Group>
												<InputGroup>
													<InputGroup.Prepend>
														<InputGroup.Text>
															<FontAwesomeIcon icon="ellipsis"/>
														</InputGroup.Text>
													</InputGroup.Prepend>
													<FormControl
														id="userPasswordConfirm"
														onChange={handleChange}
														onBlur={handleBlur}
														placeholder="Confirm Password"
														type="password"
														value={values.userPasswordConfirm}
													/>
												</InputGroup>
												{
													errors.userPasswordConfirm && touched.userPasswordConfirm && (
														<div className="alert alert-danger">
															{errors.userPasswordConfirm}
														</div>
													)
												}
											</Form.Group>

											<Form.Group className="text-center">
												<Button variant="primary" type="submit">
													<FontAwesomeIcon icon="paw"/>&nbsp;Join Us!
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
