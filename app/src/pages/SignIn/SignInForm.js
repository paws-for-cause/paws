import React, {useState} from "react";
import {httpConfig} from "../../shared/utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik";

import {SignInFormContent} from "./SignInFormContent";
import {useHistory} from "react-router-dom"
export const SignInForm = () => {

	const [status, setStatus] = useState(null);

	const history = useHistory();
	const signIn = {
		userEmail: "",
		userPassword: ""
	};

	const validator = Yup.object().shape({

		userEmail: Yup.string().required('User Email is required').max(64, ' Post Content is to long'),

		userPassword: Yup.string().required('Password is required').max(64, 'Password is too long'),

	})

	const submitSignIn = (values, {resetForm, setStatus}) => {
		httpConfig.post('/apis/sign-in/', values)
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200) {
					resetForm();
					history.push("/main-page");
					setStatus({message, type});
				}
			});
	};

	return (
		<>
			<Formik
				initialValues={signIn}
				onSubmit={submitSignIn}
				validationSchema={validator}
			>
				{SignInFormContent}
			</Formik>
		</>
	)
}
