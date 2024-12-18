<template>
  <span v-if="!error">
    <img
      :src="url"
      alt="Item Image"
      class="item-image"
      @load="handleImageLoaded"
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
      error: true,
    };
  },
  methods: {
    handleImageLoaded() {
      this.error = false;
    },
  },
};
</script>

<style></style>
