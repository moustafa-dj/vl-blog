<template>
    <div class="post">
        <div class="cover">
            <img :src="getImgUrl(post.cover)" alt="">
        </div>
        <div class="post-header">
            <h5>
                <router-link :to="{name:'post-details',params:{'id':post.id}}">
                    {{ post.title }}
                </router-link>
            </h5>
            <router-link :to="{name:'edit-post' ,params:{'id': post.id}}" 
                            class="edit-link" 
                            v-if="isAuthenticated  && post.user?.id === userId"
            >
                ✏️ Edit
            </router-link>

            <button
                v-if="isAuthenticated  && post.user?.id === userId"
                class="delete-btn"
                @click="deletePost"
            >Delete
            </button>
        </div>
        <p>
            {{shortenContent}}
        </p>
        <div class="tags">
            <span v-for=" tag in post.tags" :key="tag.id">
                #{{ tag.name }}
            </span>
        </div>
        <div class="stats">
            <p>
                <router-link :to="{name:'post-details',params:{'id':post.id}}">
                    <span>
                        💬
                    </span>
                    {{ post.comments.length }}
                </router-link>
            </p>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import { authStore } from '../stores/authStore';

export default {
    props: [
        'post',
    ],
    emits:[
        'delete-post'
    ],
    data(){
        return {
            commentList:[],
            authStore
        }
    },

    computed:{
        isAuthenticated (){
            return authStore.auth
        },
        userId(){
            return authStore.userId
        },
        shortenContent(){
            return this.post.content.substr(0,30) + '...'
        }
    },
    methods:{
        getImgUrl(cover)
        {
            return 'file/'+cover
        },
    
        async deletePost()
        {
            try{
                const res = await axios.delete('/api/v1/user/posts/'+this.post.id,{
                    headers:{
                        'Authorization': `Bearer ${authStore.getAuthorization()}`,
                        "Content-Type":"application/json"
                    },
                })

                this.$emit('delete-post')

            }catch(error)
            {

            }
        }
    },
}
</script>
<style>
    .post {
        height: 400px;
        max-width: 500px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        background-color: #fafaf9;
        transition: transform 0.2s;
        margin-bottom: 20px;
        border: 1px solid rgba(77, 96, 138, 0.21);
    }

    .post:hover {
        transform: translateY(-5px);
    }

    .post .cover {
        height: 150px;
        overflow: hidden;
    }

    .post .cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .post h5 {
        margin: 12px;
        font-size: 18px;
        font-weight: 600;
        color: #111827;
    }

    .post p {
        margin: 0 12px 12px 12px;
        font-size: 14px;
        color: #4b5563;
        line-height: 1.5;
    }
    .comment-list{
        padding: 0 20px;
    }

    .post-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 12px;
    }

    .edit-link {
        font-size: 14px;
        background-color: #f3f4f6;
        color: #2563eb;
        padding: 6px 12px;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .edit-link:hover ,.delete-btn:hover{
        background-color: #e0e7ff;
        color: #1e3a8a;
    }
    .delete-btn {
        font-size: 14px;
        background-color: #f3f4f6;
        color: #2563eb;
        padding: 6px 12px;
        border-radius: 8px;
        text-decoration: none;
        transition: background-color 0.2s ease, color 0.2s ease;
        cursor: pointer;
    }
    .tags{
        margin-top: 10px;
        padding: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* consistent spacing between posts */
        justify-content: flex-start; /* align posts to the left */
    }
    .tags span{
        border-radius: 15%;
        padding: 8px;
        border: 1px solid rgba(77, 96, 138, 0.21);
        font-size: 13px;
    }



    .stats{
        margin-top: 10px;
        padding: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* consistent spacing between posts */
        justify-content: flex-start; /* align posts to the left */
    }
    .stats span{
        border-radius: 15%;
        padding: 8px;
        font-size: 20px;
        vertical-align: middle;
    }

</style>