import { httpConfig } from '../utils/http-config'

export const getAllAnimals = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/animal/')
	dispatch({ type: 'GET_ALL_ANIMALS', payload: data })
}

export const getAnimalByAnimalId = () => async (dispatch) => {
	const {data} = await httpConfig('/apis/animal')
	dispatch({ type: 'GET_ANIMAL_BY_ANIMAL_ID', payload: data})
}

export const getAnimalByLikeUserId = (likeUserId) => async (dispatch) => {
	const {data} = await httpConfig(`apis/animal/?likeUserId=${likeUserId}`)
	dispatch({ type: 'GET_ANIMAL_BY_LIKE_USER_ID', payload: data})
}

export const getLikeByAnimalIdAndLikeUserId = () => async (dispatch) => {
	const {data} = await httpConfig('apis/like')
	dispatch({ type: "GET_LIKE_BY_ANIMAL_ID_AND_LIKE_USER_ID", payload: data})
}

export const handleAnimal = (likeAnimalId, isAnimalLiked) => (dispatch, getState) => {
	const likeApproved = isAnimalLiked ? 1:0
	const {animals} = getState();
	console.log("is this thing on?")
	const slicedAnimals = animals.slice(1);
	//makes http request to the like api (how we did in the handleClick function)
	httpConfig.post("/apis/like/", {likeAnimalId, likeApproved})
		.then(reply => {});
	//dispatch the handle animal click action
	dispatch({type: "HANDLE_ANIMAL", payload: slicedAnimals})
}