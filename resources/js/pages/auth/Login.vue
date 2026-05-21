<template class="">
    <div 
        class="flex justify-center items-center w-lg h-lg"
    >
        <Form  method="post" @submit="login" :validation-schema="LoginSchema" v-slot="{errors}">
            <Field name="email" v-slot="{ field, errors }">
                <input
                    type="email"
                    v-bind="field"
                    v-model="email"
                    placeholder="email"
                    class="block mb-4 p-2 border border-transparent
                    rounded-lg bg-[rgba(173_184_212/0.08)]
                    outline-none
                    focus:border-[#e5e7eb]
                    w-full"
                />
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
                    placeholder="password"
                    class="block mb-4 p-2 border border-transparent
                     outline-none rounded-lg bg-[rgba(173_184_212/0.08)]
                     focus:border-[#e5e7eb]"
                >
            </Field>
            <ErrorMessage class="text-danger" name="password" />
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
                >Login
            </button>
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

</style>