<script>
    import NavBar from './pages/layouts/NavBar.vue';
    export default {
        components:{
            NavBar
        }
    }
</script>
<template>
    <NavBar/>
    <div>
        <router-view>
        </router-view>
    </div>
</template>
