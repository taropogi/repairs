<template>
  <div>
    <spinner-loading v-if="!(headerRow && oracleCustomers)"></spinner-loading>
    <form class="row g-1 p-2" @submit.prevent="submitCpoForm" v-else>
      <div
        class="p-2"
        :class="{
          'col-2': !headerRow.has_oracle_customer,
          'col-4': headerRow.has_oracle_customer,
        }"
      >
        <label class="form-label">CUSTOMER SELECTION</label>
        <div class="form-check">
          <input
            class="form-check-input"
            type="radio"
            name="customerSelection"
            id="naCustomer"
            :value="false"
            v-model="headerRow.has_oracle_customer"
          />
          <label class="form-check-label" for="naCustomer"> N/A </label>
        </div>
        <div class="form-check">
          <input
            class="form-check-input"
            type="radio"
            name="customerSelection"
            id="chooseOracleCustomer"
            :value="true"
            v-model="headerRow.has_oracle_customer"
          />
          <label class="form-check-label" for="chooseOracleCustomer">
            Choose Oracle Customer
          </label>
        </div>

        <oracle-customer-input
          v-if="headerRow.has_oracle_customer"
          v-model="defaultOracleCustomer"
          :is-locked="!!(headerRow.locked || !canEditCpo)"
        />
      </div>

      <div
        class="p-2"
        :class="{
          'col-5': !headerRow.has_oracle_customer,
          'col-4': headerRow.has_oracle_customer,
        }"
      >
        <div>
          <label for="customer-name " class="form-label mb-0"
            >CUSTOMER NAME
          </label>
          <input
            type="text"
            class="form-control"
            id="customer-name"
            required
            :disabled="
              headerRow.locked || !canEditCpo || headerRow.has_oracle_customer
            "
            v-model.trim="headerRow.customer_name"
          />
        </div>

        <div class="pt-2">
          <label for="customer-address" class="form-label mb-0">ADDRESS </label>
          <input
            :disabled="
              headerRow.locked || !canEditCpo || headerRow.has_oracle_customer
            "
            type="text"
            class="form-control"
            id="customer-address"
            placeholder="1234 Main St"
            required
            v-model.trim="headerRow.customer_address"
          />
        </div>

        <div class="pt-2">
          <label for="contact-number" class="form-label mb-0">CONTACT #</label>
          <input
            type="text"
            class="form-control"
            id="contact-number"
            required
            :disabled="headerRow.locked || !canEditCpo"
            v-model="headerRow.contact_number"
          />
        </div>

        <div class="pt-2">
          <label for="prepared-by" class="form-label mb-0">PREPARED BY</label>
          <input
            type="text"
            class="form-control"
            id="prepared-by"
            required
            :disabled="headerRow.locked || !canEditCpo"
            v-model="headerRow.prepared_by"
          />
        </div>
        <div class="pt-2">
          <label for="authorized-by" class="form-label mb-0"
            >AUTHORIZED BY</label
          >
          <input
            type="text"
            class="form-control"
            id="authorized-by"
            required
            :disabled="headerRow.locked || !canEditCpo"
            v-model="headerRow.authorized_by"
          />
        </div>
      </div>
      <div
        class="p-2"
        :class="{
          'col-5': !headerRow.has_oracle_customer,
          'col-4': headerRow.has_oracle_customer,
        }"
      >
        <div>
          <label for="customer-reference-number  " class="form-label mb-0"
            >CUSTOMER REFERENCE #</label
          >
          <input
            type="text"
            class="form-control"
            id="customer-reference-number"
            :disabled="headerRow.locked || !canEditCpo"
            v-model="headerRow.customer_reference_number"
          />
        </div>
        <div class="pt-2">
          <label for="date-encoded" class="form-label mb-0">DATE ENCODED</label>
          <input
            type="text"
            class="form-control"
            id="date-encoded"
            required
            disabled="true"
            :value="formattedDate"
          />
        </div>
        <div class="pt-2">
          <label for="cpo-statuses" class="form-label mb-0"
            >STATUS
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
        <div
          class="d-flex justify-content-center align-items-center"
          style="height: 100px"
        >
          <h1>RPO#: {{ headerRow.formatted_id }}</h1>
        </div>
      </div>
      <div cla></div>
      <action-buttons :cpo-id="headerRow.id" />
    </form>
  </div>
</template>

<script>
import ModalStatusHistory from "./ModalStatusHistory.vue";
import OracleCustomerDetails from "../UI/OracleCustomerDetails.vue";
import ActionButtons from "./ActionButtons.vue";
import OracleCustomerInput from "../UI/OracleCustomerInput.vue";
import { mapGetters } from "vuex";
import { formatDate } from "../../utils/dateUtils";
export default {
  components: {
    ModalStatusHistory,
    OracleCustomerDetails,
    ActionButtons,
    OracleCustomerInput,
  },
  emits: ["searched-header-row", "updating", "updated"],
  props: ["id"],
  inject: ["laravelData", "showNotification"],
  data() {
    return {
      headerRow: null,
      headerRowOriginal: null,
      isUpdating: false,
      isSubmitSuccess: false,
      defaultOracleCustomer: {
        id: null,
      },
      showStatusHistory: false,
    };
  },
  watch: {
    "headerRow.has_oracle_customer": function (newVal, oldVal) {
      if (!newVal) {
        this.headerRow.customer_name = this.headerRowOriginal.customer_name;
        this.headerRow.customer_address =
          this.headerRowOriginal.customer_address;
      }
    },
    defaultOracleCustomer: {
      handler: function (newVal, oldVal) {
        if (this.headerRow.has_oracle_customer) {
          this.headerRow.customer_name = newVal.accountName;
          this.headerRow.customer_address = newVal.shipToAddress;
        }
      },
      deep: true,
    },
  },
  computed: {
    ...mapGetters(["oracleCustomers"]),
    ...mapGetters("auth", ["loggedUser", "canEditCpo", "canDownloadCpoPdf"]),
    formattedDate() {
      return formatDate(this.headerRow.created_at);
    },
  },
  methods: {
    async getCpoHeaderRow() {
      try {
        const res = await axios.get("api/cpo/" + this.id);

        this.headerStatuses = res.data.header_statuses;
        this.headerStatus = res.data.cpo.status;

        this.headerRow = res.data.cpo;
        this.headerRowOriginal = { ...this.headerRow };

        this.headerRow.has_oracle_customer =
          this.headerRow.has_oracle_customer === 1 ? true : false;
        this.$emit("searched-header-row", this.headerRow);

        if (this.headerRow.oracle_customer_id) {
          // console.log(this.headerRow.oracle_customer_id);
          this.defaultOracleCustomer.id = +this.headerRow.oracle_customer_id;
        }

        // this.$emit("searched-header-row", this.headerRow);
      } catch (error) {
        console.error(error.message);
        // console.log("error hahah");
      }
    },
    async submitCpoForm() {
      try {
        this.isSubmitSuccess = false;
        this.$emit("updating");
        // console.log(this.headerRow);
        const res = await axios.post("api/cpo/update", {
          ...this.headerRow,
          oracleId: this.defaultOracleCustomer.id,
          oracleShipto: this.defaultOracleCustomer.shipToAddress,
        });
        // console.log(res);
        this.isSubmitSuccess = true;

        this.getCpoHeaderRow();
        this.showNotification({
          message: `RPO# ${this.headerRow.formatted_id}  Header Updated Successfully!`,
          type: "success",
        });
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
