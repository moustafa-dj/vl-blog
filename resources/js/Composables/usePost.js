import { ref } from "vue";
import { PostService } from "../services/PostService";
import { useToast } from './useToast';
import { PostDto } from "../services/Dto/PostDto";
export function usePost(){

    const postList = ref([])
    const post = ref([])
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

    const fetchPostById = async(id) => {
        try{
            loading.value = true
            error.value = null
            const res = await PostService.findById(id)
            post.value = res.data.record
            console.log(post.user)
            
        }catch(error){
           console.log(error.response?.data?.message);
        }finally{
            loading.value = false
        }
    }
    const createPost = async (post) => {
        loading.value = true
        error.value = null
        const pyload = PostDto(post)

        try{
            const res = await PostService.create(pyload)
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

    const deletePost = async (id) => {
        try{
            loading.value = true
            const res =await PostService.delete(id)
            toast.success('post deleted successfully')
        }catch(error){
            console.log(error.response.data.message)
            toast.error(error.response.data.message)
        }finally{
            loading.value = false
        }
    }
    return { postList  , post,  fetchPosts , createPost, updatePost, deletePost ,fetchPostById, error , loading}
}