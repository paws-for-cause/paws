import React, {useState} from 'react';
import './App.css'
import {StyleHTMLAttributes, ReactText, WebViewHTMLAttributes, ImgHTMLAttributes, AnimationEvent} from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {Home} from "./pages/Home";

const App = () => {
    const [animals, setAnimals] = useState(data);
    const [likedAnimals, setLikedAnimals] = useState([]);
    const [dislikeUsers, setDislikedUsers] = useState([]);
    const activeUser = 0;

    switch (action) {
        case 'Add_To_Liked_Animal':
            break;
        case 'Add_To_Disliked_Animal':
            break;
        default:
            return animals;
    }

    return (
        <div className = "app">
            <Header>

                {animals[1] ? (
                    <Animal
                        key = {animal[1].id}
                        aniaml = {animals[1]}
                        modifyAnimalChoices = {modifyAnimalChoices}
                        likedAnimals = {likedAnimals}
                        />
                ): (
                    <nextAnimal
                        activeAnimalImage = {animals[activeAnimal.image]}
                    likedAnimals = {likedAnimals}
                    />
                )}
            </Header>


        </div>
    )




ReactDOM.render(<Routing/>, document.querySelector('#root'))};