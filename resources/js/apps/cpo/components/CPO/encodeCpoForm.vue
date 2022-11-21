<template>
    <div class="p-1">
        <!-- <transition name="encode-cpo-success">
            <div v-if="isSubmitSuccess" class="fixed-top">
                <div class="alert alert-success text-center" role="alert">
                    <i class="bi bi-check2-all"></i>
                    <strong
                        >A new CPO header has been successfully
                        inserted.</strong
                    >
                </div>
            </div>
        </transition> -->

        <form class="row g-3 p-5 border" @submit.prevent="submitCpoForm">
            <div class="col-md-6">
                <label for="customer-name" class="form-label"
                    >Customer Name</label
                >
                <input
                    type="text"
                    class="form-control"
                    id="customer-name"
                    required
                    v-model.trim="formData.customerName"
                />
            </div>
            <div class="col-md-6">
                <label for="contact-number" class="form-label"
                    >Contact Number</label
                >
                <input
                    type="text"
                    class="form-control"
                    id="contact-number"
                    required
                    v-model="formData.contactNumber"
                />
            </div>
            <div class="col-12">
                <label for="address" class="form-label">Address</label>
                <input
                    type="text"
                    class="form-control"
                    id="address"
                    required
                    v-model.trim="formData.customerAddress"
                    placeholder="1234 Main St"
                />
            </div>

            <div class="col-md-4">
                <label for="prepared-by" class="form-label">Prepared By</label>
                <input
                    type="text"
                    class="form-control"
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
                    class="form-control"
                    id="authorized-by"
                    required
                    v-model="formData.authorizedBy"
                />
            </div>
            <!-- <div class="col-md-4">
                <label for="rpo-number" class="form-label">RPO #</label>
                <input
                    type="text"
                    class="form-control"
                    id="rpo-number"
                    required
                    v-model="formData.rpoNumber"
                />
            </div> -->

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
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
                // rpoNumber: "",
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
        this.$store.commit("setActiveNav", {
            nav: "encode-cpo",
        });
    },
    mounted() {
        this.$emit("refresh-header-list");
    },
};
</script>

<style>
/* .encode-cpo-success-enter-from {
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
} */
</style>
