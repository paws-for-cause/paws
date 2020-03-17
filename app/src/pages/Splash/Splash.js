import React from "react"

import Container from "react-bootstrap/Container";
import Button from "react-bootstrap/Button";
import "./Splash.css"

const Splash = () => {
	return (
		<>

			<Container className="splash-bg">
				<main className="splash-main text-center mt-10">
					<h1>P.A.W.S.</h1>
					<h3>Pet Adoption and Welfare Solutions</h3>
					<Button variant="primary" type="link">
						<a className="splash-link" href="sign-in">Enter</a>
					</Button>
				</main>
			</Container>

		</>
	)
}

export default Splash;