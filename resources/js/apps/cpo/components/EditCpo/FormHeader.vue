<template>
    <div>
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
                        <div class="col-md-6">
                            <label for="customer-name" class="form-label"
                                >Customer Name</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="customer-name"
                                required
                                :disabled="headerRow.locked"
                                v-model.trim="headerRow.customer_name"
                            />
                        </div>
                        <div class="col-md-6">
                            <label for="contact-number" class="form-label"
                                >Contact #</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="contact-number"
                                required
                                :disabled="headerRow.locked"
                                v-model="headerRow.contact_number"
                            />
                        </div>
                        <div class="col-12">
                            <label for="customer-address" class="form-label"
                                >Address</label
                            >
                            <input
                                :disabled="headerRow.locked"
                                type="text"
                                class="form-control"
                                id="customer-address"
                                placeholder="1234 Main St"
                                required
                                v-model.trim="headerRow.customer_address"
                            />
                        </div>

                        <div class="col-md-6">
                            <label for="prepared-by" class="form-label"
                                >Prepared By</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="prepared-by"
                                required
                                :disabled="headerRow.locked"
                                v-model="headerRow.prepared_by"
                            />
                        </div>
                        <div class="col-md-6">
                            <label for="authorized-by" class="form-label"
                                >Authorized By</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="prepared-by"
                                required
                                :disabled="headerRow.locked"
                                v-model="headerRow.authorized_by"
                            />
                        </div>
                        <div class="col-md-6">
                            <label for="rpo-number" class="form-label"
                                >RPO #</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="rpo-number"
                                required
                                v-model="headerRow.id"
                                disabled
                            />
                        </div>

                        <div class="col-md-6">
                            <label for="cpo-statuses" class="form-label"
                                >Status
                                <span
                                    class="badge bg-success"
                                    v-if="headerRow.locked"
                                    >COMPLETED
                                </span>
                            </label>
                            <select
                                class="form-select"
                                v-model="headerRow.status_id"
                                id="cpo-statuses"
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
                    </div>
                </div>
                <div class="col-sm-6">
                    <history-list
                        v-if="!isUpdating"
                        :header-id="headerRow.id"
                    ></history-list>
                </div>
            </div>

            <div class="btn-group py-2">
                <button type="submit" class="btn btn-success">Update</button>

                <router-link
                    :to="{ name: searchCpoLink }"
                    class="btn btn-danger"
                    >Cancel</router-link
                >
            </div>
        </form>
    </div>
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
