<template>
    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
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
</template>

<script>
import historyItem from "./historyItem.vue";
export default {
    components: {
        historyItem,
    },
    props: ["headerStatusHistory", "headerStatuses", "allUsers"],
};
</script>

<style></style>
