<template>
    <div class="content">
        <Post v-for="post in postList" :key="post.id" :post="post"/>
    </div>
</template>
<script>
import axios from 'axios';
import Post from '../../../components/Post.vue';
import { authStore } from '../../../stores/authStore';
import { searchStore } from '../../../stores/searchStore';
export default {

    components:{Post},

    data() {
        return {
            postList : [],
            authStore,
            searchStore
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
                },
                params:{
                    search : searchStore.search
                }
            })
            .then((res)=>{
                this.postList = res.data.records
            }).catch((error)=>{
                console.log(error.response.data)
            })

        },
    },
    watch:{
        'searchStore.search'(value){
            this.getPostsList()
        }
    }
}
</script>
<style>
    .content {
        margin-top: 100px;
    }
</style>