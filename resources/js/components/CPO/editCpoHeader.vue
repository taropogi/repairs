<template>
    <form @submit.prevent="submitCpoForm">
        <h4 class="text-center bg-warning p-2 text-white">Update CPO Header</h4>

        <div v-if="isSubmitSuccess" class="alert alert-success" role="alert">
            Successful update!
        </div>
        <div class="row my-2">
            <div class="col">
                <label>Customer Name</label>
                <input
                    type="text"
                    class="form-control"
                    required
                    v-model.trim="formData.customerName"
                />
            </div>
            <div class="col">
                <label>Customer Address</label>
                <input
                    type="text"
                    class="form-control"
                    required
                    v-model.trim="formData.customerAddress"
                />
            </div>
        </div>
        <div class="row my-2">
            <div class="col">
                <label>Contact Number</label>
                <input
                    type="text"
                    class="form-control"
                    required
                    v-model="formData.contactNumber"
                />
            </div>
            <div class="col">
                <label>RPO Number</label>
                <input
                    type="text"
                    class="form-control"
                    required
                    v-model="formData.rpoNumber"
                />
            </div>
        </div>

        <div class="row my-2">
            <div class="col">
                <label>Prepared By</label>
                <input
                    type="text"
                    class="form-control"
                    required
                    v-model="formData.preparedBy"
                />
            </div>
            <div class="col">
                <label>Authorized By</label>
                <input
                    type="text"
                    class="form-control"
                    required
                    v-model="formData.authorizedBy"
                />
            </div>
        </div>

        <button type="submit" class="btn btn-warning mt-2">Update</button>
    </form>
</template>

<script>
export default {
    props: ["cpoItemHeader"],
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
};
</script>

<style></style>
