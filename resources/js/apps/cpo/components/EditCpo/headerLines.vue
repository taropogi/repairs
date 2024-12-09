<template>
  <div>
    <select-oracle-item-input
      @item-selected="itemSelected"
      @close-modal="closeModal"
      v-if="isSelectingOracleItem"
    />
    <h5 class="bg-secondary p-2 text-white m-0" v-if="lines.length > 0">
      LINE DETAILS
    </h5>
    <table
      class="table table-sm table-hover table-borderless mt-0"
      v-if="lines.length > 0"
    >
      <thead class="table-warning">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Description</th>
          <th scope="col" style="width: 50px">Price</th>
          <th scope="col" style="width: 100px">Doc #</th>
          <th scope="col" style="width: 100px">HCopy</th>
          <th scope="col" style="width: 50px">Qty Returned</th>
          <th scope="col" style="width: 100px">Unit</th>
          <th scope="col" style="width: 50px">Qty Inspect</th>
          <th scope="col" style="width: 100px">Date</th>
          <th scope="col" style="width: 50px">Good Condition</th>
          <th scope="col" style="width: 50px">Minor Repair/Clean</th>
          <th scope="col" style="width: 50px">Repair/Parts Needed</th>
          <th scope="col" style="width: 50px">Damaged</th>
          <th scope="col">Comments</th>

          <th scope="col" v-if="canEditCpo" style="width: 100px">Actions</th>
        </tr>
      </thead>
      <tbody>
        <header-line
          v-for="(line, index) in lines"
          :key="line.id"
          :line-number="index + 1"
          :line-details="line"
          :header-is-locked="headerIsLocked"
          :items-uom="items_uom"
          @delete-line="getCpoLines"
          @selectItemFor="selectOracleItem"
        ></header-line>
      </tbody>
    </table>
    <hr />
    <div class="col-12 text-center">
      <div class="btn-group" v-if="!headerIsLocked && canEditCpo">
        <button
          class="btn btn-primary"
          type="button"
          :disabled="isInsertingNewLine || isSavingAllLines"
          @click="addNewLine"
        >
          <span> Add new line</span>
          <span
            v-if="isInsertingNewLine"
            class="spinner-border spinner-border-sm"
          ></span>
        </button>

        <button
          class="btn btn-success"
          type="button"
          @click="saveAllLines"
          :disabled="isSavingAllLines || isInsertingNewLine"
          v-if="lines.length > 0"
        >
          <span> Save All lines </span>
          <span
            v-if="isSavingAllLines"
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true"
          ></span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import headerLine from "./headerLine.vue";
import { mapGetters } from "vuex";
import SelectOracleItemInput from "../Modals/SelectOracleItemInput.vue";
export default {
  components: {
    headerLine,
    SelectOracleItemInput,
  },
  // props: ["headerId", "headerIsLocked"],
  inject: ["showNotification"],
  props: {
    headerId: {
      type: Number,
      required: true,
    },
    headerIsLocked: {
      type: Boolean,
      required: true,
    },
  },
  computed: {
    ...mapGetters("auth", ["canEditCpo"]),
  },
  data() {
    return {
      lines: [],
      items_uom: [],
      isInsertingNewLine: false,
      isSavingAllLines: false,
      isSelectingOracleItem: false,
      selectItemForLineNumber: null,
    };
  },

  methods: {
    itemSelected(item) {
      const targetItem = this.lines.find(
        (line) => line.line_number === this.selectItemForLineNumber
      );
      targetItem.description = item.description;
      targetItem.price = item.list_price;
      targetItem.unit = item.primary_uom_code;
      // console.log(this.lines);

      this.lines = [
        ...this.lines.filter(
          (line) => line.line_number !== targetItem.line_number
        ),
        targetItem,
      ];
      // console.log(this.lines);
      this.lines.sort((a, b) => a.line_number - b.line_number);

      this.showNotification({
        message: `Line# ${this.selectItemForLineNumber} - ${item.description} has been updated. Price: ${item.list_price}, Unit: ${item.primary_uom_code}`,
        type: "success",
      });
      this.isSelectingOracleItem = false;
    },
    selectOracleItem(forLineNumber) {
      // console.log(forLineNumber);
      this.selectItemForLineNumber = forLineNumber;
      this.isSelectingOracleItem = true;
    },
    closeModal() {
      this.isSelectingOracleItem = false;
    },
    async addNewLine() {
      this.isInsertingNewLine = true;
      try {
        await axios.post("api/cpoline/", { id: this.headerId });

        this.getCpoLines();

        this.showNotification({
          message: `Line# ${this.lines.length + 1} - New empty line was added`,
          type: "info",
        });
        // console.log(this.lineDetails);
      } catch (error) {
        console.log(err);
      } finally {
        this.isInsertingNewLine = false;
      }
    },
    async saveAllLines() {
      try {
        this.isSavingAllLines = true;
        this.$emit("updatingLines");
        await axios.post("api/cpo/lines/updateAllLines/", {
          cpoId: this.headerId,
          cpoLines: this.lines,
        });
        this.showNotification({
          message: "All lines were saved",
          type: "success",
        });
      } catch (error) {
        console.log(error.message);
      } finally {
        this.isSavingAllLines = false;
        this.$emit("updatedLines");
      }
    },
    async getCpoLines() {
      try {
        const res = await axios.get("api/cpo/lines/" + this.headerId);

        this.lines = res.data.lines;
        this.items_uom = res.data.items_uom;
      } catch (error) {
        console.log(error.message);
        // alert(error.message);
      }
    },
  },
  mounted() {
    this.getCpoLines();
    // console.log("headerId: " + this.headerId);
  },
};
</script>

<style></style>
