import { reactive } from "vue";

export const authStore = reactive({
    
    auth: !!localStorage.getItem('token'),
    userId : JSON.parse(localStorage.getItem('user_id')),

    isAuthenticated(){
        return  !!localStorage.getItem('token')
    },

    getAuthorization(){
        return localStorage.getItem('token')
    },

    setAuth(state){
        return  this.auth = state
    },

    getUserId()
    {
        return this.userId
    },

    login(token , id){

        localStorage.setItem("token",token);
        this.setUserId(id);
        this.setAuth(true)
    },

    logout()
    {
        localStorage.removeItem('token')
        localStorage.removeItem('user_id')
        this.auth = false
        this.userId = null
    },

    setUserId(id)
    {
        this.userId = id
        localStorage.setItem('user_id',this.userId)
    }

})