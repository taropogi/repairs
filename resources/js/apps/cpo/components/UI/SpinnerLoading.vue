<template>
  <div class="text-center p-5 m-5">
    <div class="spinner-container">
      <div class="spinner-circle"></div>
      <div class="spinner-circle"></div>
      <div class="spinner-circle"></div>
      <div class="spinner-circle"></div>
    </div>
  </div>
</template>
  
  <script>
export default {};
</script>
  
  <style scoped>
.spinner-container {
  position: relative;
  width: 100px;
  height: 100px;
  margin: 0 auto;
  animation: rotate 2s linear infinite;
}

.spinner-circle {
  width: 20px;
  height: 20px;
  background-color: #3498db;
  border-radius: 50%;
  position: absolute;
  animation: color-change 1.2s linear infinite;
}

.spinner-circle:nth-child(1) {
  top: 0;
  left: 50%;
  transform: translate(-50%, -50%);
  animation-delay: -0.45s;
}

.spinner-circle:nth-child(2) {
  top: 50%;
  left: 100%;
  transform: translate(-50%, -50%);
  animation-delay: -0.3s;
}

.spinner-circle:nth-child(3) {
  top: 100%;
  left: 50%;
  transform: translate(-50%, -50%);
  animation-delay: -0.15s;
}

.spinner-circle:nth-child(4) {
  top: 50%;
  left: 0;
  transform: translate(-50%, -50%);
  animation-delay: 0s;
}

@keyframes rotate {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

@keyframes color-change {
  0% {
    background-color: #e74c3c;
  }
  25% {
    background-color: #f1c40f;
  }
  50% {
    background-color: #2ecc71;
  }
  75% {
    background-color: #9b59b6;
  }
  100% {
    background-color: #e74c3c;
  }
}
</style>