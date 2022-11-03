<template>
    <div>
        <h4
            class="text-center text-white p-2"
            :class="{
                'bg-warning': !formData.locked,
                'bg-secondary': formData.locked,
            }"
        >
            UPDATE
        </h4>

        <form @submit.prevent="submitCpoForm" class="border border-warning p-2">
            <transition name="updated-header">
                <div class="fixed-top p2" v-if="isSubmitSuccess">
                    <div class="alert alert-success text-center" role="alert">
                        <i class="bi bi-check2-all"></i>
                        <strong>Successful header update!</strong>
                    </div>
                </div>
            </transition>
            <transition name="saved-all-lines">
                <div class="fixed-top p2" v-if="isUpdatedAllLinesSuccess">
                    <div class="alert alert-success text-center" role="alert">
                        <i class="bi bi-check2-all"></i>
                        <strong>Lines updated!</strong>
                    </div>
                </div>
            </transition>
            <div class="row">
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col">
                            <label>Customer Name</label>
                            <input
                                :disabled="formData.locked"
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model.trim="formData.customerName"
                            />
                        </div>
                        <div class="col">
                            <label>Customer Address</label>
                            <input
                                :disabled="formData.locked"
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model.trim="formData.customerAddress"
                            />
                        </div>
                        <div class="col">
                            <label>Contact Number</label>
                            <input
                                :disabled="formData.locked"
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="formData.contactNumber"
                            />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>RPO Number</label>
                            <input
                                :disabled="formData.locked"
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="formData.rpoNumber"
                            />
                        </div>

                        <div class="col">
                            <label>Prepared By</label>
                            <input
                                :disabled="formData.locked"
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="formData.preparedBy"
                            />
                        </div>
                        <div class="col">
                            <label>Authorized By</label>
                            <input
                                :disabled="formData.locked"
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="formData.authorizedBy"
                            />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label>Status</label>
                            <select
                                class="form-select form-select-sm"
                                v-model="formData.status_id"
                            >
                                <option
                                    v-for="status in headerStatuses"
                                    :key="status.id"
                                    :value="status.id"
                                    :selected="status.id === headerStatus.id"
                                >
                                    {{ status.status }}
                                </option>
                            </select>
                        </div>
                        <div class="col"></div>
                        <div class="col"></div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label>Status History</label>
                    <history-list
                        :header-status-history="headerStatusHistory"
                        :header-statuses="headerStatuses"
                        :all-users="allUsers"
                    ></history-list>
                </div>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    :checked="formData.locked"
                    :id="'locked' + formData.id"
                    v-model="formData.locked"
                />
                <label class="form-check-label" :for="'locked' + formData.id">
                    Lock <i class="bi bi-file-lock2"></i>
                </label>
            </div>

            <div
                class="btn-group btn-group-sm"
                role="group"
                aria-label="Basic mixed styles example"
            >
                <button type="submit" class="btn btn-success">
                    Update & redirect to search
                </button>
                <button type="submit" class="btn btn-primary">Save</button>
                <router-link :to="{ name: 'search-cpo' }" class="btn btn-danger"
                    >Cancel</router-link
                >
            </div>
        </form>

        <h5
            class="text-center p-2 text-white"
            :class="{
                'bg-warning': !formData.locked,
                'bg-secondary': formData.locked,
            }"
        >
            LINE DETAILS
        </h5>
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
                <edit-header-line
                    v-for="(item, index) in lineDetails"
                    :headerIsLocked="formData.locked"
                    :key="item.id"
                    :lineDetails="item"
                    @delete-line="deleteLine"
                    @save-line="saveLine"
                    @changed-line-value="changedLineValue"
                    :line-index="index"
                    :line-number="item.lineNumber"
                ></edit-header-line>
            </tbody>
        </table>
        <div class="spinner-border" role="status" v-if="isInsertingNewLine">
            <span class="visually-hidden">Loading...</span>
        </div>
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
            <button class="btn btn-success" @click="saveAllLines">
                Save All
            </button>
        </div>
    </div>
</template>

<script>
import editHeaderLine from "./editHeaderLine.vue";
import historyList from "../StatusHistory/historyList.vue";

export default {
    components: {
        editHeaderLine,
        historyList,
    },
    props: ["id"],
    watch: {
        id(id) {
            this.getCpoHeaderRow();
        },
    },
    data() {
        return {
            //   headerDetails: null,
            headerStatus: null,
            headerStatusHistory: null,
            headerStatuses: null,
            allUsers: null,
            formData: {
                id: 0,
                customerName: "",
                customerAddress: "",
                contactNumber: "",
                rpoNumber: "",
                preparedBy: "",
                authorizedBy: "",
                locked: "",
            },
            lineDetails: [],
            isSubmitSuccess: false,
            isInsertingNewLine: false,
            isUpdatedAllLinesSuccess: false,
        };
    },
    methods: {
        saveAllLines() {
            this.isUpdatedAllLinesSuccess = false;
            axios
                .post("/repairs/api/cpo/lines/updateAllLines/", {
                    cpoId: this.id,
                    cpoLines: this.lineDetails,
                })
                .then((res) => {
                    this.isUpdatedAllLinesSuccess = true;
                    // console.log("save all", res);
                    this.getCpoHeaderRow();
                    this.$emit("updated-header-lines");
                    setTimeout(() => {
                        this.isUpdatedAllLinesSuccess = false;
                    }, 3000);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        changedLineValue(args) {
            // console.log(args);
            this.lineDetails[args.lineIndex] = args.itemRow;
        },
        saveLine(lineRow) {
            axios
                .post("/repairs/api/cpoline/update/", lineRow)
                .then((res) => {
                    //   console.log(res);
                    this.getCpoHeaderRow();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        deleteLine(lineId) {
            axios
                .post("/repairs/api/cpoline/destroy/", { id: lineId })
                .then((res) => {
                    //console.log(res);
                    this.getCpoHeaderRow();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        addNewLine() {
            this.isInsertingNewLine = true;
            axios
                .post("/repairs/api/cpoline/", { id: this.id })
                .then((res) => {
                    this.getCpoHeaderRow();
                    this.isInsertingNewLine = false;
                    console.log(this.lineDetails);
                })
                .catch((err) => {
                    console.log(err);
                });
        },

        refreshHeaderLines(responseLines) {
            this.lineDetails = [];
            for (const key in responseLines) {
                const line = responseLines[key];

                this.lineDetails.push({
                    id: line.id,
                    lineNumber: line.line_number,
                    description: line.description,
                    price: line.price,
                    hcopy: line.hcopy,
                    qtyReturned: line.qty_returned,
                    unit: line.unit,
                    qtyInspect: line.qty_inspect,
                    goodCondition: line.good_condition,
                    minorRepairClean: line.minor_repair_clean,
                    repairPartsNeeded: line.repair_parts_needed,
                    damaged: line.damaged,
                    comments: line.comments,
                });
            }
        },

        getCpoHeaderRow() {
            axios
                .get("/repairs/api/cpo/" + this.id)
                .then((response) => {
                    // console.log(response);
                    this.formData.id = response.data.cpo.id;
                    this.formData.customerName =
                        response.data.cpo.customer_name;
                    this.formData.customerAddress =
                        response.data.cpo.customer_address;
                    this.formData.contactNumber =
                        response.data.cpo.contact_number;
                    this.formData.rpoNumber = response.data.cpo.rpo_number;
                    this.formData.preparedBy = response.data.cpo.prepared_by;
                    this.formData.authorizedBy =
                        response.data.cpo.authorized_by;
                    this.formData.locked = response.data.cpo.locked;
                    this.formData.status_id = response.data.cpo.status_id;

                    this.headerStatuses = response.data.header_statuses;
                    this.headerStatus = response.data.cpo.status;
                    this.headerStatusHistory = response.data.cpo.status_history;

                    this.allUsers = response.data.users;

                    //  this.headerDetails = response.data.cpo;
                    // console.log(this.headerStatus);

                    const responseLines = response.data.lines;
                    this.refreshHeaderLines(responseLines);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        submitCpoForm() {
            this.isSubmitSuccess = false;

            axios
                .post("/repairs/api/cpo/update", this.formData)
                .then((response) => {
                    // console.log(response);
                    this.isSubmitSuccess = true;

                    this.$emit("updated-cpo-header");

                    setTimeout(() => {
                        this.isSubmitSuccess = false;
                    }, 3000);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    beforeCreate() {
        this.$store.commit("setMainPageTitleHeader", "CPO - Edit");
    },
    mounted() {
        this.getCpoHeaderRow();
    },
};
</script>

<style scoped>
.updated-header-enter-from {
    opacity: 0;
    transform: translateY(-30px);
}

.updated-header-enter-active {
    transition: all 0.3s ease-out;
}
.updated-header-enter-to {
    opacity: 1;
    transform: translateY(0);
}

.updated-header-leave-from {
    opacity: 1;
    transform: translateY(0);
}

.updated-header-leave-active {
    transition: all 0.3s ease-in;
}
.updated-header-leave-to {
    opacity: 0;
    transform: translateY(-30px);
}

.saved-all-lines-enter-from {
    opacity: 0;
    transform: translateY(-30px);
}

.saved-all-lines-enter-active {
    transition: all 0.3s ease-out;
}
.saved-all-lines-enter-to {
    opacity: 1;
    transform: translateY(0);
}

.saved-all-lines-leave-from {
    opacity: 1;
    transform: translateY(0);
}

.saved-all-lines-leave-active {
    transition: all 0.3s ease-in;
}
.saved-all-lines-leave-to {
    opacity: 0;
    transform: translateY(-30px);
}
</style>
