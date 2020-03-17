import { httpConfig } from '../utils/http-config'

export const getUserByUserId = (id) => async dispatch => {

	const {data} = await httpConfig('apis/user/${id}');

	dispatch({type: "GET_USER_BY_USER_ID", payload: data })

};