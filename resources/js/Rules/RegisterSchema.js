import * as yup from 'yup';

export const RegisterSchema = {
    email: yup.string().required('please enter your email').email(),
    password : yup.string().required().min(8)
}