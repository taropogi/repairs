<template>
    <div class="p-2">
        <form @submit.prevent="submitCpoForm">
            <h4 class="text-center bg-primary p-2 text-white">
                Encode CPO Headers
            </h4>

            <div
                v-if="isSubmitSuccess"
                class="alert alert-success"
                role="alert"
            >
                Successful insert!
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

                <div class="col">
                    <label>Contact Number</label>
                    <input
                        type="text"
                        class="form-control"
                        required
                        v-model="formData.contactNumber"
                    />
                </div>
            </div>
            <div class="row my-2">
                <div class="col">
                    <label>RPO Number</label>
                    <input
                        type="text"
                        class="form-control"
                        required
                        v-model="formData.rpoNumber"
                    />
                </div>

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

            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
</template>

<script>
export default {
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
