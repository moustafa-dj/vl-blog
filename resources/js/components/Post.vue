<template>
    <div class="post">
        <div class="cover">
            <img :src="getImgUrl(post.cover)" alt="">
        </div>
        <h5>{{post.title}}</h5>
        <p>
            {{post.content}}
        </p>
        <CommentForm :post="this.post" @commentAdded="refreshKey=Date.now()"/>
        <Comment :post="this.post" :refreshKey="this.refreshKey" />
    </div>
</template>
<script>
import Comment from './Comment.vue';
import CommentForm from './Forms/Comment/CommentForm.vue';

export default {
    props: [
        'post',
    ],
    data(){
        return {
            refreshKey: Date.now()
        }
    },
    components:{
        CommentForm,
        Comment
    },

    methods:{
        getImgUrl(cover)
        {
            return 'file/'+cover
        }
    }
}
</script>
<style>
    .post {
        width: 100%;
        max-width: 500px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        background-color: #fff;
        transition: transform 0.2s;
        margin-bottom: 20px;
    }

    .post:hover {
        transform: translateY(-5px);
    }

    .post .cover {
        height: 250px;
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
</style>