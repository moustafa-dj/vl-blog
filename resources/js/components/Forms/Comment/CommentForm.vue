<template>
  <form @submit.prevent="addComent" class="comment-form" v-if="authStore.auth">
    <input
      type="text"
      v-model="content"
      placeholder="Write a comment..."
      class="comment-input"
    />
    <button type="submit" class="comment-send">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5 13l4 4L19 7" />
      </svg>
    </button>
  </form>
</template>
<script>
import axios from 'axios';
import { authStore } from '../../../stores/authStore';

    export default {
        props:['post'],
        emits : ['commentAdded'],
        data(){
            return {
                content:'',
                authStore
            }
        },
        methods:{
            async addComent()
            {
                const commentdata = {
                    post_id: this.post.id,
                    content: this.content
                }

                console.log(commentdata);
                try{
                    const res = await axios.post('api/v1/user/comments',commentdata,{
                        headers:{
                            'Authorization': `Bearer ${authStore.getAuthorization()}`,
                        }
                    })
                    this.content=''
                    this.$emit('commentAdded')
                }catch(error){
                    console.log(error.response.data)
                }

            },
        }
    }
</script>
<style>
  .comment-form {
    display: flex;
    align-items: center;
    width: 90%;
    margin: 1.5rem auto;
    background: #f9f9f9;
    border-radius: 20px;
    padding: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    border: 1px solid rgba(77, 96, 138, 0.21);
    background-color: #eee;
  }

  .comment-input {
    flex: 1;
    border: none;
    outline: none;
    padding: 8px;
    font-size: 1rem;
    border-radius: 999px;
    background: transparent;
  }

  .comment-send {
    background-color: #2563eb;
    border: none;
    color: white;
    padding: 0.1rem 0.3rem;
    border-radius: 99px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease;
  }

  .comment-send:hover {
    background-color: #1e40af;
  }

  .icon {
    width: 20px;
    height: 20px;
  }
</style>