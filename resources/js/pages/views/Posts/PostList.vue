<template>
    <div class="max-w-[1200px] m-auto">
        <div class="mt-[100px] grid grid-cols-3 gap-5" v-if="data.length">
            <Post v-for="post in data" :key="post.id" :post="post" @delete-post="fetch" class="bg-[#f5f8fc]"/>
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

    console.log(data.value)
    onMounted(()=>{  
        fetch()
    })
</script>
<style scoped>




</style>