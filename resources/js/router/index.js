import { createRouter , createWebHistory } from "vue-router";
const routes = [
    {path:'/login' , name:'login' , component:()=>import('../pages/auth/Login.vue')},
    {path:'/' , name:'home' , component:()=>import('../pages/views/Posts/PostList.vue')},
    {path:'/posts',name:'posts',component:()=>import('../pages/views/Posts/MyPosts.vue'),
        meta:{
            requiresAuth:true
        }
    },
    {path:'/add-post',name:'add-post',component:()=>import('../pages/views/Posts/AddPost.vue')}
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

