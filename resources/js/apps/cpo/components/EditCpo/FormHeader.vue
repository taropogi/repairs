<template>
  <div>
    <spinner-loading v-if="!(headerRow && oracleCustomers)"></spinner-loading>
    <form class="row g-1 p-2" @submit.prevent="submitCpoForm" v-else>
      <transition name="updated-header">
        <div class="fixed-top p2" v-if="isSubmitSuccess">
          <div class="alert alert-success text-center" role="alert">
            <i class="bi bi-check2-all"></i>
            <strong>Successful header update!</strong>
          </div>
        </div>
      </transition>

      <div class="col-md-6">
        <label for="oracle-customer-name" class="form-label">
          CUSTOMER NAME (ORACLE)
        </label>
        <select
          :disabled="headerRow.locked || !canEditCpo"
          size="10"
          class="form-select"
          id="oracle-customer-name"
          v-model="defaultOracleCustomer.id"
          @change="setDefaultShipToAddress"
        >
          <option
            v-for="customer in oracleCustomers"
            :key="customer.cust_account_id"
            :value="customer.cust_account_id"
          >
            {{ customer.account_name }}
          </option>
        </select>
      </div>
      <div class="col-md-6">
        <oracle-customer-details
          :selected-customer-id="defaultOracleCustomer.id"
        />
      </div>

      <div class="col-md-4">
        <label for="customer-name" class="form-label">Customer Name</label>
        <input
          type="text"
          class="form-control"
          id="customer-name"
          required
          :disabled="headerRow.locked || !canEditCpo"
          v-model.trim="headerRow.customer_name"
        />
      </div>

      <div class="col-md-4">
        <label for="customer-address" class="form-label">Address</label>
        <input
          :disabled="headerRow.locked || !canEditCpo"
          type="text"
          class="form-control"
          id="customer-address"
          placeholder="1234 Main St"
          required
          v-model.trim="headerRow.customer_address"
        />
      </div>

      <div class="col-md-4">
        <label for="contact-number" class="form-label">Contact #</label>
        <input
          type="text"
          class="form-control"
          id="contact-number"
          required
          :disabled="headerRow.locked || !canEditCpo"
          v-model="headerRow.contact_number"
        />
      </div>

      <div class="col-md-3">
        <label for="prepared-by" class="form-label">Prepared By</label>
        <input
          type="text"
          class="form-control"
          id="prepared-by"
          required
          :disabled="headerRow.locked || !canEditCpo"
          v-model="headerRow.prepared_by"
        />
      </div>

      <div class="col-md-3">
        <label for="authorized-by" class="form-label">Authorized By</label>
        <input
          type="text"
          class="form-control"
          id="prepared-by"
          required
          :disabled="headerRow.locked || !canEditCpo"
          v-model="headerRow.authorized_by"
        />
      </div>

      <div class="col-md-3">
        <label for="rpo-number" class="form-label">RPO #</label>
        <input
          type="text"
          class="form-control"
          id="rpo-number"
          required
          v-model="headerRow.id"
          disabled
        />
      </div>

      <div class="col-md-3">
        <label for="cpo-statuses" class="form-label"
          >Status
          <span class="badge bg-success" v-if="headerRow.locked"
            >COMPLETED
          </span>
        </label>
        <select
          class="form-select"
          v-model="headerRow.status_id"
          id="cpo-statuses"
          :disabled="headerRow.locked || !canEditCpo"
        >
          <option
            v-for="status in headerStatuses"
            :key="status.id"
            :value="status.id"
            :selected="status.id === headerStatus.id"
          >
            {{ status.status }}
          </option>
        </select>
      </div>
      <action-buttons :cpo-id="headerRow.id" />
    </form>
  </div>
</template>

<script>
import ModalStatusHistory from "./ModalStatusHistory.vue";
import OracleCustomerDetails from "../UI/OracleCustomerDetails.vue";
import ActionButtons from "./ActionButtons.vue";
import { mapGetters } from "vuex";
export default {
  components: {
    ModalStatusHistory,
    OracleCustomerDetails,
    ActionButtons,
  },
  emits: ["searched-header-row", "updating", "updated"],
  props: ["id"],
  inject: ["laravelData"],
  data() {
    return {
      headerRow: null,
      isUpdating: false,
      isSubmitSuccess: false,
      defaultOracleCustomer: {
        id: 3234415,
      },
      showStatusHistory: false,
    };
  },
  watch: {},
  computed: {
    ...mapGetters(["oracleCustomers"]),
    ...mapGetters("auth", ["loggedUser", "canEditCpo", "canDownloadCpoPdf"]),
  },
  methods: {
    async getCpoHeaderRow() {
      try {
        const res = await axios.get("api/cpo/" + this.id);

        this.headerStatuses = res.data.header_statuses;
        this.headerStatus = res.data.cpo.status;

        this.headerRow = res.data.cpo;
        // console.log(this.headerRow);

        if (this.headerRow.oracle_customer_id) {
          this.defaultOracleCustomer.id = +this.headerRow.oracle_customer_id;
        }

        this.$emit("searched-header-row", this.headerRow);
      } catch (error) {
        console.log(error.message);
        console.log("error hahah");
      }
    },
    async submitCpoForm() {
      try {
        this.isSubmitSuccess = false;
        this.$emit("updating");

        await axios.post("api/cpo/update", {
          ...this.headerRow,
          oracleId: this.defaultOracleCustomer.id,
          oracleShipto: this.defaultOracleCustomer.shipToAddress,
        });
        // console.log("after await");
        this.isSubmitSuccess = true;

        this.getCpoHeaderRow();

        setTimeout(() => {
          this.isSubmitSuccess = false;
        }, 3000);
      } catch (error) {
        console.log(error.message);
        console.log("error submit");
      } finally {
        this.isUpdating = false;
        this.$emit("updated");
      }
    },
  },
  mounted() {
    this.getCpoHeaderRow();
  },
};
</script>
