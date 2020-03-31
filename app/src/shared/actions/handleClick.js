import React from 'react';
import {httpConfig} from "../utils/http-config";

export const handleClick = (likeAnimalId, isAnimalLiked) => {
	const likeApproved = isAnimalLiked ? 1:0
	httpConfig.post("/apis/like/", {likeAnimalId, likeApproved})
		.then(reply => {

		})
}