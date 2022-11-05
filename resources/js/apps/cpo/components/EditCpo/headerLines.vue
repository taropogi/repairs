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
                    v-for="(line, index) in lines"
                    :key="line.id"
                    :line-number="index + 1"
                    :line-details="line"
                    :header-is-locked="headerIsLocked"
                    @delete-line="getCpoLines"
                ></header-line>
            </tbody>
        </table>

        <div
            class="btn-group btn-group-sm"
            role="group"
            aria-label="Basic example"
        >
            <button
                v-if="!isInsertingNewLine"
                class="btn btn-primary"
                @click="addNewLine"
            >
                Add new line
            </button>
            <button class="btn btn-primary" type="button" disabled v-else>
                Add new line
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                ></span>
            </button>
            <button
                class="btn btn-success"
                @click="saveAllLines"
                v-if="!isSavingAllLines"
            >
                Save All lines
            </button>
            <button class="btn btn-success" type="button" disabled v-else>
                Save All lines
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                ></span>
            </button>
        </div>
    </div>
</template>

<script>
import headerLine from "./headerLine.vue";
export default {
    components: {
        headerLine,
    },
    props: ["headerId", "headerIsLocked"],
    data() {
        return {
            lines: [],
            isInsertingNewLine: false,
            isSavingAllLines: false,
        };
    },

    methods: {
        addNewLine() {
            this.isInsertingNewLine = true;
            axios
                .post("/repairs/api/cpoline/", { id: this.headerId })
                .then((res) => {
                    this.getCpoLines();
                    this.isInsertingNewLine = false;
                    // console.log(this.lineDetails);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        saveAllLines() {
            this.isSavingAllLines = true;

            axios
                .post("/repairs/api/cpo/lines/updateAllLines/", {
                    cpoId: this.headerId,
                    cpoLines: this.lines,
                })
                .then((res) => {
                    this.isSavingAllLines = false;
                    //this.getCpoLines();
                    // this.isUpdatedAllLinesSuccess = true;
                    // console.log("save all", res);
                    // this.getCpoHeaderRow();
                    // this.$emit("updated-header-lines");
                    // setTimeout(() => {
                    //     this.isUpdatedAllLinesSuccess = false;
                    // }, 3000);
                    // console.log(res.data);
                    // console.log("saved all");
                })
                .catch((err) => {
                    // console.log(err);
                });
        },
        getCpoLines() {
            axios
                .get("/repairs/api/cpo/lines/" + this.headerId)
                .then((response) => {
                    this.lines = response.data.lines;
                    //console.log(this.lines);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    mounted() {
        this.getCpoLines();
        console.log("headerId: " + this.headerId);
    },
};
</script>

<style></style>
