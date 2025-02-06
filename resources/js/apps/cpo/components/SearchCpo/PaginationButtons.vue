<template>
  <!-- Pagination Controls -->
  <div class="pagination">
    <button
      :disabled="currentPage === 1"
      @click="prevPage"
      class="pagination-button"
    >
      Previous
    </button>
    <span class="pagination-info">Page {{ currentPage }} / {{ lastPage }}</span>
    <button :disabled="isLastPage" @click="nextPage" class="pagination-button">
      Next
    </button>
  </div>
</template>

<script>
export default {
  emits: ["prevPage", "nextPage"],
  props: {
    currentPage: {
      type: Number,
      required: false,
      default: 1,
    },
    lastPage: {
      type: Number,
      required: true,
    },
  },
  computed: {
    isLastPage() {
      return this.currentPage === this.lastPage;
    },
  },
  methods: {
    prevPage() {
      this.$emit("prevPage");
    },
    nextPage() {
      this.$emit("nextPage");
    },
  },
};
</script>

<style scoped>
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.pagination-button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 20px;
  margin: 0 5px;
  cursor: pointer;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.pagination-button:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}

.pagination-button:not(:disabled):hover {
  background-color: #0056b3;
}

.pagination-info {
  margin: 0 10px;
  font-size: 16px;
}
</style>