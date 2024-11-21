<template>
  <div class="row p-2">
    <div class="col-md-8">
      <status-list />
    </div>
    <div class="col-md-4">
      <status-create />
    </div>
  </div>
</template>

<script>
import StatusList from "./StatusList.vue";
import StatusCreate from "../StatusCreate.vue";
export default {
  components: {
    StatusList,
    StatusCreate,
  },
};
</script>

<style></style>
