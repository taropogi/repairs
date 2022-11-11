<template>
    <div>
        <table class="table table-sm border">
            <thead>
                <tr class="table-primary">
                    <th scope="col">Date</th>
                    <th scope="col">Status History</th>
                    <th scope="col">By</th>
                </tr>
            </thead>
            <tbody>
                <history-item
                    v-for="status in headerStatusHistory"
                    :key="status.id"
                    :status="status"
                    :header-statuses="headerStatuses"
                    :all-users="allUsers"
                >
                </history-item>
            </tbody>
        </table>
    </div>
</template>

<script>
import historyItem from "./historyItem.vue";
export default {
    components: {
        historyItem,
    },
    props: ["headerId"],
    // props: ["headerStatusHistory", "headerStatuses", "allUsers"],
    data() {
        return {
            headerStatusHistory: null,
            headerStatuses: null,
            allUsers: null,
        };
    },
    watch: {
        // headerId(value) {
        //     console.log(value);
        //     this.getCpoHeaderRow();
        // },
    },
    methods: {
        getCpoHeaderRow() {
            // console.log("get row");
            axios
                .get("api/cpo/" + this.headerId)
                .then((response) => {
                    this.headerStatusHistory = response.data.cpo.status_history;
                    this.headerStatuses = response.data.header_statuses;
                    this.allUsers = response.data.users;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    mounted() {
        // console.log(this.headerId);
        // console.log(this.headerStatusHistory);
        this.getCpoHeaderRow();
    },
    updated() {
        // this.getCpoHeaderRow();
        // console.log(this.headerId);
        // console.log(this.headerStatusHistory);
    },
};
</script>

<style></style>
