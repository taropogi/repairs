<template>
  <div>
    <div
      class="alert alert-warning align-items-center text-center"
      role="alert"
    >
      <h3>Are you sure with the details?</h3>
      <br />
      <div>
        <button
          type="button"
          class="btn btn-danger mx-1 btn-lg"
          @click="cancel"
        >
          No, Cancel
        </button>
        <button
          type="button"
          class="btn btn-primary btn-lg mx-1"
          @click="confirm"
        >
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
          <th
            scope="col"
            v-if="encodeLineFieldsPermission.includes('description') || isAdmin"
          >
            Description
          </th>
          <th
            scope="col"
            v-if="encodeLineFieldsPermission.includes('price') || isAdmin"
          >
            Price
          </th>
          <th
            scope="col"
            v-if="
              encodeLineFieldsPermission.includes('order_number') || isAdmin
            "
          >
            Doc #
          </th>
          <th
            scope="col"
            v-if="encodeLineFieldsPermission.includes('hcopy') || isAdmin"
          >
            HCopy
          </th>
          <th
            scope="col"
            v-if="
              encodeLineFieldsPermission.includes('qty_returned') || isAdmin
            "
          >
            Qty Returned
          </th>
          <th
            scope="col"
            v-if="encodeLineFieldsPermission.includes('unit') || isAdmin"
          >
            Unit
          </th>
          <th
            scope="col"
            v-if="encodeLineFieldsPermission.includes('qty_inspect') || isAdmin"
          >
            Qty Inspect
          </th>
          <th
            scope="col"
            v-if="encodeLineFieldsPermission.includes('date') || isAdmin"
          >
            Date
          </th>
          <th
            scope="col"
            v-if="
              encodeLineFieldsPermission.includes('good_condition') || isAdmin
            "
          >
            Good Condition
          </th>
          <th
            scope="col"
            v-if="
              encodeLineFieldsPermission.includes('minor_repair_clean') ||
              isAdmin
            "
          >
            Minor Repair/Clean
          </th>
          <th
            scope="col"
            v-if="
              encodeLineFieldsPermission.includes('repair_parts_needed') ||
              isAdmin
            "
          >
            Repair/Parts Needed
          </th>
          <th
            scope="col"
            v-if="encodeLineFieldsPermission.includes('damaged') || isAdmin"
          >
            Damaged
          </th>
          <th
            scope="col"
            v-if="encodeLineFieldsPermission.includes('comments') || isAdmin"
          >
            Comments
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="line in localFormData.lines" :key="line.id">
          <th scope="row">{{ line.lineNumber }}</th>
          <td
            v-if="encodeLineFieldsPermission.includes('description') || isAdmin"
          >
            {{ line.description }}
          </td>

          <td v-if="encodeLineFieldsPermission.includes('price') || isAdmin">
            {{ line.price }}
          </td>

          <td
            v-if="
              encodeLineFieldsPermission.includes('order_number') || isAdmin
            "
          >
            {{ line.orderNumber }}
          </td>

          <td v-if="encodeLineFieldsPermission.includes('hcopy') || isAdmin">
            {{ line.hcopy }}
          </td>

          <td
            v-if="
              encodeLineFieldsPermission.includes('qty_returned') || isAdmin
            "
          >
            {{ line.qtyReturned }}
          </td>

          <td v-if="encodeLineFieldsPermission.includes('unit') || isAdmin">
            {{ line.unit }}
          </td>

          <td
            v-if="encodeLineFieldsPermission.includes('qty_inspect') || isAdmin"
          >
            {{ line.qtyInspect }}
          </td>

          <td v-if="encodeLineFieldsPermission.includes('date') || isAdmin">
            {{ line.date }}
          </td>

          <td
            v-if="
              encodeLineFieldsPermission.includes('good_condition') || isAdmin
            "
          >
            {{ line.goodCondition }}
          </td>

          <td
            v-if="
              encodeLineFieldsPermission.includes('minor_repair_clean') ||
              isAdmin
            "
          >
            {{ line.minorRepairClean }}
          </td>

          <td
            v-if="
              encodeLineFieldsPermission.includes('repair_parts_needed') ||
              isAdmin
            "
          >
            {{ line.repairPartsNeeded }}
          </td>

          <td v-if="encodeLineFieldsPermission.includes('damaged') || isAdmin">
            {{ line.damaged }}
          </td>

          <td v-if="encodeLineFieldsPermission.includes('comments') || isAdmin">
            {{ line.comments }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["formData", "selectedCustomer"],
  emits: ["confirm", "cancel"],
  computed: {
    ...mapGetters("auth", ["encodeLineFieldsPermission", "isAdmin"]),
  },
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
