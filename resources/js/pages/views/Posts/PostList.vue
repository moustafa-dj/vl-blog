<template>
    <div class="container">
        <div class="content" v-if="data.length">
            <Post v-for="post in data" :key="post.id" :post="post" @delete-post="getPostsList"/>
        </div>
        <div v-else>
            <h4>No poasts available</h4>
        </div>
    </div>
</template>
<script setup>
import Post from '../../../components/Post.vue';
import { ref , onMounted} from 'vue';
import { useFetch } from '../../../Composables/useFetch';

    // const {postList ,  fetchPosts , error , loading} = usePost()
    const{data , fetch} = useFetch(
        'api/v1/user/posts',
        false
    )

    onMounted(()=>{  
        fetch()
    })
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