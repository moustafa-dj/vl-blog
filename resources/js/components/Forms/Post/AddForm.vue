<template>
    <Form  class="post-form" @submit="onSubmit" :validation-schema="PostSchema" v-slot="{errors}">
        <Field 
            type="text"
            v-model="post.title"
            name="title"
        >
        </Field>
        <ErrorMessage class="text-danger" name="title" />
        <Field name="content" id="" v-model="post.content" as="textarea"></Field>
        <ErrorMessage class="text-danger" name="content" />
        <Field name="category_id" id="" v-model="post.category_id" as="select">
            <option v-for="category in categories" :key="category.id" :value="category.id">
                {{category.name}}
            </option>
        </Field>
        <ErrorMessage class="text-danger" name="category_id" />
        <select name="tags[]" id="" v-model="post.tags" multiple>
            <option v-for="tag in tagsList" :key="tag.id" :value="tag.id">
                {{tag.name}}
            </option>
        </select>
        <input type="file" name="cover" id="" @change="uploadCover">
        <button type="submit" :disabled="loading">
            <span v-if="loading">...</span>
            <span v-else>Add</span>
        </button>
    </Form>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { Form , ErrorMessage , Field} from 'vee-validate';
import { PostSchema } from '../../../Rules/PostSchema';
import { usePost } from '../../../Composables/usePost';
import { useFetch } from '../../../Composables/useFetch';
    
   

    const post = ref({
        title:null,
        content:null,
        cover:null,
        category_id:null,
        tags:[]
    })

    const {createPost, loading} = usePost()

    const onSubmit = () =>{
        createPost(post.value)
    }
    const{data: categories , fetch: fetchCategories} = useFetch(
        'api/v1/user/categories',
        true
    )

    const{data: tagsList , fetch: fetchTags} = useFetch(
        'api/v1/user/categories',
        true
    )

    onMounted(()=>{
        fetchCategories(),
        fetchTags()
    })

    function uploadCover(event){
        post.value.cover = event.target.files[0]
    }
</script>
<style scoped>
    .post-form {
        max-width: 600px;
        margin: 2rem auto;
        padding: 2rem;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-top: 100px;
    }

    .post-form input[type="text"],
    .post-form textarea,
    .post-form select {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #fff;
        transition: border 0.3s ease;
    }

    .post-form input:focus,
    .post-form textarea:focus,
    .post-form select:focus {
        border-color: #007bff;
        outline: none;
    }

    .post-form textarea {
        resize: vertical;
        min-height: 120px;
    }

    .post-form button {
        padding: 12px;
        font-size: 16px;
        border: none;
        background-color: #57C785;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .post-form button:hover {
        background-color: #57C785;
    }
</style>
