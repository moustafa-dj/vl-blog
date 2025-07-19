<template>
    <div class="content">
        <Post v-for="post in postList" :key="post.id" :post="post"/>
    </div>
</template>
<script>
import axios from 'axios';
import Post from '../../../components/Post.vue';
import { authStore } from '../../../stores/authStore';
export default {

    components:{Post},

    data() {
        return {
            postList : [],
            authStore
        }
    },
    mounted(){
        this.getPostsList()
    },
    methods:{
        async getPostsList(){

            const res = await axios.get('api/v1/user/posts',{
                headers:{
                    'Authorization': `Bearer ${authStore.getAuthorization()}`,
                    "Content-Type":"application/json"
                }
            })
            .then((res)=>{
                this.postList = res.data.records
            }).catch((error)=>{
                console.log(error.response.data)
            })

        },
    }
}
</script>
<style>
    .content {
        margin-top: 100px;
    }
</style>