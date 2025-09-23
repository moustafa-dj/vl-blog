<template>
  <div class="page-container">
    <div class="feed">
      <!-- Left Column: Posts -->
      <div class="posts">
        <div 
          v-for="post in profile?.user?.posts" 
          :key="post.id" 
          class="post-card"
        >
          <div class="post-header">
            <img :src="getImgUrl(profile?.user?.profile)" alt="user avatar" class="avatar">
            <div class="post-meta">
              <h4>{{ profile?.user?.name }}</h4>
              <span class="date">{{ new Date(post.created_at).toDateString() }}</span>
            </div>
          </div>
          <div class="post-body">
            <p class="title">{{ post.title }}</p>
            <p class="content">{{ post.content }}</p>
            <img v-if="post.cover" :src="getImgUrl(post.cover)" class="cover" />
          </div>
        </div>
      </div>

      <!-- Right Column: Profile -->
      <div class="side">
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

<script>
import axios from 'axios';
import { authStore } from '../../stores/authStore';

export default {
  data() {
    return {
      profile: null,
    }
  },
  methods: {
    async me(){ 
        try{
            const res = await axios.get('/api/v1/user/profiles/me',
            { 
                headers:{ 
                    'Authorization':` Bearer ${authStore.getAuthorization()}`,
                    "Content-Type":"application/json" 
                } 
            })
            this.profile = res.data.record
        }catch(error){
            console.log(error.response.data)
        }
    },
    getImgUrl(cover) {
      return "/file/" + cover;
    },
  },
  mounted() {
    this.me();
  },
};
</script>

<style scoped>
.page-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}
.feed {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 20px;
  margin-top: 50px;
}

/* Left: Posts */
.posts {
  flex: 1;
  width: 700px;
}
.post-card {
  background: #fff;
  border-radius: 12px;
  padding: 16px;
  margin-bottom: 20px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}
.post-header {
  display: flex;
  align-items: center;
  margin-bottom: 12px;
}
.avatar {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 10px;
}
.post-meta h4 {
  margin: 0;
  font-size: 15px;
  font-weight: bold;
}
.post-meta .date {
  font-size: 12px;
  color: gray;
}
.post-body .title {
  font-weight: bold;
  margin-bottom: 6px;
}
.post-body .content {
  margin-bottom: 12px;
  color: #444;
}
.cover {
  width: 100%;
  border-radius: 8px;
  margin-top: 10px;
}

/* Right: Profile card */
.side {
  width: 280px;
}
.profile-card {
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  text-align: center;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}
.profile-img {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 12px;
}
.name {
  margin: 0;
  font-size: 18px;
  font-weight: bold;
}
.bio {
  font-size: 14px;
  color: #555;
  margin: 10px 0;
}
.stats {
  display: flex;
  justify-content: space-around;
  font-size: 14px;
  margin-bottom: 12px;
}
.edit-btn {
  background: #1d9bf0;
  color: #fff;
  border: none;
  padding: 8px 16px;
  border-radius: 20px;
  cursor: pointer;
  font-size: 14px;
}
.edit-btn:hover {
  background: #0d8ce0;
}
</style>
