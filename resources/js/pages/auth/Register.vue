<template>
    <div class="login-form">
        <form  method="post">
            <label for="">Name</label>
            <br>
            <input type="text" placeholder="user name" name="name" v-model="user.name">
            <br>
            <label for="">Email</label>
            <br>
            <input type="text" placeholder="email adress" name="email" v-model="user.email">
            <br>
            <label for="">Profile</label>
            <br>
            <input type="file" placeholder="" name="profile" @change="uploadCover">
            <br>
            <label for="">Password</label>
            <br>
            <input type="password" placeholder="password" name="password" v-model="user.password">
            <br>
            <label for="">Confirm Password</label>
            <br>
            <input type="password" placeholder="password" name="password_confirmation" v-model="user.password_confirmation">
            <br>
            <button @click.prevent="register">Register</button>
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
                user:{
                    email:'',
                    password:'',
                    name:'',
                    profile:'',
                    password_confirmation:''
                },
                authStore
            }
        },
        methods:{
            async register() {
                const toast =  useToast();
                const userData = new FormData();
                userData.append('name',this.user.name)
                userData.append('email' , this.user.email)
                userData.append('password' , this.user.password)
                userData.append('profile',this.user.profile)
                userData.append('password_confirmation' , this.user.password_confirmation)

                const res = await axios.post('/api/v1/user/register',userData)
                            .then((response) => {
                                authStore.login(
                                    response.data.access_token,
                                    response.data.user.id
                                )
                                toast.success('register successfull')
                                this.$router.push({name:"home"});
                            }).catch((error) => {
                                console.log(error.response.data)
                                toast.error(error.data)
                            });
            },
            uploadCover(event){
                this.user.profile = event.target.files[0]
            }
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