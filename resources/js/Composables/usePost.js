import { ref } from "vue";
import { PostService } from "../services/PostService";

export function usePost(){

    const postList = ref([])
    const loading = ref(false)
    const error = ref(null)
    const fetchPosts = async ()=> {
        try{
            loading.value = true
            error .value = null
            const res = await  PostService.list()

            postList.value = res.data.records
            
        }catch(err){
            error.value = err
            console.log(error)
        }finally{
            loading.value = false
        }
    }

    return { postList ,  fetchPosts , error , loading}
}