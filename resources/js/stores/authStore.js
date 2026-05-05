import { reactive } from "vue";

export const authStore = reactive({
    
    auth: !!localStorage.getItem('token'),
    userId : JSON.parse(localStorage.getItem('user_id')),
    userName: localStorage.getItem('username'),

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

    getUserName()
    {
        return this.userName
    },

    login(token , id , username){

        localStorage.setItem("token",token);
        this.setUserId(id);
        this.setAuth(true);
        this.setUserName(username)
    },

    logout()
    {
        localStorage.removeItem('token')
        localStorage.removeItem('user_id')
        localStorage.removeItem('username')
        this.auth = false
        this.userId = null
    },

    setUserId(id)
    {
        this.userId = id
        localStorage.setItem('user_id',this.userId)
    },

    setUserName(username)
    {
        this.username = username,
        localStorage.setItem('username' , username)
    }
})