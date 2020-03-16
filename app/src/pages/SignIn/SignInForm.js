import React, {useState} from "react";
import {httpConfig} from "../../shared/utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik";

import {SignInFormContent} from "./SignInFormContent";

export const SignInForm = () => {

	const [status, setStatus] = useState(null);

	const signIn = {
		postUserEmail: "",
		postUserPassword: "",
		postConfirmUserPassword: ""
	};

	const validator = Yup.object().shape({

		postUserEmail: Yup.string().required('User Email is required').max(64, ' Post Content is to long'),

		postUserPassword: Yup.string().required('Password is required').max(64, 'Password is too long'),

	})

	const submitSignIn = (values, {resetForm, setStatus}) => {
		httpConfig.post('/apis/post', values)
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200) {
					resetForm()
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
