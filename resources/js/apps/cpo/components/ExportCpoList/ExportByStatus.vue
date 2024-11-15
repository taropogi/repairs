<template>
  <div>
    <p class="bg-primary p-1 text-white text-center">
      CPO Status
      <span v-if="searchedCount">({{ searchedCount }})</span>
    </p>
    <span>Please select status</span>

    <by-status-item
      v-for="status in cpoStatuses"
      :key="status.id + status.status"
      :status="status"
    >
    </by-status-item>
  </div>
</template>

<script>
import ByStatusItem from "./ByStatusItem.vue";
import { mapGetters } from "vuex";
export default {
  components: {
    ByStatusItem,
  },
  data() {
    return {
      cpoStatuses: null,
    };
  },
  computed: {
    ...mapGetters("export", ["selectedStatus", "exportSearched"]),
    searchedCount() {
      return this.exportSearched.byStatus.length;
    },
  },
  methods: {
    async getDataCriteria() {
      await axios
        .get("api/export/criteria/data")
        .then((response) => {
          // console.log("success");
          this.cpoStatuses = response.data.header_statuses;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  mounted() {
    this.getDataCriteria();
  },
};
</script>

<style></style>
