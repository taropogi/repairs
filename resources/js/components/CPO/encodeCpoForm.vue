<template>
    <form @submit.prevent="submitCpoForm">
        <div class="row my-2">
            <div class="col">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Customer name"
                    aria-label="Customer name"
                    required
                    v-model="formData.customerName"
                />
            </div>
            <div class="col">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Customer address"
                    aria-label="Customer address"
                    required
                    v-model="formData.customerAddress"
                />
            </div>
        </div>
        <div class="row my-2">
            <div class="col">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Contact number"
                    aria-label="Contact number"
                    required
                    v-model="formData.contactNumber"
                />
            </div>
            <div class="col">
                <input
                    type="text"
                    class="form-control"
                    placeholder="RPO number"
                    aria-label="RPO number"
                    required
                    v-model="formData.rpoNumber"
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
