import { api } from "./api"
export const PostService = {

    async list() {
        return await api.get('api/v1/user/posts')
    }
}