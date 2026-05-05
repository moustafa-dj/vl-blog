<template class="">
    <div 
    class="login-form w-full 
       flex flex-col"
    >
        <Form  method="post" @submit="login" :validation-schema="LoginSchema" v-slot="{errors}">
            <label for="">Email</label>
            <Field 
                type="email"
                v-model="email"
                as="input"
                name="email"
                class="block bg-gray-300 m-2 p-2"
            >
            </Field>
            <ErrorMessage class="text-danger" name="email" />
            <Field 
                type="password"
                v-model="password"
                name="password"
                placeholder="password"
                class="block bg-gray-300 m-2"
            >
            </Field>
            <ErrorMessage class="text-danger" name="password" />
            <button>Login</button>
        </Form>
    </div>
</template>
<script setup>
import axios from 'axios';
import { authStore } from '../../stores/authStore';
import {ref} from 'vue';
import { useRoute , useRouter } from 'vue-router';
import { useToast } from '../../Composables/useToast';
import { Form, Field, ErrorMessage } from 'vee-validate';
import { LoginSchema } from '../../Rules/LoginSchema';

const email = ref('')
const password = ref('');
const router = useRouter();
let loading = false;
let error = null;
const toast = useToast()

async function  login() {
    loading = true;
    error = null;
    try{
        const response = await axios.post("/api/v1/user/login", {
            email: email.value,
            password: password.value,
        })
        authStore.login(
            response.data.token,
            response.data.user.id,
            response.data.user.username
        )

        toast.success('login sucess')
        router.push({name:"home"});
    }catch(error){
        console.log(error.response.data)
        toast.error('login error')
    }
}
</script>
<style>
.login-form{
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-top: 100px;
}
.login-form input{

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