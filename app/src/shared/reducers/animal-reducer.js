export function animalReducer (state = [], action) {
	switch (action.type) {
		case 'GET_ALL_ANIMALS':
			return action.payload
		case 'GET_ANIMAL_BY_ANIMAL_ID':
			return [...state, action.payload]
		case 'GET_ANIMAL_BY_LIKE_USER_ID':
			return action.payload
		case "HANDLE_ANIMAL":
			return action.payload;
		default :
			return state
	}
}