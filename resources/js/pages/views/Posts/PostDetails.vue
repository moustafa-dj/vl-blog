<template>
  <div class="post-details-container" v-if="post">
    <!-- Post Cover -->
    <div class="post-cover">
      <img :src="getImgUrl(post.cover)" :alt="post.title" />
    </div>

    <!-- Post Title -->
    <div class="post-header">
      <h1>{{ post.title }}</h1>

      <div class="post-meta">
        <span class="author">By {{ post.user?.name || 'Unknown' }}</span>
        <span class="date">{{ new Date(post.created_at).toLocaleDateString() }}</span>
      </div>
    </div>

    <!-- Post Content -->
    <div class="post-content">
      <p>{{ post.content }}</p>
    </div>

    <!-- Edit / Delete Actions -->
    <div
      class="post-actions"
      v-if="authStore.auth && post.user?.id === authStore.userId"
    >
      <router-link
        :to="{ name: 'edit-post', params: { id: post.id } }"
        class="btn-edit"
      >
        ✏️ Edit
      </router-link>
      <button class="btn-delete" @click="deletePost">🗑 Delete</button>
    </div>

    <!-- Comments Section -->
    <div class="comments-section">
      <h3>
        💬 Comments ({{ commentList.length }})

        <span v-if="isAuthenticated == false">
            (Login to comment)
        </span>
      </h3>

      <CommentForm :post="post" @comment-added="getComments" />

      <div v-if="commentList.length" class="comment-list">
        <Comment
          v-for="comment in commentList"
          :key="comment.id"
          :comment="comment"
        />
      </div>
      <p v-else class="no-comments">
        No comments yet. Be the first to comment!
      </p>
    </div>
  </div>

  <!-- Loading or Not Found -->
  <div v-else class="loading">
    Loading post details...
  </div>
</template>

<script>
import axios from "axios";
import { authStore } from "../../../stores/authStore";
import Comment from "../../../components/Comment.vue";
import CommentForm from "../../../components/Forms/Comment/CommentForm.vue";

export default {
  components: { Comment, CommentForm },
  data() {
    return {
      post: null,
      commentList: [],
      authStore,
    };
  },
  mounted() {
    this.getPost();
  },
  methods: {
    getImgUrl(cover) {
      return "/file/" + cover;
    },
    async getPost() {
      try {
        const res = await axios.get(
          "/api/v1/user/posts/" + this.$route.params.id,
          {
            headers: {
              Authorization: `Bearer ${authStore.getAuthorization()}`,
              "Content-Type": "application/json",
            },
          }
        );
        this.post = res.data.record;
        this.getComments();
      } catch (error) {
        console.error(error);
      }
    },
    async getComments() {
      try {
        const res = await axios.get("/api/v1/user/comments", {
          params: { post_id: this.post.id },
        });
        this.commentList = res.data.records;
      } catch (error) {
        console.error(error);
      }
    },
    async deletePost() {
      try {
        await axios.delete(`/api/v1/user/posts/${this.post.id}`, {
          headers: {
            Authorization: `Bearer ${authStore.getAuthorization()}`,
            "Content-Type": "application/json",
          },
        });
        this.$router.push({ name: "home" });
      } catch (error) {
        console.error(error);
      }
    },
  },
  computed:{
    isAuthenticated(){
        return authStore.auth
    }
  }
};
</script>

<style scoped>
.post-details-container {
  max-width: 800px;
  margin: 70px auto;
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
  padding-bottom: 20px;
}

.post-cover img {
  width: 100%;
  height: 300px;
  object-fit: cover;
}

.post-header {
  padding: 20px;
  border-bottom: 1px solid #eee;
}

.post-header h1 {
  font-size: 28px;
  margin-bottom: 8px;
  color: #1f2937;
}

.post-meta {
  font-size: 14px;
  color: #6b7280;
  display: flex;
  gap: 15px;
}

.post-content {
  padding: 20px;
  font-size: 16px;
  line-height: 1.7;
  color: #374151;
}

.post-actions {
  padding: 20px;
  display: flex;
  gap: 10px;
}

.btn-edit,
.btn-delete {
  font-size: 14px;
  padding: 8px 14px;
  border-radius: 6px;
  cursor: pointer;
  border: none;
  text-decoration: none;
}

.btn-edit {
  background: #e0e7ff;
  color: #1e3a8a;
}

.btn-edit:hover {
  background: #c7d2fe;
}

.btn-delete {
  background: #fee2e2;
  color: #991b1b;
}

.btn-delete:hover {
  background: #fecaca;
}

.comments-section {
  padding: 20px;
}

.comments-section h3 {
  margin-bottom: 10px;
  color: #111827;
}

.comment-list {
  margin-top: 15px;
}

.no-comments {
  color: #6b7280;
  font-style: italic;
}

.loading {
  text-align: center;
  padding: 40px;
  font-size: 18px;
  color: #6b7280;
}
</style>
