<template>
    <div
        class="w-[600px] m-auto h-screen border-x border-x-[#e5e7eb] mt-[50px]"
    >
        <div class="w-full border-b border-[#e5e7eb] flex items-center justify-center text-black">
            <div class="w-[90%] m-auto py-2 font-bold text-[20px]">
                New Post
            </div>
        </div>
        <div class="pt-[40px] w-[90%] m-auto">
            <Form  class="post-form" @submit="onSubmit" :validation-schema="PostSchema" 
            v-slot="{errors}"
            >
                <Field 
                    type="text"
                    v-model="post.title"
                    name="title"
                    placeholder="Post Title *"
                    class="block w-full px-2 py-3 bg-[#f1f2f3] mx-auto mb-[30px] rounded-xl"
                >
                </Field>
                <ErrorMessage class="text-danger" name="title" />
                <Field name="content" id="" v-model="post.content" as="textarea"
                    class="block w-full px-2 py-3 bg-[#f1f2f3] rounded-xl mx-auto mb-[30px]
                    h-40"
                    placeholder="Share your thoughts"
                ></Field>
                <ErrorMessage class="text-danger" name="content" />
                
                <input type="file" name="cover" id="" @change="uploadCover"
                    class="block w-full px-2 py-3 bg-[#f1f2f3] rounded-xl mx-auto mb-[30px]"
                >
                <div class="w-full mx-auto flex justify-end">
                    <button type="submit" :disabled="loading"
                        class="px-12 py-2 bg-[#ac1de4] rounded-xl text-white font-bold cursor-pointer"
                    >
                        <span v-if="loading">...</span>
                        <span v-else>Post</span>
                    </button>
                </div>
            </Form>
        </div>
    </div>

</template>

<script setup>
import { onMounted, ref } from 'vue';
import { Form , ErrorMessage , Field} from 'vee-validate';
import { PostSchema } from '../../../Rules/PostSchema';
import { usePost } from '../../../Composables/usePost';
import { useFetch } from '../../../Composables/useFetch';
    
   

    const post = ref({
        title:null,
        content:null,
        cover:null,
        category_id:null,
        tags:[]
    })

    const {createPost, loading} = usePost()

    const onSubmit = () =>{
        console.log(post.value)
        createPost(post.value)
    }
    
    function uploadCover(event){
        post.value.cover = event.target.files[0]
    }
</script>
<style scoped>
</style>
