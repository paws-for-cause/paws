import {combineReducers} from 'redux'
import {animalReducer} from './animal-reducer'
import {likeReducer} from './like-reducer'
import {shelterReducer} from './shelter-reducer'
import {userReducer} from "./user-reducer";

export const combinedReducers = combineReducers({
	animals: animalReducer,
	shelters: shelterReducer,
	likes: likeReducer,
	user: userReducer

});
