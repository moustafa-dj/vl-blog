import { array , string , object, number } from "yup";

export const PostSchema = {

    title: string().required('please enter a title'),
    content: string().required('please enter content'),
    category_id: number().required('please select a category'),
    tags: array().min(1,'please select at least one tag')
}