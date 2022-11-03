<template>
    <div>
        <table class="table table-sm">
            <thead class="table-warning">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">HCopy</th>
                    <th scope="col">Qty Returned</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Qty Inspect</th>
                    <th scope="col">Date</th>
                    <th scope="col">Good Condition</th>
                    <th scope="col">Minor Repair/Clean</th>
                    <th scope="col">Repair/Parts Needed</th>
                    <th scope="col">Damaged</th>
                    <th scope="col">Comments</th>
                    <th scope="col">Doc #</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <header-line
                    v-for="line in linesDetails"
                    :key="line.id"
                    :line-details="line"
                    :header-is-locked="headerIsLocked"
                ></header-line>
            </tbody>
        </table>
    </div>
</template>

<script>
import headerLine from "./headerLine.vue";
export default {
    components: {
        headerLine,
    },
    props: ["linesDetails", "headerIsLocked"],
};
</script>

<style></style>
