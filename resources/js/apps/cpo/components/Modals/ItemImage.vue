<template>
  <span v-if="!error">
    <img
      :src="url"
      alt="Item Image"
      class="item-image"
      @error="handleImageError"
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
  },
};
</script>

<style></style>
