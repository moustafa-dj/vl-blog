import { reactive } from "vue";

export const authStore = reactive({
    
    auth: !!localStorage.getItem('token'),

    isAuthenticated(){
        return  this.auth =  !!localStorage.getItem('token')
    },

    getAuthorization(){
        return localStorage.getItem('token')
    },

    setAuth(state){
        return  this.auth = state
    }

})