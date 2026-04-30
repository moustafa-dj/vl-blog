import { ref } from "vue";
import { api } from "../services/api"
import { authStore } from "../stores/authStore";

export function useFetch(
    url,
    requireAuth
){

    const loading = ref(false);
    const error = null;
    const data = ref([])

    const fetch = async () => {
        loading.value = true
        let res = null;
        try{
            if(requireAuth){
                res = await api.get(url , {
                    headers: {
                        'Authorization': `Bearer ${authStore.getAuthorization()}`
                    }
                })
            }else{
                res = await api.get(url)
            }
            data.value = res.data.records
        }catch(err){
            console.log(error.response?.data?.message ?? 'Something went wrong')
        }
    }

    return  {data , fetch ,  loading , error}
}