import React from "react"

import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Card from "react-bootstrap/Card";
import Form from "react-bootstrap/Form";
import InputGroup from "react-bootstrap/InputGroup";
import FormControl from "react-bootstrap/FormControl";
import Button from "react-bootstrap/Button";

const Splash = () => {
	return (
		<>
			<Container>
				<main className="text-center mt-10">
				<h1>P.A.W.S.</h1>
				<h3>Pet Adoption With Software</h3>
					<Button variant="primary" type="link"><a href="sign-in">Enter</a></Button>
				</main>
			</Container>

			</>
	)
}

export default Splash;