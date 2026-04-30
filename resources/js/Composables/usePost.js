import { ref } from "vue";
import { PostService } from "../services/PostService";
import { useToast } from './useToast';
export function usePost(post = null){

    const postList = ref([])
    const loading = ref(false)
    const error = ref(null)
    const toast = useToast()

    const fetchPosts = async ()=> {
        try{
            loading.value = true
            error.value = null
            const res = await  PostService.list()
            postList.value = res.data.records
            
        }catch(err){
            error.value = err
            console.log(error)
        }finally{
            loading.value = false
        }
    }

    const createPost = async () => {
        loading.value = true
        error.value = null
        const pyload = new FormData();
        pyload.append('cover',post.value.cover)
        pyload.append('title',post.value.title)
        pyload.append('content',post.value.content)
        pyload.append('category_id',post.value.category_id)
        post.value.tags.forEach((e , i) => {
            pyload.append(`tags[${i}]`,e)
        })

        try{
            const res = PostService.create(pyload)
            toast.success('post added')
        }catch(error){
            toast.error(error.response?.data?.message ?? 'Something went wrong')
        }finally{
            loading.value = false
        }
    }
    return { postList  ,  fetchPosts , createPost, error , loading}
}