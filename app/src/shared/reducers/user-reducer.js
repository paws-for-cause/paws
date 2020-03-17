export function userReducer (state = [], action) {
	switch (action.type) {
		case 'GET_USER_BY_USER_ID':
			return action.payload
		default :
			return state
	}
}