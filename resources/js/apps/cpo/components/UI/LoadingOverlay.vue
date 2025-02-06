<template>
  <div class="loading-overlay">
    <div class="rotating-donut"></div>
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
  background-color: rgba(0, 0, 0, 0.5); /* Dark background with 50% opacity */
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  z-index: 1050; /* Ensure it is above other content */
}

.rotating-donut {
  width: 100px;
  height: 100px;
  border: 10px solid transparent;
  border-top: 10px solid #ff6b6b;
  border-right: 10px solid #f06595;
  border-bottom: 10px solid #845ef7;
  border-left: 10px solid #5c7cfa;
  border-radius: 50%;
  animation: rotate 2s linear infinite, gradient 6s infinite linear;
}

@keyframes rotate {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

@keyframes gradient {
  0% {
    border-top-color: #ff6b6b;
    border-right-color: #f06595;
    border-bottom-color: #845ef7;
    border-left-color: #5c7cfa;
  }
  25% {
    border-top-color: #5c7cfa;
    border-right-color: #ff6b6b;
    border-bottom-color: #f06595;
    border-left-color: #845ef7;
  }
  50% {
    border-top-color: #845ef7;
    border-right-color: #5c7cfa;
    border-bottom-color: #ff6b6b;
    border-left-color: #f06595;
  }
  75% {
    border-top-color: #f06595;
    border-right-color: #845ef7;
    border-bottom-color: #5c7cfa;
    border-left-color: #ff6b6b;
  }
  100% {
    border-top-color: #ff6b6b;
    border-right-color: #f06595;
    border-bottom-color: #845ef7;
    border-left-color: #5c7cfa;
  }
}

.loading-text {
  margin-top: 1rem;
  font-size: 1.5rem;
  font-weight: bold;
  color: #fff; /* White color for better visibility */
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7); /* Add a subtle shadow for better contrast */
}
</style>
