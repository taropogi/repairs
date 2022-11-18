<template>
    <div class="p-2">
        <div class="row">
            <div class="col">
                <export-by-status></export-by-status>
            </div>

            <div class="col">
                <export-by-modified></export-by-modified>
            </div>

            <div class="col">
                <by-change-status></by-change-status>
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
export default {
    components: {
        ExportByStatus,
        ExportByModified,
        ByChangeStatus,
    },
    inject: ["laravelData"],
    data() {
        return {
            cpoStatuses: null,
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
                this.linkXlsListByStatus +
                "/?status_id=" +
                this.selectedStatuses;
        },
        exportPdf() {
            window.location.href =
                this.linkPdfListByStatus +
                "/?status_id=" +
                this.selectedStatuses;
        },
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
    beforeCreate() {
        this.$store.commit("setActiveNav", {
            nav: "export-cpo",
        });
    },
    mounted() {
        this.getDataCriteria();
        this.$store.commit("setMainPageTitleHeader", "CPO - Export");
    },
    updated() {
        // console.log(this.laravelData);
    },
};
</script>

<style></style>
