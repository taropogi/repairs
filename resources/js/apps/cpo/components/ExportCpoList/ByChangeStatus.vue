<template>
    <div>
        <h3 class="bg-danger p-2 text-white rounded">CPOs-Changed Status</h3>
        <span>Kindly specify a date range </span>
        <div class="my-3">
            <label for="date-change-status-from" class="form-label">From</label>
            <input
                v-model="cpoChangedStatusDate.from"
                type="date"
                class="form-control"
                id="date-change-status-from"
                @change="setChangeStatusDate"
            />
        </div>

        <div class="mb-3">
            <label for="date-change-status-to" class="form-label">To</label>
            <input
                v-model="cpoChangedStatusDate.to"
                type="date"
                class="form-control"
                id="date-change-status-to"
                @change="setChangeStatusDate"
            />
        </div>
        Changed Status to:
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
</template>

<script>
export default {
    data() {
        return {
            cpoStatuses: null,
            cpoChangedStatusDate: {
                from: new Date().toISOString().slice(0, 10),
                to: new Date().toISOString().slice(0, 10),
            },
        };
    },
    methods: {
        setChangeStatusDate() {
            console.log("changed");
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
    mounted() {
        this.getDataCriteria();
    },
};
</script>

<style></style>
