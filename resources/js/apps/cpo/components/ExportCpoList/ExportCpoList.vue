<template>
    <div>
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
                            checked
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

        <button class="btn btn-primary">Search</button>
        <button class="btn btn-primary">Export</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            cpoStatuses: null,
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
    computed: {},
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
        this.$store.commit("setMainPageTitleHeader", "CPO - Export");
    },
};
</script>

<style></style>
