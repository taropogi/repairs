<template>
  <form class="p-2 m-0 bg-white">
    <div class="row">
      <div class="col p-2">
        <label>PULLOUT#</label>
        <input
          type="text"
          class="form-control shadow"
          @input="debouncedSearch"
          v-model="searchCriteria.searchRpoNumber"
        />
      </div>
      <div class="col p-2">
        <label>RMA#</label>
        <input
          type="text"
          class="form-control shadow"
          @input="debouncedSearch"
          v-model="searchCriteria.searchRmaNumber"
        />
      </div>
      <div class="col p-2">
        <label>Reference#</label>
        <input
          type="text"
          class="form-control shadow"
          @input="debouncedSearch"
          v-model="searchCriteria.searchCustomerReferenceNumber"
        />
      </div>
      <div class="col p-2">
        <label>CUSTOMER NAME</label>
        <input
          type="text"
          class="form-control shadow"
          @input="debouncedSearch"
          v-model="searchCriteria.searchName"
        />
      </div>
    </div>
    <div class="row">
      <div class="col p-2">
        <label>CUSTOMER ADDRESS</label>
        <input
          type="text"
          class="form-control shadow"
          @input="debouncedSearch"
          v-model="searchCriteria.searchAddress"
        />
      </div>
      <div class="col p-2">
        <label>CONTACT #</label>
        <input
          type="text"
          class="form-control shadow"
          @input="debouncedSearch"
          v-model="searchCriteria.searchContactNumber"
        />
      </div>
      <div class="col p-2">
        <label>PREPARED BY</label>
        <input
          type="text"
          class="form-control shadow"
          @input="debouncedSearch"
          v-model="searchCriteria.searchPreparedBy"
        />
      </div>
      <div class="col p-2">
        <label>AUTHORIZED BY</label>
        <input
          type="text"
          class="form-control shadow"
          @input="debouncedSearch"
          v-model="searchCriteria.searchAuthorizedBy"
        />
      </div>
    </div>
  </form>
</template>

<script>
import { debounce } from "lodash";
export default {
  emits: ["search-cpo-header"],
  data() {
    return {
      onInputDelayedSeconds: 0,
      startSearch: false,
      searchCriteria: {
        searchName: "",
        searchAddress: "",
        searchContactNumber: "",
        searchRpoNumber: "",
        searchPreparedBy: "",
        searchAuthorizedBy: "",
        searchRmaNumber: "",
        searchCustomerReferenceNumber: "",
      },
    };
  },

  methods: {
    search() {
      console.log("searching...");
      this.$emit("search-cpo-header", { ...this.searchCriteria });
    },
  },
  // mounted() {
  //   this.search();
  // },
  created() {
    this.debouncedSearch = debounce(this.search, 500);
  },
};
</script>

<style></style>
