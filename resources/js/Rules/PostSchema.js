import { array , string , object, number } from "yup";

export const PostSchema = {

    title: string().required('please enter a title'),
    content: string().required('please enter content'),
    tags: array().min(1,'please select at least one tag')
}