<template>
  <div class="comment-item">
      <div class="comment-header">
        <span class="comment-user">{{ comment.user?.name }}</span>
      </div>
      <div class="comment-body">
        <p class="comment-content">{{ comment.content }}</p>
      </div>
  </div>
</template>

<script>
export default {

    props:['comment'],
    data(){
        return {
        }
    },

    methods: {
    },

}
</script>
<style>

.comment-item {
  border: 1px solid rgba(77, 96, 138, 0.21);
  padding: 1rem;
  margin-bottom: 1rem;
  border-radius: 20px;
}

.comment-header {
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 0.25rem;
}

.comment-user {
  font-size: 0.95rem;
  color: #111827;
}

.comment-content {
  font-size: 0.95rem;
  color: #374151;
  line-height: 1.4;
}
</style>
