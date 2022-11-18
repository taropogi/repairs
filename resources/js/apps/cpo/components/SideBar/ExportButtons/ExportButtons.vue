<template>
    <div class="d-grid gap-2" v-if="isNavExportActive">
        <button class="btn btn-danger" type="button" @click="exportPdf">
            Export PDF
        </button>
        <button class="btn btn-success" type="button" @click="exportXls">
            Export Excel
        </button>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    inject: ["laravelData"],
    computed: {
        ...mapGetters(["activeNav"]),
        ...mapGetters("export", ["selectedStatus", "cpoModifiedDate"]),
        showExportBtns() {
            return this.selectedStatusCount > 0;
        },
        selectedStatusCount() {
            return this.selectedStatus.length;
        },
        isNavExportActive() {
            if (this.activeNav && this.activeNav.nav === "export-cpo") {
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
            window.location.href =
                this.linkXlsListByStatus +
                "/?status_id=" +
                this.selectedStatus.map((status) => status.id) +
                "&cpo_modified_from=" +
                this.cpoModifiedDate.from +
                "&cpo_modified_to=" +
                this.cpoModifiedDate.to;
        },
        exportPdf() {
            window.location.href =
                this.linkPdfListByStatus +
                "/?status_id=" +
                this.selectedStatus.map((status) => status.id) +
                "&cpo_modified_from=" +
                this.cpoModifiedDate.from +
                "&cpo_modified_to=" +
                this.cpoModifiedDate.to;
        },
    },
};
</script>

<style></style>
