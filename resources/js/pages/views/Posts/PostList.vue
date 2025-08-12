<template>
    <div class="container">
        <div class="content" v-if="postList.length">
            <Post v-for="post in postList" :key="post.id" :post="post" @delete-post="getPostsList"/>
        </div>
        <div v-else>
            <h4>No poasts available</h4>
        </div>
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
        },
    }
}
</script>
<style scoped>
.container {
    max-width: 1000px;
    margin: auto;
}

.content {
    margin-top: 100px;
    display: flex;
    flex-wrap: wrap; /* Allow multiple rows */
    gap: 20px; /* spacing between posts */
    justify-content: space-between;
}

/* Make each post take 1/3 of the row minus the gap */
.content .post {
    flex: 1 1 calc(33.333% - 20px); /* 3 posts per row with spacing */
    max-width: calc(33.333% - 20px);
    box-sizing: border-box;
}

</style>