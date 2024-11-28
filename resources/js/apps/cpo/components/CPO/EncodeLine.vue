<template>
  <tr>
    <th scope="row">{{ line.lineNumber }}</th>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.description"
      />
    </td>

    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.price"
      />
    </td>

    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.orderNumber"
      />
    </td>

    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.hcopy"
      />
    </td>

    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.qtyReturned"
      />
    </td>

    <td>
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

    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.qtyInspect"
      />
    </td>

    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.date"
      />
    </td>

    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.goodCondition"
      />
    </td>

    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.minorRepairClean"
      />
    </td>

    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="line.repairPartsNeeded"
      />
    </td>

    <td>
      <input
        type="text"
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
};
</script>

<style></style>
