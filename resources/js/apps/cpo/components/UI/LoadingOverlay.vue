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
  background-color: rgba(173, 216, 230, 0.5); /* Light blue with 50% opacity */
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 1050; /* Ensure it is above other content */
}

.loading-text {
  margin-top: 1rem;
  font-size: 2rem;
  font-weight: bold;
  color: #000; /* Black color for better visibility */
  text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.7); /* Add a subtle shadow for better contrast */
}
</style>
