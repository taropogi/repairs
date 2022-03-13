<template>
    <div>
        <h4 class="text-center bg-warning text-white p-2">UPDATE</h4>
        <form @submit.prevent="submitCpoForm" class="border border-warning p-2">
            <div
                v-if="isSubmitSuccess"
                class="alert alert-success"
                role="alert"
            >
                Successful update!
            </div>
            <div class="row">
                <div class="col">
                    <label>Customer Name</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        required
                        v-model.trim="formData.customerName"
                    />
                </div>
                <div class="col">
                    <label>Customer Address</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        required
                        v-model.trim="formData.customerAddress"
                    />
                </div>
                <div class="col">
                    <label>Contact Number</label>
                    <input
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
                        type="text"
                        class="form-control form-control-sm"
                        required
                        v-model="formData.rpoNumber"
                    />
                </div>
                <div class="col">
                    <label>Prepared By</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        required
                        v-model="formData.preparedBy"
                    />
                </div>
                <div class="col">
                    <label>Authorized By</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        required
                        v-model="formData.authorizedBy"
                    />
                </div>
            </div>

            <button type="submit" class="btn btn-warning btn-sm mt-2">
                Update
            </button>
            |
            <router-link
                :to="{ name: 'search-cpo' }"
                class="btn btn-danger mt-2 btn-sm"
                >Cancel</router-link
            >
        </form>
    </div>
</template>

<script>
export default {
    props: ["id"],
    watch: {
        id(id) {
            this.getCpoHeaderRow();
        },
    },
    data() {
        return {
            formData: {
                customerName: "",
                customerAddress: "",
                contactNumber: "",
                rpoNumber: "",
                preparedBy: "",
                authorizedBy: "",
            },
            isSubmitSuccess: false,
        };
    },
    methods: {
        getCpoHeaderRow() {
            axios
                .get("/repairs/api/cpo/" + this.id)
                .then((response) => {
                    this.formData.customerName = response.data.customer_name;
                    this.formData.customerAddress =
                        response.data.customer_address;
                    this.formData.contactNumber = response.data.contact_number;
                    this.formData.rpoNumber = response.data.rpo_number;
                    this.formData.preparedBy = response.data.prepared_by;
                    this.formData.authorizedBy = response.data.authorized_by;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        submitCpoForm() {
            this.isSubmitSuccess = false;
            axios
                .post("/repairs/api/cpo", this.formData)
                .then((response) => {
                    this.isSubmitSuccess = true;
                    this.resetForm();
                    this.$emit("inserted-cpo-header");
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
    },
    beforeCreate() {
        this.$store.commit("setMainPageTitleHeader", "CPO - Edit");
    },
    mounted() {
        this.getCpoHeaderRow();
    },
};
</script>

<style></style>
