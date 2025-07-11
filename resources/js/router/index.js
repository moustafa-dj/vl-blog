import { createRouter , createWebHistory } from "vue-router";
const routes = [
    {path:'/login' , name:'login' , component:()=>import('../pages/auth/Login.vue')},
    {path:'/' , name:'home' , component:()=>import('../pages/Home.vue')},
    {path:'/posts',name:'posts',component:()=>import('../pages/views/Post.vue'),
        meta:{
            requiresAuth:true
        }
    }
]

const router = createRouter({
    history:createWebHistory(),
    routes
})

router.beforeEach((to,from)=>{
    if(to.meta.requiresAuth && !localStorage.token)
    {
        return {name:'login',query:{redirect:to.fullPath}}
    }
})
export default router

