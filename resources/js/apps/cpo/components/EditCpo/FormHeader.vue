<template>
    <form @submit.prevent="submitCpoForm" v-if="headerRow">
        <transition name="updated-header">
            <div class="fixed-top p2" v-if="isSubmitSuccess">
                <div class="alert alert-success text-center" role="alert">
                    <i class="bi bi-check2-all"></i>
                    <strong>Successful header update!</strong>
                </div>
            </div>
        </transition>

        <div class="row">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col">
                        <label>Customer Name</label>
                        <input
                            :disabled="headerRow.locked"
                            type="text"
                            class="form-control form-control-sm"
                            required
                            v-model.trim="headerRow.customer_name"
                        />
                    </div>
                    <div class="col">
                        <label>Customer Address</label>
                        <input
                            :disabled="headerRow.locked"
                            type="text"
                            class="form-control form-control-sm"
                            required
                            v-model.trim="headerRow.customer_address"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Contact Number</label>
                        <input
                            :disabled="headerRow.locked"
                            type="text"
                            class="form-control form-control-sm"
                            required
                            v-model="headerRow.contact_number"
                        />
                    </div>
                    <div class="col">
                        <label>RPO Number</label>
                        <input
                            :disabled="headerRow.locked"
                            type="text"
                            class="form-control form-control-sm"
                            required
                            v-model="headerRow.rpo_number"
                        />
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Prepared By</label>
                        <input
                            :disabled="headerRow.locked"
                            type="text"
                            class="form-control form-control-sm"
                            required
                            v-model="headerRow.prepared_by"
                        />
                    </div>
                    <div class="col">
                        <label>Authorized By</label>
                        <input
                            :disabled="headerRow.locked"
                            type="text"
                            class="form-control form-control-sm"
                            required
                            v-model="headerRow.authorized_by"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label>Status</label>
                        <select
                            class="form-select form-select-sm"
                            v-model="headerRow.status_id"
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
                    <div class="col p-2">
                        <h1 v-if="headerRow.locked">
                            <span class="badge bg-success">COMPLETED </span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <history-list
                    v-if="!isUpdating"
                    :header-id="headerRow.id"
                ></history-list>
            </div>
        </div>

        <div class="btn-group btn-group-sm">
            <button type="submit" class="btn btn-success">Update</button>

            <router-link :to="{ name: searchCpoLink }" class="btn btn-danger"
                >Cancel</router-link
            >
        </div>
    </form>
</template>

<script>
import historyList from "../StatusHistory/historyList.vue";
export default {
    components: {
        historyList,
    },
    props: ["id"],
    data() {
        return {
            headerRow: null,
            isUpdating: false,
            isSubmitSuccess: false,
        };
    },
    computed: {
        searchCpoLink() {
            if (this.$store.getters["auth/loggedUser"].is_admin) {
                return "admin-search-cpo";
            }
            return "search-cpo";
        },
    },
    methods: {
        gotoSearchPage() {
            this.$router.push({
                name: this.searchCpoLink,
            });
        },
        getCpoHeaderRow() {
            // console.log("get row");
            axios
                .get("api/cpo/" + this.id)
                .then((response) => {
                    this.headerStatuses = response.data.header_statuses;
                    this.headerStatus = response.data.cpo.status;

                    this.headerRow = response.data.cpo;
                    this.$emit("searched-header-row", this.headerRow);
                    // console.log("hahahahalskdfjlaskdfjl");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async submitCpoForm() {
            this.isSubmitSuccess = false;
            this.isUpdating = true;
            //   console.log("submit edit");
            // console.log(this.headerRow);
            await axios
                .post("api/cpo/update", this.headerRow)
                .then((response) => {
                    // console.log(response);
                    this.isSubmitSuccess = true;
                    console.log("done update");
                    // this.gotoSearchPage();
                    this.getCpoHeaderRow();

                    this.isUpdating = false;
                    setTimeout(() => {
                        this.isSubmitSuccess = false;
                    }, 3000);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    mounted() {
        this.getCpoHeaderRow();
    },
};
</script>

<style></style>
