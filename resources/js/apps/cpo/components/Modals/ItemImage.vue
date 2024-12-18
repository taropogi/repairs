<template>
  <span v-if="!error">
    <img
      :src="url"
      alt="Item Image"
      class="item-image img-fluid mx-2"
      style="max-height: 50px;"
      @error="handleImageError"
      @click="openImage"
    />
  </span>
</template>

<script>
export default {
  props: {
    url: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      error: false,
    };
  },
  methods: {
    handleImageError() {
      this.error = true;
    },
    openImage() {
    
      const popupWidth = 600;
      const popupHeight = 400;
      const left = (screen.width / 2) - (popupWidth / 2);
      const top = (screen.height / 2) - (popupHeight / 2);
      window.open(this.url, '_blank', `width=${popupWidth},height=${popupHeight},top=${top},left=${left}`);
      
    
    }
  },
};
</script>

<style scoped>
.item-image {
  cursor: pointer;
}
.item-image:hover {
  border: 2px solid red;
  box-shadow: 0 0 10px red;
}
</style>
