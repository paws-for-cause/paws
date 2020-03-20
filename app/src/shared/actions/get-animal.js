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

