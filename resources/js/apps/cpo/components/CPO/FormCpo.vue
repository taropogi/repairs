<template>
  <div>
    <loading-overlay :text="'Saving, please wait . . . '" v-if="isEncoding" />
    <h4 class="text-center bg-success text-white p-2" v-if="!isConfirming">
      ENCODE CPO
    </h4>
    <h4 class="text-center bg-warning p-2" v-else>CONFIRM DETAILS</h4>
    <spinner-loading v-if="!oracleCustomers"></spinner-loading>
    <div v-else>
      <form @submit.prevent="submitConfirm">
        <div class="row g-1 m-2 py-2" v-show="!isConfirming">
          <div
            class="p-2 bg-light"
            :class="{
              'col-2': !formData.has_oracle_customer,
              'col-4': formData.has_oracle_customer,
            }"
          >
            <label class="form-label mb-0 p-2 d-block"
              >CUSTOMER SELECTION</label
            >
            <br />
            <div class="form-check form-check-inline">
              <input
                class="form-check-input"
                type="radio"
                name="customerSelection"
                id="naCustomer"
                :value="false"
                :selected="!formData.has_oracle_customer"
                v-model="formData.has_oracle_customer"
              />
              <label class="form-check-label" for="naCustomer">
                N/A - Manual Encode Customer</label
              >
            </div>
            <div class="form-check form-check-inline">
              <input
                class="form-check-input"
                type="radio"
                name="customerSelection"
                id="chooseOracleCustomer"
                :value="true"
                :selected="formData.has_oracle_customer"
                v-model="formData.has_oracle_customer"
              />
              <label class="form-check-label" for="chooseOracleCustomer">
                Choose Oracle Customer
              </label>
            </div>

            <transition name="fade">
              <oracle-customer-input
                v-if="formData.has_oracle_customer"
                v-model="selectedCustomer"
                :input-size="5"
              />
            </transition>
          </div>

          <!-- <div class="col-5 p-2" v-if="false">
            <oracle-customer-details
              :selected-customer-id="selectedCustomer?.id"
            />
          </div> -->

          <div
            :class="{
              'col-5': !formData.has_oracle_customer,
              'col-4': formData.has_oracle_customer,
            }"
          >
            <div class="p-2">
              <label for="customer-name" class="form-label mb-0"
                >CUSTOMER NAME</label
              >
              <input
                type="text"
                class="form-control shadow"
                id="customer-name"
                required
                :disabled="formData.has_oracle_customer"
                @input="
                  formData.customerName = formData.customerName.toUpperCase()
                "
                v-model.trim="formData.customerName"
              />
            </div>
            <div class="p-2">
              <label for="address" class="form-label mb-0">ADDRESS</label>
              <input
                type="text"
                class="form-control shadow"
                id="address"
                required
                :disabled="formData.has_oracle_customer"
                v-model.trim="formData.customerAddress"
                @input="
                  formData.customerAddress =
                    formData.customerAddress.toUpperCase()
                "
                placeholder="1234 Main St"
              />
            </div>
            <div class="p-2">
              <label for="contact-number" class="form-label mb-0"
                >CONTACT NUMBER
                <span class="mx-2 text-primary">(OPTIONAL)</span>
              </label>
              <input
                type="text"
                class="form-control shadow"
                id="contact-number"
                v-model="formData.contactNumber"
                @input="
                  formData.contactNumber = formData.contactNumber.toUpperCase()
                "
              />
            </div>
          </div>

          <div
            :class="{
              'col-5': !formData.has_oracle_customer,
              'col-4': formData.has_oracle_customer,
            }"
          >
            <!-- <input-prepared-by
              v-model="formData.preparedBy"
              key="prepared-by"
            /> -->
            <div class="p-2">
              <label for="prepared-by" class="form-label mb-0"
                >PREPARED BY</label
              >
              <input
                type="text"
                class="form-control shadow"
                id="prepared-by"
                required
                v-model="formData.preparedBy"
                @input="formData.preparedBy = formData.preparedBy.toUpperCase()"
              />
            </div>
            <!-- <input-prepared-by
              v-model="formData.authorizedBy"
              :label="'AUTHORIZED BY'"
              key="authorized-by"
            /> -->
            <div class="p-2">
              <label for="authorized-by" class="form-label mb-0"
                >AUTHORIZED BY</label
              >
              <input
                type="text"
                class="form-control shadow"
                id="authorized-by"
                required
                v-model="formData.authorizedBy"
                @input="
                  formData.authorizedBy = formData.authorizedBy.toUpperCase()
                "
              />
            </div>
            <div class="p-2">
              <label for="customer-reference-number" class="form-label mb-0"
                >CUSTOMER REFERENCE #</label
              >
              <input
                type="text"
                class="form-control shadow"
                id="customer-reference-number"
                required
                v-model="formData.customerReferenceNumber"
                @input="
                  formData.customerReferenceNumber =
                    formData.customerReferenceNumber.toUpperCase()
                "
              />
            </div>
          </div>

          <!-- <header-lines
          class="mt-2"
          :endode-type="'encode'"
          v-model="formData.lines"
        /> -->
          <hr />
          <encode-lines v-model="formData.lines" />

          <div class="text-center" v-if="!isEncoding">
            <div class="mt-3">
              <button
                type="button"
                class="btn btn-warning mx-1"
                @click="addLine"
              >
                <span class="nowrap fw-bold">
                  <i class="bi bi-plus"></i>
                  ADD NEW LINE
                </span>
              </button>

              <button
                v-if="formData.lines.length > 0"
                type="submit"
                class="btn btn-primary mx-1"
                :disabled="formData.lines.length === 0"
              >
                <span class="nowrap fw-bold">
                  <i class="bi bi-check-circle"></i>
                  SUBMIT
                </span>
              </button>
            </div>
          </div>
        </div>
        <encode-confirm
          v-show="isConfirming"
          :form-data="formData"
          :selected-customer="selectedCustomer"
          @cancel="isConfirming = false"
          @confirm="submitCpoForm"
        />
      </form>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import LoadingOverlay from "../UI/LoadingOverlay.vue";
import OracleCustomerDetails from "../UI/OracleCustomerDetails.vue";
import OracleCustomerInput from "../UI/OracleCustomerInput.vue";
import EncodeLines from "./EncodeLines.vue";
import headerLines from "../EditCpo/headerLines.vue";
import EncodeConfirm from "./EncodeConfirm.vue";
// import InputPreparedBy from "./InputPreparedBy.vue";
export default {
  components: {
    LoadingOverlay,
    OracleCustomerDetails,
    OracleCustomerInput,
    EncodeLines,
    headerLines,
    EncodeConfirm,
    // InputPreparedBy,
  },
  inject: ["showNotification"],
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
        lines: [],
        has_oracle_customer: true, // if customer is from oracle
      },
      isSubmitSuccess: false,
      isEncoding: false,
      isConfirming: false,
    };
  },
  watch: {
    "formData.has_oracle_customer": {
      handler(newVal) {
        if (!newVal) {
          this.selectedCustomer = null;
          this.formData.customerName = "";
          this.formData.customerAddress = "";
        }
      },
    },
    selectedCustomer: {
      handler(newVal, oldVal) {
        if (newVal) {
          // console.log(newVal);
          this.formData.customerName = newVal.accountName;
          this.formData.customerAddress = newVal.shipToAddress;
        }
      },
      deep: true,
    },
  },
  methods: {
    confirmForm() {
      this.isConfirming = true;
    },
    resetLineNumber() {
      this.formData.lines.forEach((line, index) => {
        line.lineNumber = index + 1;
      });
    },
    addLine() {
      this.formData.lines.push({
        id: Date.now(), //
      });

      this.resetLineNumber();
    },
    submitConfirm() {
      this.isConfirming = true;
    },
    async submitCpoForm() {
      try {
        // console.log("lines");
        // console.log(this.formData.lines);

        this.isEncoding = true;
        const res = await axios.post("api/cpo", {
          ...this.formData,
          oracleId: this.selectedCustomer?.id,
          oracleShipto: this.selectedCustomer?.shipToAddress,
        });
        // console.log(res.data);
        this.isSubmitSuccess = true;
        // this.resetForm();

        // console.log(res.data.lines);
        // this.gotoSearchPage();
        this.showNotification({
          message: `CPO successfully encoded / RPO# ${res.data.cpo.formatted_id} `,
          type: "success",
        });
        this.gotoEditCpoPage(res.data.cpo.id);
        setTimeout(() => {
          this.isSubmitSuccess = false;
        }, 3000);
      } catch (error) {
        console.error(error.message);
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

/* Add any custom styles here */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1s ease, transform 1s ease;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
  transform: translateY(-10px);
}
.fade-enter-active {
  opacity: 1;
  transform: translateY(0);
}
</style>
