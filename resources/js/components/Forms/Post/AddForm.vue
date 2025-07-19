<template>
    <form class="post-form" @submit.prevent="addPost">
        <input type="text" v-model="post.title">
        <textarea name="content" id="" v-model="post.content"></textarea>
        <select name="category_id" id="" v-model="post.category_id">
            <option v-for="category in categories" :key="category.id" :value="category.id">
                {{category.name}}
            </option>
        </select>
        <select name="tags[]" id="" v-model="post.tags" multiple>
            <option v-for="tag in tagsList" :key="tag.id" :value="tag.id">
                {{tag.name}}
            </option>
        </select>
        <input type="file" name="cover" id="" @change="uploadCover">
        <button type="submit">Add</button>
    </form>
</template>

<script>
import axios from 'axios';
import { authStore } from '../../../stores/authStore';
export default {
    data(){
        return {
            post:{
                title:null,
                content:null,
                cover:null,
                category_id:null,
                tags:[]
            },
            categories:[],
            tagsList:[],
            authStore
        }
    },
    mounted(){
        this.getCategoyList(),
        this.getTagsList()
    },
    methods:{
        async getCategoyList()
        {
            const res = await axios.get('api/v1/user/categories',{
                headers:{
                    'Authorization': `Bearer ${authStore.getAuthorization()}`,
                    "Content-Type":"application/json"
                }
            }).then((res) => {
                this.categories = res.data.records
            }).catch((error)=>{
                console.log(error.response.data)
            })
        },
        async addPost(){
            const postData = new FormData();
            postData.append('cover',this.post.cover)
            postData.append('title',this.post.title)
            postData.append('content',this.post.content)
            postData.append('category_id',this.post.category_id)
            this.post.tags.forEach((e , i) => {
                postData.append(`tags[${i}]`,e)
            })

            const res = await axios.post('api/v1/user/posts',
                postData,{
                headers:{
                    'Authorization': `Bearer ${authStore.getAuthorization()}`,
                }
            },
            ).catch((error)=>{
                console.log(error.response.data)
            })
        },
        async getTagsList(){
            try{
                const res = await axios.get('api/v1/user/tags',{
                    headers:{
                        'Authorization': `Bearer ${authStore.getAuthorization()}`,
                        "Content-Type":"application/json"
                    }
                })
                this.tagsList = res.data.records
            }catch(error){
                console.log(error.response.data)
            }
        },
        uploadCover(event){
            this.post.cover = event.target.files[0]
        }

    }
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
