<template>
    <div>
        <!-- <h4 class="text-center bg-primary text-white p-2">ENCODE</h4> -->
        <form @submit.prevent="submitCpoForm">
            <transition name="encode-cpo-success">
                <div v-if="isSubmitSuccess" class="fixed-top">
                    <div class="alert alert-success text-center" role="alert">
                        <i class="bi bi-check2-all"></i>
                        <strong
                            >A new CPO header has been successfully
                            inserted.</strong
                        >
                    </div>
                </div>
            </transition>

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

            <button type="submit" class="btn btn-sm btn-primary mt-2">
                Submit
            </button>
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
        async submitCpoForm() {
            // this.isSubmitSuccess = false;
            await axios
                .post("api/cpo", this.formData)
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
        editHeaderLink() {
            if (this.$store.getters["auth/loggedUser"].is_admin) {
                return "admin-edit-cpo";
            }

            return "edit-cpo";
        },
        searchCpoLink() {
            if (this.$store.getters["auth/loggedUser"].is_admin) {
                return "admin-search-cpo";
            }
            return "search-cpo";
        },
    },
    beforeCreate() {
        this.$store.commit("setMainPageTitleHeader", "CPO - Encode");
    },
    mounted() {
        this.$emit("refresh-header-list");
    },
};
</script>

<style>
.encode-cpo-success-enter-from {
    opacity: 0;
    transform: translateY(-30px);
}

.encode-cpo-success-enter-active {
    transition: all 0.5s ease-out;
}
.encode-cpo-success-enter-to {
    opacity: 1;
    transform: translateY(0);
}

.encode-cpo-success-leave-from {
    opacity: 1;
    transform: translateY(0);
}

.encode-cpo-success-leave-active {
    transition: all 0.5s ease-in;
}
.encode-cpo-success-leave-to {
    opacity: 0;
    transform: translateY(-30px);
}
</style>
