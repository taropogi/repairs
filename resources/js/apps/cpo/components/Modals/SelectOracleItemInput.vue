<template>
  <base-modal :modal-size="'xl'">
    <template #header>
      <h5 class="modal-title text-white">
        <strong> PLEASE SELECT ORACLE ITEM</strong>
      </h5>
      <button
        type="button"
        class="btn-close"
        @click="$emit('close-modal')"
      ></button>
    </template>
    <template #body>
      <div style="min-height: 600px">
        <div class="mb-3">
          <input
            type="text"
            class="form-control"
            placeholder="Search Oracle Code or Description"
            v-model="searchOracleItemStr"
          />
        </div>

        <div style="max-height: 600px; overflow-y: auto">
          <spinner-loading v-if="isSearching" />
          <table
            class="table table-sm table-hover table-striped"
            v-if="!isSearching && items.length > 0"
          >
            <thead
              class="table-primary"
              style="position: sticky; top: 0; z-index: 1"
            >
              <tr>
                <th scope="col"></th>
                <th scope="col">ORACLE CODE</th>
                <th scope="col">DESCRIPTION</th>
                <th scope="col">UNIT</th>
                <th scope="col">PRICE</th>

                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <select-oracle-item-input-row
                v-for="item in items"
                :key="item.id"
                :item="item"
                @goto-yp="(item) => (currentlyViewingItem = item)"
                :currently-viewing-item="currentlyViewingItem"
                @select-item="selectAndClose"
              />
            </tbody>
          </table>
          <PaginationButton
            v-if="!isSearching && items.length > 0"
            :pagination="pagination"
            :fetch-method="searchOracleItem"
          />
          <h1 v-if="!isSearching && items.length == 0">NO ITEMS FOUND</h1>
        </div>
      </div>
    </template>
    <template #default>
      <div>
        <p class="text-dark">
          <i class="bi bi-arrow-right"></i>
          <strong class="mx-2 text-primary">VIEW IN YP</strong>: Please make
          sure to login to YellowPage first to view the item. Otherwise, you
          will be redirected to the login page.
        </p>

        <p class="text-dark">
          <i class="bi bi-image"></i>
          <strong class="mx-2 text-danger">VIEW IMAGE</strong>: Click the image
          to view it larger.
        </p>
      </div>

      <button
        type="button"
        class="btn btn-danger"
        @click="$emit('close-modal')"
      >
        CLOSE
      </button>
    </template>
  </base-modal>
</template>

<script>
import debounce from "lodash/debounce";
import SpinnerLoading from "../UI/SpinnerLoading.vue";
import SelectOracleItemInputRow from "./SelectOracleItemInputRow.vue";
import PaginationButton from "../UI/PaginationButton.vue";
import { mapGetters } from "vuex";
export default {
  components: { SpinnerLoading, SelectOracleItemInputRow, PaginationButton },
  inject: ["appVersion"],
  data() {
    return {
      items: [],
      searchOracleItemStr: "",
      isSearching: false,
      currentlyViewingItem: null,
      pagination: {
        currentPage: 1,
        perPage: 15,
        totalItems: 0,
        totalPages: 0,
      },
    };
  },
  computed: {
    ...mapGetters("auth", ["isAdmin"]),
  },

  watch: {
    searchOracleItemStr(newValue) {
      this.pagination.currentPage = 1;
      this.debouncedSearch(newValue);
    },
  },

  methods: {
    handleImageError(event) {
      console.log("error");
    },

    selectAndClose(item) {
      this.$emit("item-selected", item);
    },
    async searchOracleItem() {
      if (this.isSearching) return;
      try {
        this.isSearching = true;
        const res = await axios.get("api/items/all", {
          params: {
            search: this.searchOracleItemStr,
            appVersion: this.appVersion,
            ...this.pagination,
          },
        });
        this.items = res.data.items;
        this.pagination.totalItems = res.data.totalItems;
        this.pagination.totalPages = Math.ceil(
          res.data.totalItems / this.pagination.perPage
        );
        // console.log(this.items);
      } catch (error) {
        console.error(error);
      } finally {
        this.isSearching = false;
      }
    },
  },
  mounted() {
    this.$nextTick(() => {
      this.$el.querySelector('input[type="text"]').focus();
    });

    this.searchOracleItem();
  },
  created() {
    this.debouncedSearch = debounce(this.searchOracleItem, 500);
  },
};
</script>

<style></style>
