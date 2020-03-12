import React from 'react';
import ReactDOM from 'react-dom'
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";

import 'bootstrap/dist/css/bootstrap.css';

import "./index.css";
import {Bookmarks} from "./pages/Bookmarks";
import MainPage from "./pages/MainPage/MainPage";
import {SignIn} from "./pages/SignIn";
import {SignUp} from "./pages/SignUp";
import {FourOhFour} from "./pages/FourOhFour";

const Routing = () => (
	<>

		<BrowserRouter>
			<div>
				<Switch>
					<Route exact path="/bookmarks" component={Bookmarks}/>
					<Route exact path="/main-page" component={MainPage}/>
					<Route exact path="/sign-up" component={SignUp}/>
					<Route exact path="/" component={SignIn}/>
					<Route component={FourOhFour}/>
				</Switch>
			</div>
		</BrowserRouter>

	</>
);

ReactDOM.render(<Routing/>, document.querySelector('#root'));