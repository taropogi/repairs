<template>
  <div class="row">
    <div class="col-md-12">
      <label for="oracle-shipto-address" class="form-label">
        SHIPTO ADDRESS (ORACLE)
      </label>
      <textarea
        style="resize: none; height: 50px"
        class="form-control shadow"
        id="oracle-shipto-address"
        disabled
        :value="customerDetails.shipToAddress"
      >
      </textarea>
    </div>
    <div class="col-md-12 mt-2">
      <label for="oracle-srep-name" class="form-label">
        SALES REPRESENTATIVE (ORACLE)
      </label>
      <textarea
        style="resize: none; height: 50px"
        class="form-control shadow"
        id="oracle-srep-name"
        disabled
        :value="customerDetails.srepName"
      >
      </textarea>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: {
    selectedCustomerId: {
      type: Number,
      required: true,
      default: 3234415,
    },
  },
  watch: {
    selectedCustomerId() {
      this.setCustomerDetails();
    },
  },
  data() {
    return {
      customerDetails: {
        shipToAddress: "",
        srepName: "",
      },
    };
  },
  computed: {
    ...mapGetters(["oracleCustomers"]),
  },
  methods: {
    setCustomerDetails() {
      const selectedCustomer = this.oracleCustomers.find(
        (el) => el.cust_account_id === Number(this.selectedCustomerId)
      );

      this.customerDetails.shipToAddress =
        selectedCustomer.address1 +
        " " +
        (selectedCustomer.address2 ?? "") +
        ", " +
        (selectedCustomer.city ?? "") +
        ", " +
        (selectedCustomer.province ?? "");

      this.customerDetails.srepName = selectedCustomer.salesrep_name;
    },
  },
  mounted() {
    this.setCustomerDetails();
  },
};
</script>

<style></style>
