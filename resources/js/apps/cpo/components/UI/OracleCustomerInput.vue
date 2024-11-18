<template>
  <div>
    <label for="oracle-customer-name" class="form-label">
      CUSTOMER NAME (ORACLExx)
    </label>
    <!-- Add search input -->
    <input
      type="text"
      class="form-control shadow mb-2"
      v-model="searchOracleCustomer"
      @input="searchOracleCustomers"
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
        v-for="customer in oracleCustomers"
        :key="customer.cust_account_id"
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
  // emit updateModel
  emits: ["update:modelValue"],
  data() {
    return {
      searchOracleCustomer: "",
      defaultOracleCustomer: {
        id: 3234415,
        shipToAddress: "",
        srepName: "",
      },
    };
  },
  computed: {
    ...mapGetters(["oracleCustomers"]),
  },
  methods: {
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
    this.setDefaultShipToAddress();
  },
};
</script>

<style></style>
