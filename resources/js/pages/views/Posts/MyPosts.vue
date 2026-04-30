<template>
    <div class="btn">
        <router-link to="/add-post">Add Post</router-link>
    </div>
    <div class="content">
        <Post v-for="post in postList" :key="post.id" :post="post"/>
    </div>
</template>
<script setup>
import Post from '../../../components/Post.vue';
import { onMounted, reactive } from 'vue';
import { useFetch } from '../../../Composables/useFetch';

    const{data: postList , fetch} = useFetch(
        'api/v1/user/posts/my-posts',
        true
    )
    onMounted(() => {
        fetch()
    })

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