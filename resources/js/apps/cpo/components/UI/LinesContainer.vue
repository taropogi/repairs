<template>
  <div>
    <teleport to="body">
      <select-oracle-item-input
        @item-selected="itemSelected"
        @close-modal="closeModal"
        v-if="isSelectingOracleItem"
      />
    </teleport>
    <slot></slot>
  </div>
</template>

<script>
import SelectOracleItemInput from "../Modals/SelectOracleItemInput.vue";
export default {
  components: {
    SelectOracleItemInput,
  },
};
</script>

<style>
</style>