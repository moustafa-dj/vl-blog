<template>
    <Form  class="post-form" @submit.prevent="addPost" :validation-schema="PostSchema" v-slot="{errors}">
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
        <button type="submit">Add</button>
    </Form>
</template>

<script setup>
import axios from 'axios';
import { authStore } from '../../../stores/authStore';
import { useToast } from '../../../Composables/useToast';
import { onMounted, ref } from 'vue';
import { Form , ErrorMessage , Field , defineRule } from 'vee-validate';
import { PostSchema } from '../../../Rules/PostSchema';
    
    const post = ref({
        title:null,
        content:null,
        cover:null,
        category_id:null,
        tags:[]
    })

    const toast =  useToast();
    const categories = ref([])
    const tagsList = ref([])

    onMounted(()=>{
        getCategoyList(),
        getTagsList()
    })
    async function getCategoyList()
    {
        const res = await axios.get('/api/v1/user/categories',{
            headers:{
                'Authorization': `Bearer ${authStore.getAuthorization()}`,
                "Content-Type":"application/json"
            }
        }).then((res) => {
            categories.value = res.data.records

        }).catch((error)=>{
            console.log(error.response.data)
        })
    }
    async function addPost(){
        const postData = new FormData();
        postData.append('cover',post.value.cover)
        postData.append('title',post.value.title)
        postData.append('content',post.value.content)
        postData.append('category_id',post.value.category_id)
        post.value.tags.forEach((e , i) => {
            postData.append(`tags[${i}]`,e)
        })

        const res = await axios.post('/api/v1/user/posts',
            postData,{
            headers:{
                'Authorization': `Bearer ${authStore.getAuthorization()}`,
            }
        },
        toast.success('Post added successfully')
        ).catch((error)=>{
            console.log(this.errors)
            console.log(error.response)
        })
    }
    
    async function  getTagsList(){
        try{
            const res = await axios.get('api/v1/user/tags',{
                headers:{
                    'Authorization': `Bearer ${authStore.getAuthorization()}`,
                    "Content-Type":"application/json"
                }
            })
            tagsList.value = res.data.records
        }catch(error){
            console.log(error.response.data)
        }
    }
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
