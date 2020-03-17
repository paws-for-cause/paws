export function likeReducer (state = [], action) {
	switch (action.type) {
		case 'GET_LIKE_BY_ANIMAL_ID_AND_LIKE_USER_ID':
			return action.payload
		default :
			return state
	}
}