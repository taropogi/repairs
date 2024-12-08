<template>
  <div class="modal fade show" tabindex="-1" style="display: block">
    <div
      class="modal-dialog"
      :class="{
        'modal-lg': modalSize === 'lg',
        'modal-xl': modalSize === 'xl',
        'modal-sm': modalSize === 'sm',
        'modal-md': modalSize === 'md',
      }"
    >
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <slot name="header"></slot>
        </div>
        <div class="modal-body">
          <slot name="body"></slot>
        </div>
        <div class="modal-footer">
          <slot></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  inject: ["setShowBackDrop"],
  props: {
    modalSize: {
      type: String,
      default: "lg",
    },
  },
  mounted() {
    this.setShowBackDrop(true);
  },
  unmounted() {
    this.setShowBackDrop(false);
  },
};
</script>

<style scoped>
.modal {
  z-index: 10001;
}
</style>
