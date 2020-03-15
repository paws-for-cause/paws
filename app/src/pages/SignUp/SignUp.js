import React from "react"
import * as Yup from 'yup'
import { httpConfig } from '../../shared/utils/http-config'
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import Form from "react-bootstrap/Form";
import InputGroup from "react-bootstrap/InputGroup";
import FormControl from "react-bootstrap/FormControl";
import Button from "react-bootstrap/Button";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import './SignUp.css'

export function PostForm () {
	const initailValues = {
		postUserFirstName: "",
		postUserLastName: "",
		postUserAge:"",
		postUserEmail:"",
		postUserPhone:"",
		postUserPassword:"",
		postConfirmUserPassword:""
	}

	const validator = Yup. object().shape({

		postUserFirstName: Yup.string().required('First name is required').max(32, ' Post Content is to long'),

		postUserLastName: Yup.string().required('Last name is required').max(32, ' Post Content is to long'),

		postUserAge: Yup.string().required('User Age is required').max(6, ' Post Content is to long'),

		postUserEmail: Yup.string().required('User Email is required').max(64, ' Post Content is to long'),

		postUserPhone: Yup.string().required('Phone number is required').max(16, 'Phone number is invalid'),

		postUserPassword: Yup.string().required('Password is required').max(64, 'Password is too long'),

	})

	const submit = (values, { resetForm, setStatus }) => {
		httpConfig.post('/apis/post', values).then(response => {
			console.log(response)
			let { message, type, status } = response
			if (status === 200) {
				resetForm()
			}
			console.log(message)
			setStatus({ message, type})
		})
	}
}

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

// todo setup up reducers
// applyMiddleware and CombineReduces
// pass store into index.js
// reducer for all api that GETs data (has cases for actions.)


//todo define actions
//"wired posts commit"
//post.actions.js
