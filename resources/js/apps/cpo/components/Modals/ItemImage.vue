<template>
  <span v-if="!error">
    <img
      :src="url"
      alt="Item Image"
      class="item-image img-fluid"
      style="max-height: 50px;"
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
