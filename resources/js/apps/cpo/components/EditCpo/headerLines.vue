<template>
  <div>
    <table
      class="table table-sm table-hover table-borderless"
      v-if="lines.length > 0"
    >
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

          <th scope="col" v-if="canEditCpo">Actions</th>
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
        ></header-line>
      </tbody>
    </table>

    <div class="btn-group btn-group-sm" v-if="!headerIsLocked && canEditCpo">
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
</template>

<script>
import headerLine from "./headerLine.vue";
import { mapGetters } from "vuex";
export default {
  components: {
    headerLine,
  },
  // props: ["headerId", "headerIsLocked"],
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
    };
  },

  methods: {
    async addNewLine() {
      this.isInsertingNewLine = true;
      try {
        await axios.post("api/cpoline/", { id: this.headerId });

        this.getCpoLines();

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
