<template>
  <div>
    <loading-overlay :text="'Saving, please wait . . . '" v-if="isEncoding" />
    <h4 class="text-center bg-success text-white p-2">ENCODE CPO</h4>
    <spinner-loading v-if="!oracleCustomers"></spinner-loading>
    <div class="form-container" v-else>
      <form class="row g-1 m-2" @submit.prevent="submitCpoForm">
        <div class="col-md-6 p-2">
          <oracle-customer-input v-model="selectedCustomer" />
        </div>
        <div class="col-md-6 p-2">
          <oracle-customer-details
            :selected-customer-id="selectedCustomer?.id"
          />
        </div>

        <div class="col-md-4">
          <label for="customer-name" class="form-label">Customer Name</label>
          <input
            type="text"
            class="form-control shadow"
            id="customer-name"
            required
            v-model.trim="formData.customerName"
          />
        </div>

        <div class="col-4">
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
          <label for="contact-number" class="form-label">Contact Number</label>
          <input
            type="text"
            class="form-control shadow"
            id="contact-number"
            required
            v-model="formData.contactNumber"
          />
        </div>

        <div class="col-md-4">
          <label for="prepared-by" class="form-label">Prepared By</label>
          <input
            type="text"
            class="form-control shadow"
            id="prepared-by"
            required
            v-model="formData.preparedBy"
          />
        </div>
        <div class="col-md-4">
          <label for="authorized-by" class="form-label">Authorized By</label>
          <input
            type="text"
            class="form-control shadow"
            id="authorized-by"
            required
            v-model="formData.authorizedBy"
          />
        </div>

        <div class="col-md-4">
          <label for="customer-reference-number" class="form-label"
            >Customer Reference Number</label
          >
          <input
            type="text"
            class="form-control shadow"
            id="customer-reference-number"
            required
            v-model="formData.customerReferenceNumber"
          />
        </div>

        <div class="col-12 text-center" v-if="!isEncoding">
          <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import LoadingOverlay from "../UI/LoadingOverlay.vue";
import OracleCustomerDetails from "../UI/OracleCustomerDetails.vue";
import OracleCustomerInput from "../UI/OracleCustomerInput.vue";
export default {
  components: {
    LoadingOverlay,
    OracleCustomerDetails,
    OracleCustomerInput,
  },
  data() {
    return {
      selectedCustomer: null,

      formData: {
        customerName: "",
        customerAddress: "",
        contactNumber: "",
        // rpoNumber: "",
        preparedBy: "",
        authorizedBy: "",
        customerReferenceNumber: "",
      },
      isSubmitSuccess: false,
      isEncoding: false,
    };
  },
  methods: {
    async submitCpoForm() {
      try {
        this.isEncoding = true;
        const res = await axios.post("api/cpo", {
          ...this.formData,
          oracleId: this.selectedCustomer.id,
          oracleShipto: this.selectedCustomer.shipToAddress,
        });
        this.isSubmitSuccess = true;
        this.resetForm();
        // this.gotoSearchPage();
        this.gotoEditCpoPage(res.data.cpo.id);
        setTimeout(() => {
          this.isSubmitSuccess = false;
        }, 3000);
      } catch (error) {
        console.log(error);
      } finally {
        this.isEncoding = false;
      }
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

  mounted() {
    this.$emit("refresh-header-list");
  },
};
</script>

<style scoped>
.form-container {
  max-width: 1200px;
  margin: auto;
  padding: 20px;
  background-color: #f8f9fa;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-label {
  font-weight: bold;
}

.form-control,
.form-select {
  border-radius: 5px;
}

.btn-primary {
  padding: 10px 20px;
  font-size: 1.1rem;
}
</style>
