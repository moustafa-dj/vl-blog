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
<script setup>
import axios from 'axios';
import Post from '../../../components/Post.vue';
import { authStore } from '../../../stores/authStore';
import { ref , onMounted} from 'vue';

    const postList = ref([]);


    onMounted(()=>{
        getPostsList()
    })

    async function getPostsList(){

        try{
            const res = await axios.get('api/v1/user/posts',{
                headers:{
                    'Authorization': `Bearer ${authStore.getAuthorization()}`,
                    "Content-Type":"application/json"
                },
            })
            postList.value = res.data.records
        }catch(error){
                console.log(error.response.data)
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
    flex-wrap: wrap;
    gap: 20px; /* consistent spacing between posts */
    justify-content: flex-start; /* align posts to the left */
}

/* Post cards: 3 per row */
.content .post {
    flex: 0 1 calc(33.333% - 20px); /* 3 posts per row with spacing */
    max-width: calc(33.333% - 20px);
    box-sizing: border-box;
}

</style>