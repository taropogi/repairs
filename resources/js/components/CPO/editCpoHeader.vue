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

        <h5 class="text-center p-2 bg-warning text-white">LINE DETAILS</h5>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">HCopy</th>
                    <th scope="col">Qty Returned</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Qty Inspect</th>
                    <th scope="col">Date</th>
                    <th scope="col">Good Condition</th>
                    <th scope="col">Minor Repair/Clean</th>
                    <th scope="col">Repair/Parts Needed</th>
                    <th scope="col">Damaged</th>
                    <th scope="col">Comments</th>
                    <th scope="col">Doc #</th>
                </tr>
            </thead>
            <tbody>
                <edit-header-line
                    v-for="item in lineDetails"
                    :key="item.id"
                    :lineDetails="item"
                ></edit-header-line>
            </tbody>
        </table>
    </div>
</template>

<script>
import editHeaderLine from "./editHeaderLine.vue";
export default {
    components: {
        editHeaderLine,
    },
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
            lineDetails: [],
            isSubmitSuccess: false,
        };
    },
    methods: {
        getCpoHeaderRow() {
            axios
                .get("/repairs/api/cpo/" + this.id)
                .then((response) => {
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
                    this.lineDetails = [];
                    const responseLines = response.data.lines;

                    for (const key in responseLines) {
                        const line = responseLines[key];
                        this.lineDetails.push({
                            id: line.id,
                            lineNumber: line.line_number,
                            description: line.description,
                            price: line.price,
                            hcopy: line.hcopy,
                            qtyReturned: line.qty_returned,
                            unit: line.unit,
                            qtyInspect: line.qty_inspect,
                            goodCondition: 5,
                            minorRepairClean: 5,
                            repairPartsNeeded: 5,
                            damaged: 0,
                            comments: line.comments,
                        });
                    }

                    // console.log(lines.length);
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
