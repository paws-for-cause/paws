import React from 'react';
import ReactDOM from 'react-dom'
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import Bookmarks from "./pages/Bookmarks/Bookmarks";
import {MainPage} from "./pages/MainPage/MainPage";
import SignIn from "./pages/SignIn/SignIn";
import SignUp from "./pages/SignUp/SignUp";
import Splash from "./pages/Splash/Splash";
import FourOhFour from "./pages/FourOhFour/FourOhFour";
import { library } from '@fortawesome/fontawesome-svg-core'
import 'bootstrap/dist/css/bootstrap.css';
import "./index.css";
import{
	faEnvelope,
	faPencilAlt,
	faSignInAlt,
	faSortDown,
	faUserCircle,
	faDog
} from '@fortawesome/free-solid-svg-icons'
import { faKey } from '@fortawesome/free-solid-svg-icons/faKey'
import {applyMiddleware, createStore} from "redux";
import {combinedReducers} from "./shared/reducers";
import thunk from 'redux-thunk'
import { Provider } from 'react-redux'
import axios from "axios";
axios.get("./apis/XSRF/");
library.add(faPencilAlt, faUserCircle, faSortDown, faEnvelope, faSignInAlt, faKey, faDog)

const store = createStore(combinedReducers, applyMiddleware(thunk))
const Routing = (store) => (
	<>
		<Provider store={store}>
		<BrowserRouter>
			<div>
				<Switch>
					{/*<Route exact path="/bookmarks" component={Bookmarks}/>*/}
					<Route exact path="/main-page" component={MainPage}/>
					{<Route exact path="/sign-up" component={SignUp}/>}
					<Route exact path="/sign-in" component={SignIn}/>
					<Route exact path="/" component={Splash}/>
					<Route component={FourOhFour}/>
				</Switch>
			</div>
		</BrowserRouter>
		</Provider>
	</>
);

ReactDOM.render(Routing(store), document.querySelector('#root'));