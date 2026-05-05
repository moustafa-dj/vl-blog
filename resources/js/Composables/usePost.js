import { ref } from "vue";
import { PostService } from "../services/PostService";
import { useToast } from './useToast';
import { PostDto } from "../services/Dto/PostDto";
export function usePost(){

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

    const createPost = async (post) => {
        loading.value = true
        error.value = null
        const pyload = PostDto(post)

        try{
            const res = PostService.create(pyload)
            toast.success('post added')
        }catch(error){
            toast.error(error.response?.data?.message ?? 'Something went wrong')
            console.log(error.response?.data?.message);
        }finally{
            loading.value = false
        }
    }

    const updatePost = async (id , post) => { 
        loading.value = true;
        error.value = null
        try{
            const pyload = PostDto(post)
            const res = await PostService.update(id , pyload)
            toast.success('post updated successfully')
        }catch(error){
            toast.error(error.response.data.message)
            console.log(error)
        }finally{
            loading.value = false
        }
    }
    return { postList  ,  fetchPosts , createPost, updatePost, error , loading}
}