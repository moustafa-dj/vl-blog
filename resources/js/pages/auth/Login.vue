<template>
    <div class="login-form">
        <form  method="post">
            <label for="">Email</label>
            <br>
            <input type="text" placeholder="email adress" name="email">
            <br>
            <label for="">Password</label>
            <br>
            <input type="password" placeholder="password" name="password">
            <br>
            <button @click="login">Login</button>
        </form>
    </div>
</template>
<script>
import axios from 'axios';

    export default {
        data(){
            return {
                email:'',
                password:''
            }
        },
        methods:{
            async login() {
                this.loading = true;
                this.error = null;

                try {
                    const response = await axios.post("/api/login", {
                    email: this.email,
                    password: this.password,
                    });

                    // Store token in local storage
                    localStorage.setItem("token", response.data.token);

                    // Redirect user after login
                    this.$router.push("/dashboard");
                } catch (error) {
                    this.error = error.response?.data?.message || "Login failed";
                } finally {
                    this.loading = false;
                }
            },
        }
    }
</script>
<style>
.login-form{
    padding: 20px;
}
input{
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