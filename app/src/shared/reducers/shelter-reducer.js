export function shelterReducer (state = [], action) {
	switch (action.type) {
		case 'GET_SHELTER_BY_SHELTER_ID':
			return action.payload
		default :
			return state
	}
}