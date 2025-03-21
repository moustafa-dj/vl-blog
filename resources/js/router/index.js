import { createRouter , createWebHistory } from "vue-router";
const routes = [
    {path:'/login' , name:'login' , component:()=>import('../pages/auth/Login.vue')},
    {path:'/' , name:'home' , component:()=>import('../pages/Home.vue')}
]

const router = createRouter({
    history:createWebHistory(),
    routes
})

export default router

