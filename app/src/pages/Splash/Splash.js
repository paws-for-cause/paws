import React from "react"

import Container from "react-bootstrap/Container";
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