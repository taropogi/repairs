<template>
  <div>
    <div
      v-if="itemsUom.length > 0 && localLines.length > 0"
      class="text-center"
    >
      <h3 class="bg-success p-2 text-white text-center">Line Details</h3>
      <table
        class="table table-bordered table-striped table-sm"
        v-if="localLines.length > 0"
      >
        <thead class="table-warning">
          <tr>
            <th scope="col">#</th>
            <th
              scope="col"
              v-if="encodeLineFieldsPermission.includes('description')"
            >
              Description
            </th>
            <th
              scope="col"
              style="width: 50px"
              v-if="encodeLineFieldsPermission.includes('price')"
            >
              Price
            </th>
            <th
              scope="col"
              style="width: 100px"
              v-if="encodeLineFieldsPermission.includes('order_number')"
            >
              Doc #
            </th>
            <th
              scope="col"
              style="width: 100px"
              v-if="encodeLineFieldsPermission.includes('hcopy')"
            >
              HCopy
            </th>
            <th
              scope="col"
              style="width: 50px"
              v-if="encodeLineFieldsPermission.includes('qty_returned')"
            >
              Qty Returned
            </th>
            <th
              scope="col"
              style="width: 100px"
              v-if="encodeLineFieldsPermission.includes('unit')"
            >
              Unit
            </th>
            <th
              scope="col"
              style="width: 50px"
              v-if="encodeLineFieldsPermission.includes('qty_inspect')"
            >
              Qty Inspect
            </th>
            <th
              scope="col"
              style="width: 100px"
              v-if="encodeLineFieldsPermission.includes('date')"
            >
              Date
            </th>
            <th
              scope="col"
              style="width: 50px"
              v-if="encodeLineFieldsPermission.includes('good_condition')"
            >
              Good Condition
            </th>
            <th
              scope="col"
              style="width: 50px"
              v-if="encodeLineFieldsPermission.includes('minor_repair_clean')"
            >
              Minor Repair/Clean
            </th>
            <th
              scope="col"
              style="width: 50px"
              v-if="encodeLineFieldsPermission.includes('repair_parts_needed')"
            >
              Repair/Parts Needed
            </th>
            <th
              scope="col"
              style="width: 50px"
              v-if="encodeLineFieldsPermission.includes('damaged')"
            >
              Damaged
            </th>
            <th scope="col">Comments</th>

            <th scope="col" style="width: 100px">Actions</th>
          </tr>
        </thead>
        <tbody>
          <encode-line
            v-for="line in localLines"
            :key="line.id"
            :line="line"
            :items-uom="itemsUom"
            @delete-line="deleteLine"
          />
        </tbody>
      </table>

      <!-- <button type="button" class="btn btn-primary btn-sm" @click="addLine">
        Add Line
      </button> -->
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import axios from "axios";
import EncodeLine from "./EncodeLine.vue";

export default {
  components: {
    EncodeLine,
  },

  props: {
    modelValue: {
      type: Array,
      required: false,
      default: [],
    },
  },
  emits: ["update:modelValue"],
  computed: {
    ...mapGetters("auth", ["encodeLineFieldsPermission"]),
  },
  data() {
    return {
      localLines: this.modelValue,
      itemsUom: [],
      isDeleting: false,
    };
  },
  methods: {
    resetLineNumber() {
      this.localLines.forEach((line, index) => {
        line.lineNumber = index + 1;
      });
    },
    async getItemsUom() {
      try {
        const response = await axios.get("/api/items/uom_distinct");
        this.itemsUom = response.data.items_uom;
        // console.log(this.itemsUom.items_uom);
      } catch (error) {
        console.log(error);
      }
    },
    deleteLine(line) {
      const index = this.localLines.findIndex((l) => l.id === line.id);
      this.localLines.splice(index, 1);
      this.resetLineNumber();
      this.$emit("update:modelValue", this.localLines);
    },
  },
  mounted() {
    this.getItemsUom();
  },
};
</script>

<style></style>
