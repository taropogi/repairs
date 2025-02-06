<template>
  <!-- Pagination Controls -->
  <div class="pagination" v-if="showPaginationButtons">
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
  props: {
    cpoHeaderList: {
      type: Array,
      required: true,
    },
    allHeadersCount: {
      type: Number,
      required: true,
    },
    currentPage: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      perPage: 15,
    };
  },
  computed: {
    lastPage() {
      return Math.ceil(this.allHeadersCount / this.perPage);
    },
    showPaginationButtons() {
      if (this.currentPage > 1) return true;
      return this.currentPage == 1 && this.cpoListCount >= this.perPage;
    },
    isLastPage() {
      return this.cpoListCount < this.perPage;
    },
    cpoListCount() {
      return this.cpoHeaderList.length;
    },
  },
  methods: {
    updateQuery() {
      this.$router.push({
        query: { ...this.$route.query, page: this.currentPage },
      });
    },
    nextPage() {
      this.currentPage++;
      this.$emit("nextPage", this.currentPage + 1);
      this.updateQuery();
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.updateQuery();
      }
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