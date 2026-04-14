<template>
    <form class="post-form" @submit.prevent="updatePost">
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
        <button type="submit">Update</button>
    </form>
</template>
<script setup>
import { authStore } from '../../../stores/authStore';
import { useToast } from '../../../Composables/useToast';
import { useRoute , useRouter } from 'vue-router';
import { ref ,watch , onMounted} from 'vue';

    const route = useRoute()
    const toast = useToast()

    const form = ref({
        title:null,
        content:null,
        cover:null,
        category_id:null,
        tags:[]
    })

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
    async function updatePost(){
        try{
            const postData = new FormData()
            postData.append('title',form.value.title)
            if(form.cover instanceof File) {
                postData.append('cover', form.value.cover)
            }
            postData.append('content',form.value.content),
            postData.append('category_id',form.value.category_id)
            form.value.tags.forEach((e , i) =>{
                postData.append(`tags[${i}]`,e)
            })

            const res = await  axios.post('/api/v1/user/posts/'+route.params.id,
                postData,
                {
                    headers:{
                        'Authorization': `Bearer ${authStore.getAuthorization()}`,
                    },
                }
            )
            toast.success('post updated successfully')
        }catch(error){
            toast.error(error.data)
            console.log(error)
        }
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