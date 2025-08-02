<template>
   <EditForm/>
</template>
<script>
import axios from 'axios';
import EditForm from '../../../components/Forms/Post/EditForm.vue';

export default {

    components:{
        EditForm
    },

    data(){
        return {
            post:{}
        }
    },
    methods:{
        
    }
}

</script>