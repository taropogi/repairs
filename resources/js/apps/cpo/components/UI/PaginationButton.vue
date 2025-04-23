<template>
  <div class="d-flex align-items-center justify-content-center mt-3 gap-2">
    <button
      class="btn btn-sm btn-outline-primary"
      :disabled="pagination.currentPage === 1"
      @click="
        pagination.currentPage = 1;
        fetchMethod();
      "
    >
      First
    </button>
    <button
      class="btn btn-sm btn-outline-primary"
      :disabled="pagination.currentPage === 1"
      @click="
        pagination.currentPage--;
        fetchMethod();
      "
    >
      Previous
    </button>
    <span class="mx-3">
      Page <strong>{{ pagination.currentPage }}</strong> of
      <strong>{{ pagination.totalPages }}</strong>
    </span>
    <button
      class="btn btn-sm btn-outline-primary"
      :disabled="pagination.currentPage === pagination.totalPages"
      @click="
        pagination.currentPage++;
        fetchMethod();
      "
    >
      Next
    </button>
    <button
      class="btn btn-sm btn-outline-primary"
      :disabled="pagination.currentPage === pagination.totalPages"
      @click="
        pagination.currentPage = pagination.totalPages;
        fetchMethod();
      "
    >
      Last
    </button>
    <span class="text-xs text-gray-600">
      Showing {{ (pagination.currentPage - 1) * pagination.perPage + 1 }} to
      {{
        Math.min(
          pagination.currentPage * pagination.perPage,
          pagination.totalItems
        )
      }}
      of
      {{ pagination.totalItems }}
    </span>
  </div>
</template>
  
  <script>
export default {
  props: {
    pagination: {
      type: Object,
      required: true,
    },
    fetchMethod: {
      type: Function,
      required: true,
    },
  },
};
</script>
  
  <style scoped>
.d-flex {
  display: flex;
}
.align-items-center {
  align-items: center;
}
.justify-content-center {
  justify-content: center;
}
.gap-2 {
  gap: 0.5rem;
}
.mx-3 {
  margin-left: 1rem;
  margin-right: 1rem;
}
button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>