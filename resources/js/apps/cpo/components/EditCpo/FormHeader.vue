<template>
    <div>
        <modal-status-history
            v-if="showStatusHistory"
            @close="showStatusHistory = false"
            :header-id="headerRow.id"
        ></modal-status-history>
        <spinner-loading
            v-if="!(headerRow && oracleCustomers)"
        ></spinner-loading>
        <form class="row g-3 p-2" @submit.prevent="submitCpoForm" v-else>
            <transition name="updated-header">
                <div class="fixed-top p2" v-if="isSubmitSuccess">
                    <div class="alert alert-success text-center" role="alert">
                        <i class="bi bi-check2-all"></i>
                        <strong>Successful header update!</strong>
                    </div>
                </div>
            </transition>

            <div class="col-md-6">
                <label for="oracle-customer-name" class="form-label">
                    CUSTOMER NAME (ORACLE)
                </label>
                <select
                    size="10"
                    class="form-select"
                    id="oracle-customer-name"
                    v-model="defaultOracleCustomer.id"
                    @change="setDefaultShipToAddress"
                >
                    <option
                        v-for="customer in oracleCustomers"
                        :key="customer.cust_account_id"
                        :value="customer.cust_account_id"
                    >
                        {{ customer.account_name }}
                    </option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="oracle-shipto-address" class="form-label"
                    >SHIPTO ADDRESS (ORACLE)</label
                >

                <textarea
                    style="resize: none"
                    class="form-control"
                    id="oracle-shipto-address"
                    rows="10"
                    disabled
                    v-model="defaultOracleCustomer.shipToAddress"
                ></textarea>
            </div>

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
                <label for="customer-address" class="form-label">Address</label>
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

            <div class="col-md-4">
                <label for="contact-number" class="form-label">Contact #</label>
                <input
                    type="text"
                    class="form-control"
                    id="contact-number"
                    required
                    :disabled="headerRow.locked"
                    v-model="headerRow.contact_number"
                />
            </div>

            <div class="col-md-4">
                <label for="prepared-by" class="form-label">Prepared By</label>
                <input
                    type="text"
                    class="form-control"
                    id="prepared-by"
                    required
                    :disabled="headerRow.locked"
                    v-model="headerRow.prepared_by"
                />
            </div>

            <div class="col-md-4">
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

            <div class="col-md-4">
                <label for="rpo-number" class="form-label">RPO #</label>
                <input
                    type="text"
                    class="form-control"
                    id="rpo-number"
                    required
                    v-model="headerRow.id"
                    disabled
                />
            </div>

            <div class="col-md-4">
                <label for="cpo-statuses" class="form-label"
                    >Status
                    <span class="badge bg-success" v-if="headerRow.locked"
                        >COMPLETED
                    </span>
                </label>
                <select
                    class="form-select"
                    v-model="headerRow.status_id"
                    id="cpo-statuses"
                    :disabled="headerRow.locked"
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

            <div class="btn-group">
                <button type="submit" class="btn btn-success">Update</button>

                <span class="btn btn-warning" @click="showStatusHistory = true"
                    >Status History</span
                >

                <a href="#" class="btn btn-info" @click="printCPOPdf"
                    >Download PDF</a
                >

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
import ModalStatusHistory from "./ModalStatusHistory.vue";
import { mapGetters } from "vuex";
export default {
    components: {
        ModalStatusHistory,
    },
    props: ["id"],
    inject: ["laravelData"],
    data() {
        return {
            headerRow: null,
            isUpdating: false,
            isSubmitSuccess: false,
            defaultOracleCustomer: {
                id: 3234415,
                shipToAddress: "",
            },
            showStatusHistory: false,
        };
    },
    watch: {},
    computed: {
        ...mapGetters(["oracleCustomers"]),
        searchCpoLink() {
            if (this.$store.getters["auth/loggedUser"].is_admin) {
                return "admin-search-cpo";
            }
            return "search-cpo";
        },
        linkGeneratePdf() {
            return this.laravelData.route_list.find(
                (route) => route.routeName === "generate-pdf"
            ).uri;
        },
    },
    methods: {
        printCPOPdf() {
            window.location.href = this.linkGeneratePdf + "/?id=" + this.id;

            // window.location.href =
            //     this.linkGeneratePdf + "/?id=" + this.localHeaderItem.id;
        },
        setDefaultShipToAddress() {
            // console.log(typeof this.defaultOracleCustomer.id);
            const selectedCustomer = this.oracleCustomers.find(
                (el) =>
                    el.cust_account_id === Number(this.defaultOracleCustomer.id)
            );
            this.defaultOracleCustomer.shipToAddress =
                selectedCustomer.address1 +
                " " +
                (selectedCustomer.address2 ?? "") +
                ", " +
                (selectedCustomer.city ?? "") +
                ", " +
                (selectedCustomer.province ?? "");
        },

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

                    if (this.headerRow.oracle_customer_id) {
                        this.defaultOracleCustomer.id =
                            this.headerRow.oracle_customer_id;
                    }

                    this.setDefaultShipToAddress();

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
                .post("api/cpo/update", {
                    ...this.headerRow,
                    oracleId: this.defaultOracleCustomer.id,
                    oracleShipto: this.defaultOracleCustomer.shipToAddress,
                })
                .then((response) => {
                    // console.log(response);
                    this.isSubmitSuccess = true;
                    // console.log("done update");
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

        // this.setDefaultShipToAddress();
    },
};
</script>

<style></style>
