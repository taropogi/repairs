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

        <div class="p-2" v-for="item in lineDetails" :key="item.id">
            <div class="row">
                <div class="col-sm-1">
                    <h1>{{ item.id }}</h1>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <label>Description</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model.trim="item.description"
                            />
                        </div>
                        <div class="col">
                            <label>Price</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="item.price"
                            />
                        </div>
                        <div class="col">
                            <label>HC</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="item.hcopy"
                            />
                        </div>
                        <div class="col">
                            <label>Qty Returned</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model.trim="item.qtyReturned"
                            />
                        </div>
                        <div class="col">
                            <label>Unit</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="item.unit"
                            />
                        </div>
                        <div class="col">
                            <label>Qty Inspect</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="item.qtyInspect"
                            />
                        </div>
                        <div class="col">
                            <label>Date</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="item.qtyInspect"
                            />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label>Good Condition</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="item.goodCondition"
                            />
                        </div>
                        <div class="col">
                            <label>Minor Repair / Clean</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="item.minorRepairClean"
                            />
                        </div>
                        <div class="col">
                            <label>Repair / Parts Needed</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="item.repairPartsNeeded"
                            />
                        </div>
                        <div class="col">
                            <label>Damaged</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="item.damaged"
                            />
                        </div>
                        <div class="col">
                            <label>Comments</label>
                            <textarea
                                class="form-control"
                                v-model="item.comments"
                                rows="2"
                            ></textarea>
                        </div>
                        <div class="col">
                            <label>Doc#</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="item.comments"
                            />
                        </div>
                        <div class="col">
                            <label>Doc#</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="item.comments"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <hr />
        </div>
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
                            comments: "",
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
