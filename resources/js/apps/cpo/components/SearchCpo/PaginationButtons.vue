<template>
  <!-- Pagination Controls -->
  <div class="pagination">
    <button
      :disabled="currentPage === 1"
      @click="firstPage"
      class="btn mx-2"
      :class="{
        'btn-secondary': currentPage === 1,
        'btn-success': currentPage !== 1,
      }"
    >
      &laquo; First
    </button>
    <button
      :disabled="currentPage === 1"
      @click="prevPage"
      class="btn btn-primary"
    >
      Previous
    </button>
    <span class="pagination-info">Page {{ currentPage }} / {{ lastPage }}</span>
    <button :disabled="isLastPage" @click="nextPage" class="btn btn-primary">
      Next
    </button>
    <button
      :disabled="isLastPage"
      @click="goToLastPage"
      class="btn mx-2"
      :class="{
        'btn-secondary': isLastPage,
        'btn-success': !isLastPage,
      }"
    >
      Last &raquo;
    </button>
  </div>
</template>

<script>
export default {
  emits: ["prevPage", "nextPage", "firstPage", "lastPage"],
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
    firstPage() {
      this.$emit("firstPage");
    },
    prevPage() {
      this.$emit("prevPage");
    },
    nextPage() {
      this.$emit("nextPage");
    },
    goToLastPage() {
      this.$emit("lastPage");
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