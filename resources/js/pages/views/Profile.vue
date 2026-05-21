<template>
<div class="max-w-[1000px] m-auto min-w-[1000px]">
  <div class="flex gap-5 mt-[50px] w-full">

    <div class="basis-[70%] flex-shrink-0 border border-[#e5e7eb] rounded-xl min-h-[500px]">
      <div class="mb-20">
        <div
          class="h-40 w-full bg-center relative bg-cover rounded-t-xl"
          :style="{
            backgroundImage: `url(${
              profile?.profileInfo?.cover ? getImgUrl(profile.profileInfo.cover) : placeholder
            })`
          }"
        >
          <div class="absolute -bottom-10 left-6 w-30 h-30 border border-none rounded-xl">
            <img
              v-if="profile?.profileInfo"
              :src="getImgUrl(profile?.profileInfo?.image)"
              class="w-full h-full border-4 border-white  object-cover"
            />
            <img v-else src="../../assets/images/noProfile.webp" alt=""
            class="w-full h-full border-4 border-white  object-cover"
            >
          </div>
        </div>
      </div>
      <div class="p-3">
        <h2 class="text-black font-bold text-[20px]">{{ profile?.name }}</h2>
        <p>{{ profile?.profileInfo?.headline}}</p>
        <span>@{{ profile?.username }} . </span>
        <span>
          joined - {{ new Date(profile?.joined_at).toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric'
          }) }}
        </span>
        <div class="pt-[100px] py-[30px] grid grid-cols-2 gap-5 border-b border-b-gray-300">
            <Post v-for="post in profile?.posts" :key="post.id" :post="post"
            class=""/>
        </div>
      </div>
    </div>

    <div class="basis-[30%] flex-shrink-0 border border-[#e5e7eb] rounded-xl max-h-30">
      <div class="profile-card">
        <img :src="getImgUrl(profile?.user?.profile)" class="profile-img" />
        <h3 class="name">{{ profile?.user?.name }}</h3>
        <p class="bio">{{ profile?.bio }}</p>
        <div class="stats">
          <span><b>{{ profile?.nb_followers }}</b> Followers</span>
          <span><b>{{ profile?.nb_following }}</b> Following</span>
        </div>
        <button class="edit-btn">Edit profile</button>
      </div>
    </div>

  </div>
</div>
</template>

<script setup>
import axios from 'axios';
import { authStore } from '../../stores/authStore';
import { ref , onMounted} from 'vue';
import { useRoute } from 'vue-router';
import placeholder from '../../assets/images/Placeholder 01.webp';
import { watch } from 'vue';
import Post from '../../components/Post.vue';

  const profile = ref();
  const route = useRoute();

  async function me(){ 
      try{
          const res = await axios.get('/api/v1/user/profiles/user/'+route.params.username,
          { 
              headers:{ 
                  'Authorization':` Bearer ${authStore.getAuthorization()}`,
                  "Content-Type":"application/json" 
              } 
          })
          profile.value = res.data.record
          console.log(res.data)

      }catch(error){
          console.log(error.response.data)
      }
  }
  function getImgUrl(cover) {
    return "/file/" + cover;
  }

  onMounted( () => {
  })

  watch(() => route.params.username , 
   (username) => {
      me()
  },
  {immediate: true}
  )
</script>

<style scoped>

</style>
