<template>
    <div>
        <!-- <h4
            class="text-center text-white p-2"
            :class="{
                'bg-warning': !formData.locked,
                'bg-secondary': formData.locked,
            }"
        >
            UPDATE HEADER
        </h4> -->

        <form @submit.prevent="submitCpoForm">
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

            <div class="btn-group btn-group-sm">
                <button type="submit" class="btn btn-success">Update</button>

                <router-link :to="{ name: 'search-cpo' }" class="btn btn-danger"
                    >Cancel</router-link
                >
            </div>
        </form>

        <header-lines
            :header-id="id"
            :header-is-locked="formData.locked"
            :test-value="'the value'"
        ></header-lines>

        <div class="btn-group btn-group-sm"></div>
    </div>
</template>

<script>
import headerLines from "./headerLines.vue";
import historyList from "../StatusHistory/historyList.vue";

export default {
    components: {
        headerLines,
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

            isSubmitSuccess: false,

            isUpdatedAllLinesSuccess: false,
        };
    },
    methods: {
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
        // console.log("old value: " + this.lineDetails.length);
        this.getCpoHeaderRow();
    },
    updated() {
        //   console.log("new value: " + this.lineDetails.length);
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
