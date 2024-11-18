<template>
  <div>
    <label for="oracle-customer-name" class="form-label">
      CUSTOMER NAME (ORACLE) /
      <span class="text-danger"
        >Result: {{ filteredOracleCustomers.length }}</span
      >
    </label>
    <!-- Add search input -->
    <input
      type="text"
      class="form-control shadow mb-2"
      v-model="searchOracleCustomerStr"
      @input="searchOracleCustomer"
      placeholder="Search Oracle Customer"
    />

    <select
      size="10"
      class="form-select shadow"
      id="oracle-customer-name"
      v-model="defaultOracleCustomer.id"
      @change="setDefaultShipToAddress"
    >
      <option
        v-for="customer in filteredOracleCustomers"
        :key="customer"
        :value="customer.cust_account_id"
      >
        {{ customer.account_name }}
      </option>
    </select>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  // props modelValue Number type
  props: ["modelValue"],
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
      },
    };
  },
  computed: {
    ...mapGetters(["oracleCustomers"]),
    filteredOracleCustomers() {
      return this.oracleCustomers.filter((customer) =>
        customer.account_name
          .toLowerCase()
          .includes(this.searchOracleCustomerStr.toLowerCase())
      );
    },
  },

  methods: {
    searchOracleCustomer() {
      if (this.searchOracleCustomerStr === "") {
        return;
      }
      this.searchedOracleCustomerId = this.oracleCustomers.find((el) =>
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
      //   console.log(this.defaultOracleCustomer);
      // emit updateModel
      this.$emit("update:modelValue", this.defaultOracleCustomer);
    },
  },
  mounted() {
    this.searchOracleCustomer();
    this.setDefaultShipToAddress();
  },
};
</script>

<style></style>
