<template>
  <div class="loading-overlay">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="loading-text m-2">{{ text }}</div>
  </div>
</template>

<script>
export default {
  props: {
    text: {
      type: String,
      default: "Loading, please wait...",
    },
  },
};
</script>

<style scoped>
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.5); /* 50% opacity */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1050; /* Ensure it is above other content */
}
.loading-text {
  margin-top: 1rem;
  font-size: 1.25rem;
  color: #000;
}
</style>
