<template>
    <div class="login-form">
        <form  method="post">
            <label for="">Email</label>
            <br>
            <input type="text" placeholder="email adress" name="email" v-model="email">
            <br>
            <label for="">Password</label>
            <br>
            <input type="password" placeholder="password" name="password" v-model="password">
            <br>
            <button @click.prevent="login">Login</button>
        </form>
    </div>
</template>
<script>
import axios from 'axios';
import { authStore } from '../../stores/authStore';
import { useToast } from 'vue-toastification';

    export default {
        data(){
            return {
                email:'',
                password:'',
            }
        },
        methods:{
            async login() {
                this.loading = true;
                this.error = null;
                const toast = useToast()
                const response = await axios.post("/api/v1/user/login", {
                    email: this.email,
                    password: this.password,
                }).then((response) =>{
                    authStore.login(
                        response.data.token,
                        response.data.user.id
                    )
                    toast.success('login successfull')
                    this.$router.push({name:"home"});
                }).catch((error) => {
                    console.log(error.response.data)
                    toast.error(error.data)
                });
            },
        }
    }
</script>
<style>
.login-form{
    padding: 20px;
}
.login-form input{
    margin: 10px 0;
    border: 1px solid #e5e7eb; /* Light gray border */
    padding: 8px;
    background-color: #fff;
}

button{
    margin-top: 10px;
    background-color: #35b37b;
    color: #fff;
    padding: 8px;
    width: 100%;
    cursor: pointer;
}
</style>