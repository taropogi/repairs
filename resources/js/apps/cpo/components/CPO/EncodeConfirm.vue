<template>
  <div>
    <div
      class="alert alert-warning align-items-center text-center"
      role="alert"
    >
      <h3>Are you sure with the details?</h3>
      <br />
      <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-danger" @click="cancel">
          No, Cancel
        </button>
        <button type="button" class="btn btn-primary" @click="confirm">
          Yes, Confirm
        </button>
      </div>
    </div>
    <div v-if="localFormData.has_oracle_customer">
      <h6 class="bg-success p-2 text-white">Customer Details (Oracle)</h6>
      <table class="table table-bordered">
        <tbody>
          <tr>
            <th style="width: 200px">Customer Name (Oracle)</th>
            <td>
              {{ selectedCustomer?.accountName }}
            </td>
          </tr>
          <tr>
            <th>Shipto Address</th>
            <td>
              {{ selectedCustomer?.shipToAddress }}
            </td>
          </tr>
          <tr>
            <th>Sales Representative</th>
            <td>
              {{ selectedCustomer?.srepName }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <h6 class="bg-success p-2 text-white">Customer Details</h6>
    <table class="table table-bordered">
      <tbody>
        <tr>
          <th style="width: 200px">Cutomer Name</th>
          <td>
            {{ localFormData?.customerName }}
          </td>

          <th style="width: 200px">Address</th>
          <td>
            {{ localFormData?.customerAddress }}
          </td>
        </tr>
        <tr>
          <th>Contact Number</th>
          <td>
            {{ localFormData?.contactNumber }}
          </td>

          <th>Prepared By</th>
          <td>
            {{ localFormData?.preparedBy }}
          </td>
        </tr>
        <tr>
          <th>Authorized By</th>
          <td>
            {{ localFormData?.authorizedBy }}
          </td>

          <th>Customer Reference Number</th>
          <td>
            {{ localFormData?.customerReferenceNumber }}
          </td>
        </tr>
      </tbody>
    </table>
    <h6 class="bg-success p-2 text-white">Line Details</h6>
    <table class="table table-bordered">
      <thead class="table-warning">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Description</th>
          <th scope="col">Price</th>
          <th scope="col">Doc #</th>
          <th scope="col">HCopy</th>
          <th scope="col">Qty Returned</th>
          <th scope="col">Unit</th>
          <th scope="col">Qty Inspect</th>
          <th scope="col">Date</th>
          <th scope="col">Good Condition</th>
          <th scope="col">Minor Repair/Clean</th>
          <th scope="col">Repair/Parts Needed</th>
          <th scope="col">Damaged</th>
          <th scope="col">Comments</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="line in localFormData.lines" :key="line.id">
          <th scope="row">{{ line.lineNumber }}</th>
          <td>
            {{ line.description }}
          </td>

          <td>
            {{ line.price }}
          </td>

          <td>
            {{ line.orderNumber }}
          </td>

          <td>
            {{ line.hcopy }}
          </td>

          <td>
            {{ line.qtyReturned }}
          </td>

          <td>
            {{ line.unit }}
          </td>

          <td>
            {{ line.qtyInspect }}
          </td>

          <td>
            {{ line.date }}
          </td>

          <td>
            {{ line.goodCondition }}
          </td>

          <td>
            {{ line.minorRepairClean }}
          </td>

          <td>
            {{ line.repairPartsNeeded }}
          </td>

          <td>
            {{ line.damaged }}
          </td>

          <td>
            {{ line.comments }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  props: ["formData", "selectedCustomer"],
  emits: ["confirm", "cancel"],
  data() {
    return {
      localFormData: this.formData,
    };
  },
  methods: {
    confirm() {
      this.$emit("confirm");
    },
    cancel() {
      console.log("cancel");
      this.$emit("cancel");
    },
  },
};
</script>

<style></style>
