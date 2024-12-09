<template>
  <div class="pb-3">
    <div v-if="!isLocked">
      <!-- Add search input -->
      <div class="input-group mb-3">
        <input
          id="searchOracleCustomer"
          type="text"
          class="form-control"
          placeholder="Search Oracle Customer"
          v-model="searchOracleCustomerStr"
          @input="debouncedSearch"
        />
      </div>

      <!-- Put result text -->
      <p class="text-center m-1 bg-secondary">
        <strong class="text-white"
          >Result: {{ filteredOracleCustomers.length }}</strong
        >
      </p>
      <select
        :size="inputSize"
        class="form-select shadow border border-primary border-2"
        id="oracle-customer-name"
        v-model="defaultOracleCustomer.id"
        @change="setDefaultShipToAddress"
        ref="oracleCustomerSelect"
      >
        <option
          v-for="customer in filteredOracleCustomers"
          :key="customer"
          :value="customer.cust_account_id"
        >
          {{ customer.account_name }}
          ({{ customer.salesrep_name }})
        </option>
      </select>
    </div>
    <h1 v-else>
      {{
        defaultOracleCustomer.accountName
          ? defaultOracleCustomer.accountName
          : "No Oracle Customer Selected"
      }}
    </h1>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import debounce from "lodash/debounce";

export default {
  // props modelValue Number type with default
  props: {
    modelValue: {
      type: Object,
      required: false,
      default: {
        id: 3234415,
        shipToAddress: "",
        srepName: "",
      },
    },
    isLocked: {
      type: Boolean,
      required: false,
      default: false,
    },
    inputSize: {
      type: Number,
      required: false,
      default: 5,
    },
  },
  // emit updateModel
  emits: ["update:modelValue"],
  data() {
    return {
      searchOracleCustomerStr: "",
      searchedOracleCustomerId: null,
      defaultOracleCustomer: {
        id: this.modelValue?.id || 3234415,
        shipToAddress: "",
        srepName: "",
        accountName: "",
      },
      filteredOracleCustomers: [],
    };
  },
  computed: {
    ...mapGetters(["oracleCustomers"]),
  },

  methods: {
    searchOracleCustomer() {
      this.filteredOracleCustomers = this.oracleCustomers.filter((customer) =>
        customer.account_name
          .toLowerCase()
          .includes(this.searchOracleCustomerStr.toLowerCase())
      );

      this.searchedOracleCustomerId =
        this.defaultOracleCustomer.id ??
        this.filteredOracleCustomers.find((el) =>
          el.account_name
            .toLowerCase()
            .includes(this.searchOracleCustomerStr.toLowerCase())
        )?.cust_account_id;
      this.defaultOracleCustomer.id = this.searchedOracleCustomerId;
    },
    setDefaultShipToAddress() {
      // console.log(typeof this.defaultOracleCustomer.id);
      const selectedCustomer = this.oracleCustomers.find(
        (el) => el.cust_account_id === Number(this.defaultOracleCustomer.id)
      );
      // console.log(selectedCustomer);
      this.defaultOracleCustomer.shipToAddress =
        selectedCustomer.address1 +
        " " +
        (selectedCustomer.address2 ?? "") +
        ", " +
        (selectedCustomer.city ?? "") +
        ", " +
        (selectedCustomer.province ?? "");

      this.defaultOracleCustomer.srepName = selectedCustomer.salesrep_name;
      this.defaultOracleCustomer.accountName = selectedCustomer.account_name;

      // emit updateModel
      this.$emit("update:modelValue", this.defaultOracleCustomer);
    },
  },
  mounted() {
    this.searchOracleCustomer();
    this.setDefaultShipToAddress();
  },
  created() {
    this.debouncedSearch = debounce(this.searchOracleCustomer, 300);
  },
};
</script>
