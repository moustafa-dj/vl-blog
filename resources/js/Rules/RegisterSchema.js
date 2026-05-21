import * as yup from 'yup';

export const RegisterSchema = {
    name: yup.string().required('please enter your name'),
    username: yup.string().required('please enter your user name'),
    email: yup.string().required('please enter your email').email(),
    password : yup.string().required('please enter your password').min(8),
    password_confirmation : yup.string().required('please confirm your password').min(8)
}