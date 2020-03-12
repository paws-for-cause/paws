import React from 'react';
import ReactDOM from 'react-dom'
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";

import 'bootstrap/dist/css/bootstrap.css';

import "./index.css";
import {Bookmarks} from "./shared/components/NavBar";
import {MainPage} from "./pages/home/Home";
import {SignIn} from "./pages/about/About";
import {SignUp} from "./pages/sign-up/Posts";
import {FourOhFour} from "./pages/four-oh-four/FourOhFour";

const Routing = () => (
	<>

		<BrowserRouter>
			<div>
				<Switch>
					<Route exact path="/" component={SignIn}/>
					<Route exact path="/sign-up" component={SignUp}/>
					<Route exact path="/main-page" component={MainPage}/>
					<Route exact path="/bookmarks" component={Bookmarks}/>
					<Route component={FourOhFour}/>
				</Switch>
			</div>
		</BrowserRouter>

	</>
);

ReactDOM.render(<Routing/>, document.querySelector('#root'));