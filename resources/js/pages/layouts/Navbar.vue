<template>
    <div class="nav">
        <div class="container">
            <div class="nav-content">
                <ul>
                    <li><router-link :to="{name:'home'}">Home</router-link></li>
                    <li><router-link :to="{name:'posts'}">Posts</router-link></li>
                </ul>
                
                <router-link to="/" @click="logout" v-if="authStore.auth">Logout</router-link>
                <router-link to="/login" v-else >Login</router-link>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import { authStore } from '../../stores/authStore';
    export default {

        data(){
            return {
                authStore
            }

        },
        methods: {
            async logout(){
                const $res = await axios.post('/api/v1/user/logout',{},{
                    headers:{
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                        "Content-Type":"application/json"
                    }
                })
                .then((res)=>{
                    localStorage.removeItem('token')
                    authStore.setAuth(false)
                    this.$router.push({name:"home"})
                }).catch((rej)=>{
                    console.log(rej.response.data);
                })
            }
        },

    }
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
    border-bottom: 1px solid #e5e7eb; /* Light gray border */
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
    margin: 10px;
}
</style>