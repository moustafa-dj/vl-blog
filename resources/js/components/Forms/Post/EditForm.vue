<template>
    <form class="post-form" @submit.prevent="onUpdate">
        <input type="text" v-model="form.title">
        <textarea name="content" id="" v-model="form.content"></textarea>
        <select name="category_id" v-model="form.category_id">
            <option v-for="category in categories" 
                    :key="category.id" 
                    :value="category.id">
                {{category.name}}
            </option>
        </select>
        <select name="tags[]" id="" v-model="form.tags" multiple>
            <option v-for="tag in tagsList" :key="tag.id" :value="tag.id">
                {{tag.name}}
            </option>
        </select>
        <div v-if="form.cover" class="mb-2">
            <img 
                :src="imgUrl" 
                alt="Current cover" 
                class="w-24 h-24 object-cover rounded shadow"
                id="cover-img"
            >
        </div>
        <input type="file" name="cover" id="" @change="uploadCover">
        <button type="submit">
            <span v-if="loading">...</span>
            <span v-else>Submit</span>
        </button>
    </form>
</template>
<script setup>
import { authStore } from '../../../stores/authStore';
import { useRoute} from 'vue-router';
import { ref ,watch , onMounted} from 'vue';
import { usePost } from '../../../Composables/usePost';

    const route = useRoute()

    const {updatePost , loading , error} = usePost()

    const form = ref({
        title:null,
        content:null,
        cover:null,
        category_id:null,
        tags:[]
    })
 
    const onUpdate = () => {
        updatePost(route.params.id , form.value)
    }
    const categories = ref([])
    const tagsList = ref([])
    const imgUrl = ref()

    async function getPost(){
        try{

            const res = await  axios.get('/api/v1/user/posts/'+route.params.id,{
                headers:{
                    'Authorization': `Bearer ${authStore.getAuthorization()}`,
                    "Content-Type":"application/json"
                },
            })
            console.log(res.data.record)
            setForm(res.data.record)

            
        }catch(error){
            console.log(error)
        }
    }
    async function getCategoyList()
    {
        const res = await axios.get('/api/v1/user/categories'
        ).then((res) => {
            categories.value = res.data.records
        }).catch((error)=>{
            console.log(error.response.data)
        })
    }

    async function getTagsList(){
        try{
            const res = await axios.get('/api/v1/user/tags')
            tagsList.value = res.data.records
        }catch(error){
            console.log(error.response.data)
        }
    }

    function setForm(post) {
        form.value = {
            title: post.title,
            content: post.content,
            cover: post.cover,
            category_id: post.category.id,
            tags: post.tags.map(tag => tag.id)
        }
        cover()
    }

    function uploadCover(event){
        const file = event.target.files[0]
        form.value.cover = file
        imgUrlvalue = URL.createObjectURL(file)
    }

    function cover()
    {
        const urlFromCover =   '/file/'+ form.value.cover
        imgUrl.value = urlFromCover
    }
    watch(() => route.params.id ,
        () => {
            getPost()
        },
        {imediat:true}
    )

    onMounted(() => {
        getCategoyList(),
        getTagsList(),
        getPost()
    })

</script>
<style scoped>
    .post-form {
        max-width: 600px;
        margin: 2rem auto;
        padding: 2rem;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .post-form input[type="text"],
    .post-form textarea,
    .post-form select {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #fff;
        transition: border 0.3s ease;
    }

    .post-form input:focus,
    .post-form textarea:focus,
    .post-form select:focus {
        border-color: #007bff;
        outline: none;
    }

    .post-form textarea {
        resize: vertical;
        min-height: 120px;
    }

    .post-form button {
        padding: 12px;
        font-size: 16px;
        border: none;
        background-color: #57C785;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .post-form button:hover {
        background-color: #57C785;
    }
</style>