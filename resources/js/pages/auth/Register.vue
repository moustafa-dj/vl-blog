<template>
    <div class="flex items-center justify-center w-lg h-lg">
        <Form  method="post" @submit="register" v-slot="{errors}" :validation-schema="RegisterSchema">
            <Field name="name" v-slot="{field,errors}">
                <input 
                    type="text" 
                    placeholder="name"
                    name="name" 
                    v-bind="field"
                    v-model="user.name"
                    class="
                        block mb-4 p-2 border border-transparent
                        outline-none rounded-lg bg-[rgba(173_184_212/0.08)]
                        focus:border-[#e5e7eb]"
                >
            </Field>
            <ErrorMessage class="text-danger" name="name" />

            <Field name="username" v-slot="{field,errors}">
                <input 
                    type="text" 
                    placeholder="user name"
                    name="name" 
                     v-bind="field"
                    v-model="user.username"
                    class="
                        block mb-4 p-2 border border-transparent
                        outline-none rounded-lg bg-[rgba(173_184_212/0.08)]
                        focus:border-[#e5e7eb]"
                >
            </Field>
            <ErrorMessage class="text-danger" name="name" />
            <Field name="email" v-slot="{field,errors}">
                <input 
                    type="text" 
                    placeholder="email"
                    name="email" 
                    v-bind="field"
                    v-model="user.email"
                    class="
                        block mb-4 p-2 border border-transparent
                        outline-none rounded-lg bg-[rgba(173_184_212/0.08)]
                        focus:border-[#e5e7eb]"
                >
            </Field>
            <ErrorMessage class="text-danger" name="email" />
            <Field 
                type="password"
                v-model="password"
                name="password"
                placeholder="password"
                v-slot="{field , errors}"
            >
                <input 
                    type="password"
                    v-model="password"
                    name="password"
                    v-bind="field"
                    placeholder="password"
                    class="block mb-4 p-2 border border-transparent
                     outline-none rounded-lg bg-[rgba(173_184_212/0.08)]
                     focus:border-[#e5e7eb]"
                >
            </Field>
            <ErrorMessage class="text-danger" name="password" />

            <Field 
                type="password"
                v-model="user.password"
                name="password_confirmation"
                placeholder="password"
                v-slot="{field , errors}"
            >
                <input 
                    type="password"
                    v-model="user.password_confirmation"
                    v-bind="field"
                    name="password_confirmation"
                    placeholder="Confirm Password"
                    class="block mb-4 p-2 border border-transparent
                     outline-none rounded-lg bg-[rgba(173_184_212/0.08)]
                     focus:border-[#e5e7eb]"
                >
            </Field>
            <ErrorMessage class="text-danger" name="password_confirmation" />
            <button 
                class="
                    block mt-2 p-2
                    bg-black
                    text-center boder 
                    border-gray-300
                    rounded-lg
                    text-[oklch(98.8%_0.003_106.5)]
                    w-full
                    cursor-pointer
                    "
                >
                <span v-if="loading">...</span>
                <span v-else>Register</span>
            </button>
        </Form>
    </div>
</template>
<script setup>
import axios from 'axios';
import { authStore } from '../../stores/authStore';
import { ref } from 'vue';
import { useRoute , useRouter} from 'vue-router';
import { useToast } from '../../Composables/useToast';
import { Form, Field, ErrorMessage } from 'vee-validate';
import { RegisterSchema } from '../../Rules/RegisterSchema';

const user = ref({
    email:'',
    password:'',
    name:'',
    username:'',
    password_confirmation:''
})
const toast =  useToast();
const router = useRouter();

const loading = ref(false);
const error = ref(null)

async function register() {
    const userData = new FormData();
    userData.append('name',user.value.name)
    userData.append('username',user.value.username)
    userData.append('email' , user.value.email)
    userData.append('password' , user.value.password)
    userData.append('profile',user.value.profile)
    userData.append('password_confirmation' , user.value.password_confirmation)
        loading.value = true
        error.value = null
    try{

        const response = await axios.post('/api/v1/user/register',userData)
        authStore.login(
            response.data.access_token,
            response.data.user.id
        )
        toast.success('register successfull')
        router.push({name:"home"});
    }catch(error){
        console.log(error.response.data.message)
        toast.error(error.response.data.message)
    }finally{
        loading.value = false
    }


}
// function uploadCover(event){
//     user.value.profile = event.target.files[0]
// }
</script>
<style>
    /*background-color: #35b37b;*/


</style>