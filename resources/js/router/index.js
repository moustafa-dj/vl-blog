import { createRouter, createWebHistory } from 'vue-router'
const routes = [
    {path:'/login' , name:'login' , component:()=>import('../pages/auth/Login.vue')},
    {path:'/register' , name:'register',component:()=>import('../pages/auth/Register.vue')},
    {path:'/' , name:'home' , component:()=>import('../pages/views/Posts/PostList.vue')},
    {path:'/posts',name:'posts',component:()=>import('../pages/views/Posts/MyPosts.vue'),
        meta:{
            requiresAuth:true
        }
    },
    {path:'/add-post',name:'add-post',component:()=>import('../pages/views/Posts/AddPost.vue'),
            meta:{
                requiresAuth:true
            }
    },

    {path:'/edit-post/:id',name:'edit-post', component:()=>import('../pages/views/Posts/EditPost.vue'),
        meta:{
            requiresAuth:true
        }
    },

    {path:'/post/:id',name:'post-details',component:()=>import('../pages/views/Posts/PostDetails.vue')},
    { path: '/search', name: 'search', component: () => import('../pages/views/Search.vue') }

]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to,from)=>{
    if(to.meta.requiresAuth && !localStorage.token)
    {
        return {name:'login',query:{redirect:to.fullPath}}
    }
})
export default router

