import { api } from "./api"
import { authStore } from "../stores/authStore"
export const PostService = {

    async list() {
        return await api.get('api/v1/user/posts')
    },

    async create(pyload){
        return await api.post('/api/v1/user/posts' , pyload ,{
            headers:{
                'Authorization': `Bearer ${authStore.getAuthorization()}`,
            }
        })
    }
}