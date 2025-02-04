h5
<template>
  <div>
    <select-oracle-item-input
      v-if="isSelectingOracleItem"
      @closeModal="closeModal"
      @itemSelected="itemSelected"
    />
    <div v-if="itemsUom.length > 0 && localLines.length > 0">
      <h5 class="bg-secondary p-2 text-white m-0">LINE DETAILS</h5>
      <table
        class="table table-striped table-sm mt-0"
        v-if="localLines.length > 0"
      >
        <thead class="table-warning">
          <tr>
            <th scope="col" style="width: 100px">#</th>
            <th
              scope="col"
              v-if="
                encodeLineFieldsPermission.includes('description') || isAdmin
              "
              style="width: 500px"
            >
              Description
            </th>
            <th
              scope="col"
              style="width: 50px"
              v-if="encodeLineFieldsPermission.includes('price') || isAdmin"
            >
              Price
            </th>
            <th
              scope="col"
              style="width: 100px"
              v-if="
                encodeLineFieldsPermission.includes('order_number') || isAdmin
              "
            >
              Doc #
            </th>
            <th
              scope="col"
              style="width: 100px"
              v-if="encodeLineFieldsPermission.includes('doc_date') || isAdmin"
            >
              Doc. Date
            </th>
            <th
              scope="col"
              style="width: 100px"
              v-if="encodeLineFieldsPermission.includes('hcopy') || isAdmin"
            >
              HCopy
            </th>

            <th
              scope="col"
              style="width: 50px"
              v-if="
                encodeLineFieldsPermission.includes('qty_returned') || isAdmin
              "
            >
              Qty Returned
            </th>
            <th
              scope="col"
              style="width: 100px"
              v-if="encodeLineFieldsPermission.includes('unit') || isAdmin"
            >
              Unit
            </th>
            <th
              scope="col"
              style="width: 50px"
              v-if="
                encodeLineFieldsPermission.includes('qty_inspect') || isAdmin
              "
            >
              Qty Inspect
            </th>
            <th
              scope="col"
              style="width: 100px"
              v-if="
                encodeLineFieldsPermission.includes('date_inspected') || isAdmin
              "
            >
              Date<br />
              Inspected
            </th>
            <th
              scope="col"
              style="width: 50px"
              v-if="
                encodeLineFieldsPermission.includes('good_condition') || isAdmin
              "
            >
              Good Condition
            </th>
            <th
              scope="col"
              style="width: 50px"
              v-if="
                encodeLineFieldsPermission.includes('minor_repair_clean') ||
                isAdmin
              "
            >
              Minor Repair/Clean
            </th>
            <th
              scope="col"
              style="width: 50px"
              v-if="
                encodeLineFieldsPermission.includes('repair_parts_needed') ||
                isAdmin
              "
            >
              Repair/Parts Needed
            </th>
            <th
              scope="col"
              style="width: 50px"
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
            @selectItemFor="selectOracleItem"
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
import SelectOracleItemInput from "../Modals/SelectOracleItemInput.vue";
export default {
  components: {
    EncodeLine,
    SelectOracleItemInput,
  },

  props: {
    modelValue: {
      type: Array,
      required: false,
      default: [],
    },
  },
  emits: ["update:modelValue"],
  inject: ["showNotification"],
  computed: {
    ...mapGetters("auth", ["encodeLineFieldsPermission", "isAdmin"]),
  },
  data() {
    return {
      localLines: this.modelValue,
      itemsUom: [],
      isDeleting: false,
      isSelectingOracleItem: false,
      selectItemForLineNumber: null,
    };
  },
  methods: {
    itemSelected(item) {
      const targetItem = this.localLines.find(
        (line) => line.lineNumber === this.selectItemForLineNumber
      );
      targetItem.description = `${item.description} - ${item.segment6}`;
      // targetItem.price = item.list_price;
      targetItem.unit = item.primary_uom_code;
      this.localLines = [
        ...this.localLines.filter(
          (line) => line.lineNumber !== targetItem.lineNumber
        ),
        targetItem,
      ];
      this.localLines.sort((a, b) => a.lineNumber - b.lineNumber);
      this.$emit("update:modelValue", this.localLines);
      this.showNotification({
        message: `Line# ${this.selectItemForLineNumber} - ${item.description} has been selected. Price: ${item.list_price}, Unit: ${item.primary_uom_code}`,
        type: "success",
      });
      this.isSelectingOracleItem = false;
    },
    closeModal() {
      this.isSelectingOracleItem = false;
    },
    selectOracleItem(forLineNumber) {
      this.selectItemForLineNumber = forLineNumber;
      this.isSelectingOracleItem = true;
    },
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
