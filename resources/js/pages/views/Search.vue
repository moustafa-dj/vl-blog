<template>
  <div class="page-container">
    <div class="feed-layout">
      <!-- Left: Posts -->
      <div class="feed">
        <div class="posts" v-if="postList.length">
          <Post v-for="post in postList" :key="post.id" :post="post" />
        </div>
        <div v-else class="empty-state">
          <h4>No posts available</h4>
        </div>
      </div>

      <!-- Right: Sidebar -->
      <aside class="sidebar">
        <section class="widget">
          <h3 class="widget-title">Related tags</h3>
          <div class="tags">
            <!-- tags go here -->
             
          </div>
        </section>

        <section class="widget">
          <h3 class="widget-title">Related sources</h3>
          <div class="sources">
            <!-- sources go here -->
          </div>
        </section>
      </aside>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import Post from "../../components/Post.vue";
import { ref ,watch } from "vue";

import { useRoute , useRouter } from "vue-router";

  const postList = ref([])
  const route = useRoute()

  async function filterPosts() {
    try{
      const res = await axios.get("/api/v1/user/posts", {
        params: { search: route.query?.q },
      })
      postList.value = res.data.records;
    }catch(error){
      console.log(error.response.data);
    }
  }
  watch(() => route.query.q , 
    () => {
      filterPosts()
    },
    {immediate: true}
  )

</script>

<style scoped>
/* Global page wrapper */
.page-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.feed-layout {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 40px; /* space between feed and sidebar */
}

/* Left feed (posts) */
.feed {
  flex: 1 1 70%;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* Post cards should take full width (not centered grid) */
.posts {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* Sidebar */
.sidebar {
  flex: 0 0 300px; /* fixed width like the screenshot */
  display: flex;
  flex-direction: column;
  gap: 20px;
  position: sticky;
  top: 20px;
}

/* Sidebar widgets */
.widget {
  background: #fff;
  border: 1px solid #e6e6e6;
  border-radius: 12px;
  padding: 16px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.widget-title {
  font-size: 15px;
  font-weight: 600;
  margin-bottom: 12px;
  color: #333;
}

</style>
