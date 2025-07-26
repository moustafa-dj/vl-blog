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
        <div class="comment-list">
            <!-- <Comment v-for="comment in commentList" :key="comment.id" :comment="comment"/> -->
        </div>
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
        background-color: #fff;
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
</style>