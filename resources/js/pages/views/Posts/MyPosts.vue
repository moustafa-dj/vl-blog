<template>
    <div class="btn">
        <router-link to="/add-post">Add Post</router-link>
    </div>
    <div class="content">
        <Post v-for="post in postList" :key="post.id" :post="post"/>
    </div>
</template>
<script setup>
import axios from 'axios';
import Post from '../../../components/Post.vue';
import { authStore } from '../../../stores/authStore';
import { onMounted, reactive } from 'vue';
import { ref } from 'vue';

    const postList = ref()

    onMounted(() => {
        getPostsList()
    })

    async function getPostsList(){

        try{
            const res = await axios.get('api/v1/user/posts/my-posts',{
                headers:{
                    'Authorization': `Bearer ${authStore.getAuthorization()}`,
                    "Content-Type":"application/json"
                }
            })

            postList.value = res.data.records
        }catch(error){
            console.log(error.response.data)
        }
    }
</script>
<style>
    .content {
        margin-top: 100px;
    }
    .btn{
        width: 100px;
        height: 40px;
        padding: 6px;
        background-color: #57C785;
        color: #fff;
        border-radius: 10px;
        margin-bottom: 30px;
    }
</style>