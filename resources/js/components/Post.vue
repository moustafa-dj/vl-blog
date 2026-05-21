<template>
    <div class="border border-[#e5e7eb] rounded-xl">
        <div class="p-3">
            <div class="w-8 h-8 rounded-full overflow-hidden border border-gray-300 mt-2">
                <img
                    v-if="post?.user?.cover"
                    :src="getImgUrl(post.user.cover)"
                    class="w-full h-full object-cover"
                />
                <img
                    v-else
                    src="../assets/images/noProfile.webp"
                    class="w-full h-full object-cover"
                />
            </div>
            <h1 class="block w-full max-h-5 mt-4 text-xl font-bold">
                <router-link :to="{name:'post-details',params:{'id':post.id}}">
                    {{ post.title }}
                </router-link>
            </h1>
        <div class="max-h-10 min-h-10 flex content-start mt-4 mb-2">
            <span v-for=" tag in post.tags" :key="tag.id"
            class="border border-[rgba(77_96_138/0.21)] mr-2 p-1 rounded-lg text-sm h-7 text-[rgba(77_96_138/0.21)]">
                #{{ tag.name }}
            </span>
        </div>
            <!-- <router-link :to="{name:'edit-post' ,params:{'id': post.id}}" 
                            class="edit-link" 
                            v-if="isAuthenticated  && post.user?.id === userId"
            >
                ✏️ Edit
            </router-link>

            <button
                v-if="isAuthenticated  && post.user?.id === userId"
                class="delete-btn"
                @click="onDelete"
            >Delete
            </button> -->
        </div>

        <div class="h-50 overflow-hidden">
            <img :src="getImgUrl(post.cover)" alt="">
        </div>
        <div class="p-2">
            <p>
                <router-link :to="{name:'post-details',params:{'id':post.id}}">
                    <span>
                        💬
                    </span>
                    {{ post.comments.length }}
                </router-link>
            </p>
        </div>
    </div>
</template>
<script setup>
import axios from 'axios';
import { authStore } from '../stores/authStore';
import { ref } from 'vue';
import { computed } from 'vue';
import { useToast } from '../Composables/useToast';
import { usePost } from '../Composables/usePost';

    const props = defineProps({
        post: {
            type: Object,
            required: true
        }
    })

    const toast = useToast()
    const {deletePost , loading , error} = usePost()
    const commentList = ref([])

    const emits = defineEmits(['delete-post'])

    const postId = () => {
        return props.post.id
    }

    const onDelete = async () => {
        deletePost(postId())
        emits('delete-post')
    }

    const isAuthenticated = computed(()=>{
        return authStore.auth
    })


    const userId = computed(()=>{
        return authStore.getUserId()
    })

    const shortenContent = computed(()=>{
        return props.post.content.substr(0.30) + '...'
    })

    function getImgUrl(cover)
    {
        return 'file/'+cover
    }
    
    // async function deletePost()
    // {
    //     try{
    //         const res = await axios.delete('/api/v1/user/posts/'+props.post.id,{
    //             headers:{
    //                 'Authorization': `Bearer ${authStore.getAuthorization()}`,
    //                 "Content-Type":"application/json"
    //             },
    //         })

    //         emits('delete-post')

    //         toast.success('post deleted successfully');

    //     }catch(error)
    //     {
    //         console.log(error.response.data)
    //     }
    // }
</script>
<style>



</style>