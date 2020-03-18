import React from "react";
import {httpConfig} from "../../shared/utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik";

import {SignUpFormContent} from "./SignUpFormContent";
import {useHistory} from "react-router-dom";

export const SignUpForm = () => {
	const history = useHistory();
	const signUp = {
		userFirstName: "",
		userLastName: "",
		userAge: "",
		userEmail: "",
		userPhone: "",
		userPassword: "",
		userPasswordConfirm: ""
	};

	const validator = Yup.object().shape({

		userFirstName: Yup.string().required('First name is required').max(32, ' User First Name is to long'),

		userLastName: Yup.string().required('Last name is required').max(32, ' User Last Name is to long'),

		userAge: Yup.string().required('User Age is required').max(6, ' User age is to long'),

		userEmail: Yup.string().required('User Email is required').max(64, ' User email is to long'),

		userPhone: Yup.string().required('Phone number is required').max(16, 'Phone number is invalid'),

		userPassword: Yup.string().required('Password is required').max(64, 'Password is too long'),

	})

	const submitSignUp = (values, {resetForm, setStatus}) => {
		httpConfig.post('/apis/sign-up/', values)
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200) {
					resetForm();
					history.push("/sign-in");
					setStatus({message, type});

				}
			});
	};

	return (
		<>
			<Formik
				initialValues={signUp}
				onSubmit={submitSignUp}
				validationSchema={validator}
			>
				{SignUpFormContent}
			</Formik>
		</>
	)
}
