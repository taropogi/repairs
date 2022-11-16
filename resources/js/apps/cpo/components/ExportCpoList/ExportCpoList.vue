<template>
    <div class="p-2">
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label class="form-label">CPO Status</label>
                    <div
                        class="form-check"
                        v-for="status in cpoStatuses"
                        :key="status.id + status.status"
                    >
                        <input
                            class="form-check-input"
                            type="checkbox"
                            :value="status.id"
                            v-model="selectedStatuses"
                            :id="status.id + 'status'"
                        />
                        <label
                            class="form-check-label"
                            :for="status.id + 'status'"
                        >
                            {{ status.status }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="date-modified-from" class="form-label"
                                >CPOs Modified From
                            </label>
                            <input
                                v-model="cpoModifiedDate.from"
                                type="date"
                                class="form-control"
                                id="date-modified-from"
                            />
                        </div>

                        <div class="mb-3">
                            <label for="date-modified-to" class="form-label"
                                >CPOs Modified From</label
                            >
                            <input
                                v-model="cpoModifiedDate.to"
                                type="date"
                                class="form-control"
                                id="date-modified-to"
                            />
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label
                                for="date-change-status-from"
                                class="form-label"
                                >CPOs Change Status From</label
                            >
                            <input
                                v-model="cpoChangedStatusDate.from"
                                type="date"
                                class="form-control"
                                id="date-change-status-from"
                            />
                        </div>

                        <div class="mb-3">
                            <label
                                for="date-change-status-to"
                                class="form-label"
                                >CPOs Change Status To</label
                            >
                            <input
                                v-model="cpoChangedStatusDate.to"
                                type="date"
                                class="form-control"
                                id="date-change-status-to"
                            />
                        </div>
                        Changed to
                        <select class="form-select">
                            <option
                                v-for="status in cpoStatuses"
                                :key="'status-changed-to' + status.id"
                                :value="status.id"
                            >
                                {{ status.status }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="btn-group" role="group">
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
export default {
    inject: ["laravelData"],
    data() {
        return {
            cpoStatuses: null,
            selectedStatuses: [],
            cpoModifiedDate: {
                from: new Date().toISOString().slice(0, 10),
                to: new Date().toISOString().slice(0, 10),
            },
            cpoChangedStatusDate: {
                from: new Date().toISOString().slice(0, 10),
                to: new Date().toISOString().slice(0, 10),
            },
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
