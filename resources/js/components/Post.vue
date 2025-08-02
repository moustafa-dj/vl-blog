<template>
    <div class="post">
        <div class="cover">
            <img :src="getImgUrl(post.cover)" alt="">
        </div>
        <div class="post-header">
            <h5>{{ post.title }}</h5>
            <router-link :to="{name:'edit-post' ,params:{'id': post.id}}" class="edit-link" v-if="isAuthunticated">
                ✏️ Edit
            </router-link>
        </div>
        <p>
            {{post.content}}
        </p>
        <CommentForm :post="this.post" @commentAdded="refreshKey=Date.now()"/>
        <div class="comment-list">
            <!-- <Comment v-for="comment in commentList" :key="comment.id" :comment="comment"/> -->
        </div>
    </div>
</template>
<script>
import { authStore } from '../stores/authStore';
import Comment from './Comment.vue';
import CommentForm from './Forms/Comment/CommentForm.vue';

export default {
    props: [
        'post',
    ],
    data(){
        return {
            refreshKey: Date.now(),
            commentList:[]
        }
    },
    components:{
        CommentForm,
        Comment
    },

    mounted(){
        this.getComments()
    },

    computed:{
        isAuthunticated(){
            return authStore.auth
        }
    },
    methods:{
        getImgUrl(cover)
        {
            return 'file/'+cover
        },
        
        async getComments()
        {
            try{
                const res = await axios.get('/api/v1/user/comments',{
                    params:{
                        post_id: this.post.id,
                    }
                })

                this.commentList = res.data.records
                console.log(this.commentList)

            }catch(error){

            }
        }
    },
    watch:{
        refreshKey(){
          console.log('refreshKey changed:', this.refreshKey);
          this.getComments()
        }
    }
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

    .edit-link:hover {
    background-color: #e0e7ff;
    color: #1e3a8a;
    }

</style>