<template>
  <div class="">
    <h4 class="text-center bg-success text-white p-2">EXPORT CPO</h4>
    <div class="row m-2">
      <div class="col border-end">
        <export-by-status
          style="height: 300px"
          class="sticky-top bg-white border-bottom overflow-auto"
        ></export-by-status>
        <list-by-status></list-by-status>
      </div>

      <div class="col border-end">
        <export-by-modified
          style="height: 300px"
          class="sticky-top bg-white border-bottom overflow-auto"
        ></export-by-modified>
        <list-by-modified></list-by-modified>
      </div>

      <div class="col">
        <by-change-status
          style="height: 300px"
          class="sticky-top bg-white border-bottom overflow-auto"
        ></by-change-status>
        <list-changed-status></list-changed-status>
      </div>
    </div>

    <div class="btn-group" role="group" v-if="false">
      <button type="button" class="btn btn-danger">Search</button>
      <button type="button" class="btn btn-warning" @click="exportPdf">
        Export/PDF
      </button>
      <button type="button" class="btn btn-success" @click="exportXls">
        Export/Excel
      </button>
    </div>
  </div>
</template>

<script>
import ExportByStatus from "./ExportByStatus.vue";
import ExportByModified from "./ExportByModified.vue";
import ByChangeStatus from "./ByChangeStatus.vue";
import ListByStatus from "./ListByStatus.vue";
import ListByModified from "./ListByModified.vue";
import ListChangedStatus from "./ListChangedStatus.vue";
export default {
  components: {
    ExportByStatus,
    ExportByModified,
    ByChangeStatus,
    ListByStatus,
    ListByModified,
    ListChangedStatus,
  },
  inject: ["laravelData", "logPageVisit"],
  data() {
    return {
      selectedStatuses: [],
    };
  },
  computed: {
    // laravelData() {
    //     return this.$store.getters.laravelData;
    // },
    linkPdfListByStatus() {
      return this.laravelData.route_list.find(
        (route) => route.routeName === "generate-pdf-by-status"
      ).uri;
    },
    linkXlsListByStatus() {
      return this.laravelData.route_list.find(
        (route) => route.routeName === "generate-xls-by-status"
      ).uri;
    },
  },
  methods: {
    exportXls() {
      window.location.href =
        this.linkXlsListByStatus + "/?status_id=" + this.selectedStatuses;
    },
    exportPdf() {
      window.location.href =
        this.linkPdfListByStatus + "/?status_id=" + this.selectedStatuses;
    },
  },
  beforeCreate() {
    this.$store.commit("setActiveNav", {
      nav: "export-cpo",
    });
  },
  mounted() {
    this.$store.commit("setMainPageTitleHeader", "CPO - Export");
    this.logPageVisit("Export CPO");
  },
  updated() {
    // console.log(this.laravelData);
  },
};
</script>

<style></style>
