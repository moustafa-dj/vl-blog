<template>
    <form class="post-form" @submit.prevent="updatePost">
        <input type="text" v-model="form.title">
        <textarea name="content" id="" v-model="form.content"></textarea>
        <select name="category_id" id="" v-model="form.category_id">
            <option v-for="category in categories" :key="category.id" :value="category.id"
            :selected ="category.id === form.category_id">
                {{category.name}}
            </option>
        </select>
        <select name="tags[]" id="" v-model="form.tags" multiple>
            <option v-for="tag in tagsList" :key="tag.id" :value="tag.id">
                {{tag.name}}
            </option>
        </select>
        <input type="file" name="cover" id="" @change="uploadCover">
        <button type="submit">Update</button>
    </form>
</template>
<script>
import { authStore } from '../../../stores/authStore';

export default {

    data(){
        return {
            form:{
                title:null,
                content:null,
                cover:null,
                category_id:null,
                tags:[]
            },
            categories:[],
            tagsList:[]
        }
    },
    methods:{
        async getPost(){
            try{

                const res = await  axios.get('/api/v1/user/posts/'+this.$route.params.id,{
                    headers:{
                        'Authorization': `Bearer ${authStore.getAuthorization()}`,
                        "Content-Type":"application/json"
                    },
                })

                this.setForm(res.data.record)
            }catch(error){
                console.log(error)
            }
        },
        async getCategoyList()
        {
            const res = await axios.get('/api/v1/user/categories'
            ).then((res) => {
                this.categories = res.data.records
            }).catch((error)=>{
                console.log(error.response.data)
            })
        },

        async getTagsList(){
            try{
                const res = await axios.get('/api/v1/user/tags')
                this.tagsList = res.data.records
            }catch(error){
                console.log(error.response.data)
            }
        },

        setForm(post) {
            this.form = {
                title: post.title,
                content: post.content,
                cover: post.cover,
                category_id: post.category_id,
                tags: post.tags
            }
        },
        async updatePost(){
            try{
                const postData = new FormData()
                postData.append('title',this.form.title),
                postData.append('cover',this.form.cover),
                postData.append('content',this.form.content),
                postData.append('category_id',this.form.category_id)
                this.form.tags.forEach((e , i) =>{
                    postData.append(`tags[${i}]`,e)
                })

                const res = await  axios.post('/api/v1/user/posts/'+this.$route.params.id,
                    postData,
                    {
                        headers:{
                            'Authorization': `Bearer ${authStore.getAuthorization()}`,
                        },
                    }
                )

                this.setForm(res.data.record)
            }catch(error){
                console.log(error)
            }
        },
        uploadCover(event){
            this.form.cover = event.target.files[0]
        }
    },
    watch:{
        '$router.params.id'(){
            setImmediate(true)
            handler()
            {
                this.getPost()
            }
        }
    },
    mounted(){
        this.getCategoyList(),
        this.getTagsList(),
        this.getPost()
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