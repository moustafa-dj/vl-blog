<template>
    <div class="nav">
        <div class="container">
            <div class="nav-content">
                <ul>
                    <li>
                        <router-link :to="{name:'home'}">
                            VL-BLOG
                        </router-link>
                    </li>
                    <li><router-link :to="{name:'posts'}">Posts</router-link></li>
                    <li><router-link :to="{name:'add-post'}" v-if="isAuthenticated">Add Post</router-link></li>
                </ul>
                <div class="search">
                    <form action="" @submit.prevent="search">
                        <input type="search" placeholder="...search" v-model="searchQ.searchQuery" class="bg-[#f5f8fc]">
                    </form>
                </div>
                <router-link to="/" @click.prevent="logout" v-if="isAuthenticated">Logout</router-link>
                <router-link :to="{name:'profile', params:{'username': userName ?? ''}}" v-if="isAuthenticated">profile</router-link>
                <router-link to="/login" v-else >Login</router-link>
                <router-link to="/register" v-if="!isAuthenticated">Register</router-link>
            </div>
        </div>
    </div>
</template>
<script setup>
    import axios from 'axios';
    import { authStore } from '../../stores/authStore';
    import { computed, reactive } from 'vue';
    import { useRouter } from 'vue-router';

    const searchQ = reactive({ searchQuery:null});

    const router = useRouter();

    async function logout(){

        try{
            await axios.post('/api/v1/user/logout',{},{
                headers:{
                    'Authorization': `Bearer ${localStorage.getItem('token')}`,
                    "Content-Type":"application/json"
                }
            })
            authStore.logout()
            router.push({name:"home"})
        }catch(error){
            console.log(res.response.data);
        }
    }

    function search() {
        router.push({ name: 'search', query: { q: searchQ.searchQuery } })
    }

    const isAuthenticated = computed (()=>{
        return authStore.auth
    })

    const userName =  computed (()=>{
        return authStore.userName
    })
</script>
<style>
.container{
    max-width: 1200px;
    margin: auto;
    z-index: 60000;
}
.nav {
    position: fixed; /* or absolute if needed */
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    border-bottom: 1px solid rgba(77, 96, 138, 0.21);
    background-color: #fff;
}

.nav-content{
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px;
}
.nav-content ul li {
    display: inline;
    margin: 6px;
}
.search input {
    outline: none;
    border-radius: 5px;
    padding: 7px;
    width: 500px;
}
svg{
    height: 30px;
    width: 20px;
}
</style>