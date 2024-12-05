<template>
  <div class="d-grid gap-2" v-if="isNavExportActive">
    <button class="btn btn-danger" type="button" @click="exportPdf">
      <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
    </button>
    <button class="btn btn-success" type="button" @click="exportXls">
      <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
    </button>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  inject: ["laravelData"],
  computed: {
    ...mapGetters(["activeNav"]),
    ...mapGetters("export", [
      "selectedStatus",
      "cpoModifiedDate",
      "cpoChangedStatusDate",
      "cpoChangedStatusTo",
      "cpoChangedStatusCurrent",
    ]),
    showExportBtns() {
      return this.selectedStatusCount > 0;
    },
    selectedStatusCount() {
      return this.selectedStatus.length;
    },
    isNavExportActive() {
      if (this.activeNav?.nav === "export-cpo") {
        return true;
      }
      return false;
    },
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
      const url =
        this.linkXlsListByStatus +
        "/?status_id=" +
        this.selectedStatus.map((status) => status.id) +
        "&cpo_modified_from=" +
        this.cpoModifiedDate.from +
        "&cpo_modified_to=" +
        this.cpoModifiedDate.to +
        "&cpo_changed_date_from=" +
        this.cpoChangedStatusDate.from +
        "&cpo_changed_date_to=" +
        this.cpoChangedStatusDate.to +
        "&cpo_changed_status_to=" +
        this.cpoChangedStatusTo +
        "&cpo_changed_current_only=" +
        this.cpoChangedStatusCurrent;
      window.location.href = url;
      // console.log(url);
    },
    exportPdf() {
      const url =
        this.linkPdfListByStatus +
        "/?status_id=" +
        this.selectedStatus.map((status) => status.id) +
        "&cpo_modified_from=" +
        this.cpoModifiedDate.from +
        "&cpo_modified_to=" +
        this.cpoModifiedDate.to +
        "&cpo_changed_date_from=" +
        this.cpoChangedStatusDate.from +
        "&cpo_changed_date_to=" +
        this.cpoChangedStatusDate.to +
        "&cpo_changed_status_to=" +
        this.cpoChangedStatusTo +
        "&cpo_changed_current_only=" +
        this.cpoChangedStatusCurrent;
      window.location.href = url;
      // console.log(url);
    },
  },
};
</script>

<style></style>
