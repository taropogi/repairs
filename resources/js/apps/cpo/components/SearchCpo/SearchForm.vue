<template>
  <form class="p-3 bg-light rounded shadow-sm">
    <div class="row g-3">
      <div class="col-md">
        <label for="searchRpoNumber" class="form-label">PULLOUT#</label>
        <input
          type="text"
          id="searchRpoNumber"
          class="form-control"
          @input="debouncedSearch"
          v-model="searchCriteria.searchRpoNumber"
          placeholder="Enter pullout number"
        />
      </div>
      <div class="col-md">
        <label for="searchRmaNumber" class="form-label">RMA#</label>
        <input
          type="text"
          id="searchRmaNumber"
          class="form-control"
          @input="debouncedSearch"
          v-model="searchCriteria.searchRmaNumber"
          placeholder="Enter RMA number"
        />
      </div>
      <div class="col-md">
        <label for="searchCustomerReferenceNumber" class="form-label"
          >Reference#</label
        >
        <input
          type="text"
          id="searchCustomerReferenceNumber"
          class="form-control"
          @input="debouncedSearch"
          v-model="searchCriteria.searchCustomerReferenceNumber"
          placeholder="Enter reference number"
        />
      </div>
      <div class="col-md">
        <label for="searchName" class="form-label">CUSTOMER NAME</label>
        <input
          type="text"
          id="searchName"
          class="form-control"
          @input="debouncedSearch"
          v-model="searchCriteria.searchName"
          placeholder="Enter customer name"
        />
      </div>
      <div class="col-md">
        <label for="searchAddress" class="form-label">CUSTOMER ADDRESS</label>
        <input
          type="text"
          id="searchAddress"
          class="form-control"
          @input="debouncedSearch"
          v-model="searchCriteria.searchAddress"
          placeholder="Enter customer address"
        />
      </div>
      <div class="col-md">
        <label for="searchContactNumber" class="form-label">CONTACT #</label>
        <input
          type="text"
          id="searchContactNumber"
          class="form-control"
          @input="debouncedSearch"
          v-model="searchCriteria.searchContactNumber"
          placeholder="Enter contact number"
        />
      </div>
      <div class="col-md">
        <label for="searchPreparedBy" class="form-label">PREPARED BY</label>
        <input
          type="text"
          id="searchPreparedBy"
          class="form-control"
          @input="debouncedSearch"
          v-model="searchCriteria.searchPreparedBy"
          placeholder="Enter prepared by"
        />
      </div>
      <div class="col-md">
        <label for="searchAuthorizedBy" class="form-label">AUTHORIZED BY</label>
        <input
          type="text"
          id="searchAuthorizedBy"
          class="form-control"
          @input="debouncedSearch"
          v-model="searchCriteria.searchAuthorizedBy"
          placeholder="Enter authorized by"
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
