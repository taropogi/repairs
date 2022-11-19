<template>
    <div>
        <h3 class="bg-danger p-2 text-white rounded">
            CPOs-Changed Status
            <span v-if="searchedCount">({{ searchedCount }})</span>
        </h3>
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
        <select
            class="form-select"
            v-model="selectedStatus"
            @change="setChangeStatusTo"
        >
            <option
                v-for="status in cpoStatuses"
                :key="'status-changed-to' + status.id"
                :value="status.id"
            >
                {{ status.status }}
            </option>
        </select>

        <div class="form-check my-3 form-switch">
            <input
                class="form-check-input"
                type="checkbox"
                v-model="onlyCurrentStatus"
                @change="setCurrentOnly"
                id="only-current-status"
            />
            <label class="form-check-label" for="only-current-status">
                Only with this current status
            </label>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
    data() {
        return {
            selectedStatus: 2,
            cpoStatuses: null,
            onlyCurrentStatus: true,
            cpoChangedStatusDate: {
                from:
                    new Date().getFullYear() +
                    "-" +
                    (Number(new Date().getMonth()) + 1) +
                    "-" +
                    new Date().getDate(),
                to:
                    new Date().getFullYear() +
                    "-" +
                    (Number(new Date().getMonth()) + 1) +
                    "-" +
                    new Date().getDate(),
            },
        };
    },
    computed: {
        ...mapGetters("export", ["exportSearched"]),
        searchedCount() {
            return this.exportSearched.byChangedStatus.length;
        },
    },
    methods: {
        ...mapActions("export", [
            "setCpoChangedStatusDate",
            "setCpoChangedStatusTo",
            "setCpoChangedStatusCurrent",
        ]),
        setCurrentOnly() {
            console.log("change");
            this.setCpoChangedStatusCurrent(this.onlyCurrentStatus);
        },
        setChangeStatusTo() {
            this.setCpoChangedStatusTo(this.selectedStatus);
        },
        setChangeStatusDate() {
            this.setCpoChangedStatusDate({
                ...this.cpoChangedStatusDate,
            });
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
        this.setCpoChangedStatusTo(this.selectedStatus);
        this.setCpoChangedStatusCurrent(this.onlyCurrentStatus);
    },
};
</script>

<style></style>
