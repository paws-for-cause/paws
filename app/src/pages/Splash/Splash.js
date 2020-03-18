import React from "react"

import Container from "react-bootstrap/Container";
import Button from "react-bootstrap/Button";
import "./Splash.css"

import SplashLogo from '../page-images/Paws Image 1.jpg'

const Splash = () => {
	return (
		<>

			<Container className="splash-bg">
				<main className="splash-main text-center mt-10">
					<h1>P.A.W.S.</h1>
					<h3>Pet Adoption and Welfare Solutions</h3>
					<img src={SplashLogo} alt ='Test Page image'/>
					<Button variant="primary" type="link">
						<a className="splash-link" href="sign-in">Enter</a>
					</Button>
				</main>
			</Container>
		</>
	)
};



export default Splash;