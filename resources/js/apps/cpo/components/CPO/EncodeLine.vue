<template>
  <tr>
    <th scope="row">{{ line.lineNumber }}</th>
    <td v-if="encodeLineFieldsPermission.includes('description') || isAdmin">
      <div class="input-group">
        <input type="text" class="form-control" v-model="line.description" />
        <button
          class="btn btn-secondary btn-sm py-0"
          type="button"
          @click="$emit('select-item-for', line.lineNumber)"
        >
          <i class="fas fa-box-open"></i>
          ...
        </button>
      </div>
    </td>

    <td v-if="encodeLineFieldsPermission.includes('price') || isAdmin">
      <input type="text" class="form-control" v-model="line.price" />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('order_number') || isAdmin">
      <input type="text" class="form-control" v-model="line.orderNumber" />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('hcopy') || isAdmin">
      <input type="text" class="form-control" v-model="line.hcopy" />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('qty_returned') || isAdmin">
      <input type="number" class="form-control" v-model="line.qtyReturned" />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('unit') || isAdmin">
      <div v-if="itemsUom.length > 0">
        <select class="form-select" v-model="line.unit">
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

    <td v-if="encodeLineFieldsPermission.includes('qty_inspect') || isAdmin">
      <input type="number" class="form-control" v-model="line.qtyInspect" />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('date') || isAdmin">
      <input type="text" class="form-control" v-model="line.date" />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('good_condition') || isAdmin">
      <input type="number" class="form-control" v-model="line.goodCondition" />
    </td>

    <td
      v-if="
        encodeLineFieldsPermission.includes('minor_repair_clean') || isAdmin
      "
    >
      <input
        type="number"
        class="form-control"
        v-model="line.minorRepairClean"
      />
    </td>

    <td
      v-if="
        encodeLineFieldsPermission.includes('repair_parts_needed') || isAdmin
      "
    >
      <input
        type="number"
        class="form-control"
        v-model="line.repairPartsNeeded"
      />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('damaged') || isAdmin">
      <input type="number" class="form-control" v-model="line.damaged" />
    </td>

    <td v-if="encodeLineFieldsPermission.includes('comments') || isAdmin">
      <input type="text" class="form-control" v-model="line.comments" />
    </td>

    <td>
      <div class="btn-group">
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
  emits: ["delete-line", "select-item-for"],
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
    ...mapGetters("auth", ["encodeLineFieldsPermission", "isAdmin"]),
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
