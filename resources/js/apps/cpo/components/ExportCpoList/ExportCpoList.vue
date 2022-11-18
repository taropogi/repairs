<template>
    <div class="p-2">
        <div class="row">
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
                <table class="table table-sm">
                    <thead>
                        <tr class="table-danger">
                            <th scope="col">RPO #</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">32</th>
                            <td>Mark</td>
                        </tr>
                        <tr>
                            <th scope="row">234</th>
                            <td>Jacob</td>
                        </tr>
                    </tbody>
                </table>
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
export default {
    components: {
        ExportByStatus,
        ExportByModified,
        ByChangeStatus,
        ListByStatus,
        ListByModified,
    },
    inject: ["laravelData"],
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
    },
    beforeCreate() {
        this.$store.commit("setActiveNav", {
            nav: "export-cpo",
        });
    },
    mounted() {
        this.$store.commit("setMainPageTitleHeader", "CPO - Export");
    },
    updated() {
        // console.log(this.laravelData);
    },
};
</script>

<style></style>
