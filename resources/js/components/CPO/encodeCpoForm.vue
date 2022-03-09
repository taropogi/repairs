<template>
    <form @submit.prevent="submitCpoForm">
        <div class="row my-2">
            <div class="col">
                <label>Customer Name</label>
                <input
                    type="text"
                    class="form-control"
                    required
                    v-model="formData.customerName"
                />
            </div>
            <div class="col">
                <label>Customer Address</label>
                <input
                    type="text"
                    class="form-control"
                    required
                    v-model="formData.customerAddress"
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

        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
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
        };
    },
    methods: {
        submitCpoForm() {
            axios
                .post("/repairs/api/cpo", this.formData)
                .then(function (response) {
                    console.log(response);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style></style>
