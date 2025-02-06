<template>
  <div
    class="header-container d-flex justify-content-center align-items-center flex-column p-4 mt-2"
  >
    <h3 class="fw-bold text-primary mb-2">PULLOUT#: {{ pulloutNumber }}</h3>
    <transition name="zoom">
      <h3 class="fw-bold text-success" v-if="generatedRma">
        RMA#: {{ generatedRma }}
      </h3>
    </transition>
  </div>
</template>

<script>
export default {
  props: {
    pulloutNumber: {
      type: String,
      required: true,
    },
    generatedRma: {
      type: String,
      default: "",
    },
  },
};
</script>

<style scoped>
.header-container {
  background-color: #f8f9fa; /* Light background */
  border-radius: 10px; /* Rounded corners */
}

h3 {
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Subtle text shadow */
}

@keyframes zoomIn {
  0% {
    opacity: 0;
    transform: scale(3);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

@keyframes zoomOut {
  0% {
    opacity: 1;
    transform: scale(1);
  }
  100% {
    opacity: 0;
    transform: scale(3);
  }
}

.zoom-enter-active {
  animation: zoomIn 1s ease-in-out;
}

.zoom-leave-active {
  animation: zoomOut 1s ease-in-out;
}
</style>
