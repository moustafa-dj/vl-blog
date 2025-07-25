<template>
  <div class="comment-list">
    <div v-for="comment in commentList" :key="comment.id" class="comment-item">
      <div class="comment-header">
        <span class="comment-user">{{ comment.user.name }}</span>
      </div>
      <div class="comment-body">
        <p class="comment-content">{{ comment.content }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { authStore } from '../stores/authStore';

export default {

    props:['post','refreshKey'],
    data(){
        return {
            commentList:[],
        }
    },

    methods: {

        async getComments()
        {
            try{
                const res = await axios.get('/api/v1/user/comments',{
                    headers:{
                        'Authorization': `Bearer ${authStore.getAuthorization()}`,
                    },
                    params:{
                        post_id: this.post.id
                    }
                })

                this.commentList = res.data.records
                console.log(this.commentList)

            }catch(error){

            }
        }
    },
    mounted(){
        this.getComments()
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
.comment-item {
  border-bottom: 1px solid #e5e7eb;
  padding: 1rem;
  margin-bottom: 1rem;
}

.comment-header {
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 0.25rem;
}

.comment-user {
  font-size: 0.95rem;
  color: #111827;
}

.comment-content {
  font-size: 0.95rem;
  color: #374151;
  line-height: 1.4;
}
</style>
