<template>
    <div>
        <h3 class="bg-primary p-2 text-white rounded">CPO Status</h3>
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
        ...mapGetters("export", ["selectedStatus"]),
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
