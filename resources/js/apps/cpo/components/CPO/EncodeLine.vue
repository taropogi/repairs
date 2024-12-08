<template>
  <tr>
    <th scope="row">{{ line.lineNumber }}</th>
    <td v-if="encodeLineFieldsPermission.includes('description')">
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.description"
      />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('price')">
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.price"
      />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('order_number')">
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.orderNumber"
      />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('hcopy')">
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.hcopy"
      />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('qty_returned')">
      <input
        type="number"
        class="form-control form-control-sm"
        v-model="line.qtyReturned"
      />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('unit')">
      <div v-if="itemsUom.length > 0">
        <select class="form-select form-select-sm" v-model="line.unit">
          <option
            v-for="uom in itemsUom"
            :key="uom"
            :value="uom.primary_uom_code"
          >
            {{ uom.primary_uom_code }} -
            {{ uom.primary_unit_of_measure }}
          </option>
        </select>
      </div>
    </td>

    <td v-if="encodeLineFieldsPermission.includes('qty_inspect')">
      <input
        type="number"
        class="form-control form-control-sm"
        v-model="line.qtyInspect"
      />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('date')">
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.date"
      />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('good_condition')">
      <input
        type="number"
        class="form-control form-control-sm"
        v-model="line.goodCondition"
      />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('minor_repair_clean')">
      <input
        type="number"
        class="form-control form-control-sm"
        v-model="line.minorRepairClean"
      />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('repair_parts_needed')">
      <input
        type="number"
        class="form-control form-control-sm"
        v-model="line.repairPartsNeeded"
      />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('damaged')">
      <input
        type="number"
        class="form-control form-control-sm"
        v-model="line.damaged"
      />
    </td>

    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.comments"
      />
    </td>

    <td>
      <div class="btn-group btn-group-sm">
        <button
          type="button"
          class="btn btn-danger py-0"
          @click="deleteLine"
          :disabled="isDeleting"
        >
          <span v-if="!isDeleting"> Delete</span>
          <span class="spinner-border spinner-border-sm" v-else></span>
        </button>
      </div>
    </td>
  </tr>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: {
    line: {
      type: Object,
      required: true,
    },
    itemsUom: {
      type: Array,
      required: false,
      default: [],
    },
  },
  data() {
    return {
      isDeleting: false,
    };
  },
  computed: {
    ...mapGetters("auth", ["encodeLineFieldsPermission"]),
  },
  methods: {
    deleteLine() {
      this.isDeleting = true;
      this.$emit("delete-line", this.line);
    },
  },
};
</script>

<style></style>
