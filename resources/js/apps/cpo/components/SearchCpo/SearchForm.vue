<template>
  <form class="p-2 m-0 bg-white">
    <div class="row">
      <div class="col p-2">
        <label>CUSTOMER NAME</label>
        <input
          type="text"
          class="form-control shadow"
          @input="search"
          v-model.lazy="searchCriteria.searchName"
        />
      </div>
      <div class="col p-2">
        <label>CUSTOMER ADDRESS</label>
        <input
          type="text"
          class="form-control shadow"
          @input="search"
          v-model.lazy="searchCriteria.searchAddress"
        />
      </div>
      <div class="col p-2">
        <label>CONTACT #</label>
        <input
          type="text"
          class="form-control shadow"
          @input="search"
          v-model.lazy="searchCriteria.searchContactNumber"
        />
      </div>
    </div>
    <div class="row">
      <div class="col p-2">
        <label>RPO #</label>
        <input
          type="text"
          class="form-control shadow"
          @input="search"
          v-model.lazy="searchCriteria.searchRpoNumber"
        />
      </div>
      <div class="col p-2">
        <label>PREPARED BY</label>
        <input
          type="text"
          class="form-control shadow"
          @input="search"
          v-model.lazy="searchCriteria.searchPreparedBy"
        />
      </div>
      <div class="col p-2">
        <label>AUTHORIZED BY</label>
        <input
          type="text"
          class="form-control shadow"
          @input="search"
          v-model.lazy="searchCriteria.searchAuthorizedBy"
        />
      </div>
    </div>
  </form>
</template>

<script>
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
      },
    };
  },

  methods: {
    search() {
      this.$emit("search-cpo-header", this.searchCriteria);
    },
  },
  mounted() {
    this.search();
  },
};
</script>

<style></style>
