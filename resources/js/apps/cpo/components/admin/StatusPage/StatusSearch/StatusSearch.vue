<template>
  <div class="row p-2">
    <div class="col-md-8">
      <status-list :key="statusListIdKey" />
    </div>
    <div class="col-md-4">
      <status-create @status-created="statusListIdKey++" />
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
  data() {
    return {
      statusListIdKey: 0,
    };
  },
};
</script>

<style></style>
