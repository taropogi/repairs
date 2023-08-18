<template>
    <div class="">
        <h4 class="text-center bg-success text-white p-2">ENCODE CPO</h4>
        <spinner-loading v-if="!oracleCustomers"></spinner-loading>
        <div class="w-75 m-auto" v-else>
            <form class="row g-3 m-2" @submit.prevent="submitCpoForm">
                <div class="col-md-12">
                    <label for="oracle-customer-name" class="form-label">
                        CUSTOMER NAME (ORACLE)
                    </label>
                    <select
                        size="10"
                        class="form-select shadow"
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
                <div class="col-md-12">
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
                        class="form-control shadow"
                        id="customer-name"
                        required
                        v-model.trim="formData.customerName"
                    />
                </div>

                <div class="col-6">
                    <label for="address" class="form-label">Address</label>
                    <input
                        type="text"
                        class="form-control shadow"
                        id="address"
                        required
                        v-model.trim="formData.customerAddress"
                        placeholder="1234 Main St"
                    />
                </div>

                <div class="col-md-4">
                    <label for="contact-number" class="form-label"
                        >Contact Number</label
                    >
                    <input
                        type="text"
                        class="form-control shadow"
                        id="contact-number"
                        required
                        v-model="formData.contactNumber"
                    />
                </div>

                <div class="col-md-4">
                    <label for="prepared-by" class="form-label"
                        >Prepared By</label
                    >
                    <input
                        type="text"
                        class="form-control shadow"
                        id="prepared-by"
                        required
                        v-model="formData.preparedBy"
                    />
                </div>
                <div class="col-md-4">
                    <label for="authorized-by" class="form-label"
                        >Authorized By</label
                    >
                    <input
                        type="text"
                        class="form-control shadow"
                        id="authorized-by"
                        required
                        v-model="formData.authorizedBy"
                    />
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            // oracleCustomers: null,
            defaultOracleCustomer: {
                id: 3234415,
                shipToAddress: "",
            },
            formData: {
                customerName: "",
                customerAddress: "",
                contactNumber: "",
                // rpoNumber: "",
                preparedBy: "",
                authorizedBy: "",
            },
            isSubmitSuccess: false,
        };
    },
    methods: {
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

        async submitCpoForm() {
            // this.isSubmitSuccess = false;
            await axios
                .post("api/cpo", {
                    ...this.formData,
                    oracleId: this.defaultOracleCustomer.id,
                    oracleShipto: this.defaultOracleCustomer.shipToAddress,
                })
                .then((response) => {
                    this.isSubmitSuccess = true;
                    this.resetForm();
                    // this.gotoSearchPage();
                    this.gotoEditCpoPage(response.data.cpo.id);
                    setTimeout(() => {
                        this.isSubmitSuccess = false;
                    }, 3000);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        resetForm() {
            this.formData.customerName = "";
            this.formData.customerAddress = "";
            this.formData.contactNumber = "";
            this.formData.rpoNumber = "";
            this.formData.preparedBy = "";
            this.formData.authorizedBy = "";
        },
        gotoSearchPage() {
            this.$router.push({
                name: this.searchCpoLink,
            });
        },
        gotoEditCpoPage(id) {
            this.$router.push({
                name: this.editHeaderLink,
                params: {
                    id: id,
                },
            });
        },
    },
    computed: {
        ...mapGetters(["oracleCustomers"]),
        ...mapGetters("auth", ["loggedUser"]),
        editHeaderLink() {
            if (this.loggedUser.is_admin) {
                return "admin-edit-cpo";
            }

            return "edit-cpo";
        },
        searchCpoLink() {
            if (this.loggedUser.is_admin) {
                return "admin-search-cpo";
            }
            return "search-cpo";
        },
    },
    beforeCreate() {
        this.$store.commit("setMainPageTitleHeader", "CPO - Encode");
        this.$store.commit("setActiveNav", {
            nav: "encode-cpo",
        });
    },
    mounted() {
        this.setDefaultShipToAddress();
        // this.getOracleCustomers();
        this.$emit("refresh-header-list");
    },
};
</script>
