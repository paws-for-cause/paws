import React from "react"

import Container from "react-bootstrap/Container";
import Button from "react-bootstrap/Button";
import "./Splash.css"

import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";

import SplashLogo from '../page-images/Paws Image 1.png'

import PawsLogo from '../page-images/logo.png'

const Splash = () => {
	return (
		<>

			<Container className="splash-bg">
				<main>
					<Row>
						<Col sm={4} md={4} lg={12}>
							<a href="sign-in">
								<img src={SplashLogo} className="splash-pets" alt ='Test Page image'/>
							</a>
								<h1 className="splash-text">P.A.W.S.</h1>
								<p>Pet Adoption and Welfare Solutions</p>
						</Col>
					</Row>
					<Button>
						<a className="splash-link" href="sign-in">Enter</a>
					</Button>
				</main>
			</Container>
		</>
	)
};



export default Splash;