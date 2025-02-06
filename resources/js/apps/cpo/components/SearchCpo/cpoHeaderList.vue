<template>
  <div class="p-2">
    <spinner-loading v-if="isSearching && !error"> </spinner-loading>
    <h1 v-else-if="error">
      {{ error }}
    </h1>
    <div class="my-2" v-else>
      <teleport to="body">
        <modal-delete-cpo
          v-if="deleteCpo"
          :cpo-id="deleteCpo.id"
          @close-modal-delete-cpo="closeModalDeleteCpo"
          @deleted-cpo="deleteCpoConfirm"
        ></modal-delete-cpo>
      </teleport>

      <teleport to="body">
        <modal-pdf-history
          v-if="showPdfHistoryId"
          :id="showPdfHistoryId"
          @close="showPdfHistoryId = null"
        ></modal-pdf-history>
      </teleport>

      <table class="table table-sm table-bordered table-striped table-hover">
        <thead
          class="table-success"
          style="position: sticky; top: 0; z-index: 1"
        >
          <tr>
            <th class="col tex-center">
              <span class="nowrap"
                >PULLOUT#
                <span v-if="selectedPosCount > 0"
                  >[{{ selectedPosCount }}]</span
                ></span
              >
            </th>
            <th class="col tex-center">RMA#</th>

            <th scope="col">DATE ENCODED</th>
            <th scope="col">NAME</th>
            <th scope="col">REFERENCE#</th>
            <th scope="col">CONTACT#</th>
            <th scope="col">PREPARED BY</th>
            <th scope="col">AUTHORIZED BY</th>
            <th scope="col">STATUS</th>
            <th scope="col" style="width: 200px">ACTIONS</th>
          </tr>
        </thead>

        <transition-group tag="tbody" name="cpo-list">
          <header-list-item
            v-for="item in cpoHeaderList"
            :key="item.id"
            :header-item="item"
            @delete-cpo="openDeleteCpo"
            @show-pdf-history="
              (cpo) => {
                showPdfHistoryId = cpo.id;
              }
            "
          ></header-list-item>
        </transition-group>
      </table>
      <!-- <pagination-buttons
        :cpo-header-list="cpoHeaderList"
        :all-headers-count="allHeadersCount"
        @nextPage="nextPage"
        :current-page="currentPage"
      /> -->
      <!-- Pagination Controls -->
      <div class="pagination" v-if="showPaginationButtons">
        <button
          :disabled="currentPage === 1"
          @click="prevPage"
          class="pagination-button"
        >
          Previous
        </button>
        <span class="pagination-info"
          >Page {{ currentPage }} / {{ lastPage }}</span
        >
        <button
          :disabled="isLastPage"
          @click="nextPage"
          class="pagination-button"
        >
          Next
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import HeaderListItem from "./HeaderListItem.vue";
import ModalPdfHistory from "../Modals/PdfHistory.vue";
import ModalDeleteCpo from "../DeleteCpo/ModalDeleteCpo.vue";
import PaginationButtons from "./PaginationButtons.vue";
import { mapGetters } from "vuex";

export default {
  components: {
    HeaderListItem,
    ModalPdfHistory,
    ModalDeleteCpo,
    PaginationButtons,
  },
  data() {
    return {
      cpoHeaderList: [],
      selectedHeaders: [],
      isSearching: false,
      showPdfHistoryId: null,
      deleteCpo: null,
      error: null,
      initialPage: 1,
      currentPage: 1,
      perPage: 15,
      allHeadersCount: 0,
    };
  },

  props: ["searchCriteria"],
  inject: ["showNotification"],
  computed: {
    ...mapGetters("cpo", ["deletedCpos"]),
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

    selectedPosCount() {
      return this.selectedPos.length;
    },
    selectedPos() {
      return this.$store.getters["cpo/getSelectedPos"];
    },
  },
  watch: {
    deletedCpos: {
      handler(newVal, oldVal) {
        for (const cpo of newVal) {
          // console.log("ok " + cpo);
          this.deleteCpoConfirm(cpo, "multiple");
        }
      },
      deep: true,
    },
    "$route.query.page": {
      handler(newPage) {
        // console.log("changed page");
        this.currentPage = parseInt(newPage) || 1;
        this.getCpoHeaders();
      },
      immediate: true,
    },
    cpoListCount(value) {
      if (value <= 40) {
        // console.log("search");
        // this.getCpoHeaders();
      }
    },
    searchCriteria: {
      handler(newValue, oldValue) {
        // console.log("changed criteria");
        // console.log(newValue, oldValue);
        // console.log("changed");

        this.currentPage = 1;
        this.updateQuery();
        this.getCpoHeaders();
        // Note: `newValue` will be equal to `oldValue` here
        // on nested mutations as long as the object itself
        // hasn't been replaced.
      },
      deep: true,
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
      this.updateQuery();
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.updateQuery();
      }
    },
    openDeleteCpo(cpoId) {
      this.deleteCpo = cpoId;
    },
    deleteCpoConfirm(deleteCpo, type = "single") {
      // console.log(deleteCpo);
      const filteredList = this.cpoHeaderList.filter(
        (el) => el.id !== deleteCpo.id
      );
      this.cpoHeaderList = filteredList;
      this.closeModalDeleteCpo();
      if (type === "single") {
        this.showNotification({
          message: `CPO# ${deleteCpo.formatted_id} has been deleted`,
          type: "error",
        });
      }
    },
    closeModalDeleteCpo() {
      this.deleteCpo = null;
    },
    async getCpoHeaders() {
      if (this.isSearching) return;
      this.isSearching = true;
      this.error = null;

      try {
        const response = await axios.get("api/cpo", {
          params: {
            ...this.searchCriteria,
            page: this.currentPage,
            perPage: this.perPage,
          },
        });

        this.cpoHeaderList = response.data.cpos;
        this.allHeadersCount = response.data.allHeadersCount;
      } catch (error) {
        this.error = error;
      } finally {
        this.isSearching = false;
      }
    },
  },
  mounted() {
    // this.getCpoHeaders();
  },
  updated() {
    // console.log(this.searchCriteria);
  },
};
</script>

<style scoped>
.cpo-list-leave-from {
  opacity: 1;
  transform: translateX(0);
}
.cpo-list-leave-active {
  transition: all 1s ease-in;
  position: absolute;
}
.cpo-list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

.cpo-list-move {
  transition: transform 0.8s ease;
}

.fixed-header {
  position: sticky;
  top: 0;
  z-index: 1;
  background-color: white; /* Ensure the background color matches the table */
}

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
