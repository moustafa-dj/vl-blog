<template>
    <div class="nav">
        <div class="container">
            <div class="nav-content">
                <ul>
                    <li><router-link :to="{name:'home'}">Home</router-link></li>
                    <li><router-link :to="{name:'posts'}">Posts</router-link></li>
                    <li><router-link :to="{name:'add-post'}" v-if="isAuthenticated">Add Post</router-link></li>
                </ul>
                <div class="search">
                    <form action="" @submit.prevent="search">
                        <input type="search" placeholder="...search" v-model="searchQuery">
                    </form>
                </div>
                <router-link to="/" @click.prevent="logout" v-if="isAuthenticated">Logout</router-link>
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
                searchQuery:null
            }

        },
        methods: {
            async logout(){
                const res = await axios.post('/api/v1/user/logout',{},{
                    headers:{
                        'Authorization': `Bearer ${localStorage.getItem('token')}`,
                        "Content-Type":"application/json"
                    }
                })
                .then((res)=>{
                    authStore.logout()
                    this.$router.push({name:"home"})
                }).catch((rej)=>{
                    console.log(res.response.data);
                })
            },

            search() {
                this.$router.push({ name: 'search', query: { q: this.searchQuery } })
            }
        },

        computed:{
            isAuthenticated()
            {
                  return authStore.auth
            }
        }

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
    margin: 10px;
}
.search input {
    background-color: #eee;
    outline: none;
    border-radius: 5px;
    padding: 7px;
    width: 500px;
}
</style>