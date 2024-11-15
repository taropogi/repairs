<template>
  <tr>
    <th scope="row">{{ lineDetails.line_number }}</th>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="isDisabled"
        v-model="lineDetails.description"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="lineDetails.price"
        :disabled="isDisabled"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="lineDetails.hcopy"
        :disabled="isDisabled"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="lineDetails.qty_returned"
        :disabled="isDisabled"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="lineDetails.unit"
        :disabled="isDisabled"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="lineDetails.qty_inspect"
        :disabled="isDisabled"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="isDisabled"
        v-model="lineDetails.date"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="isDisabled"
        v-model="lineDetails.good_condition"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="isDisabled"
        v-model="lineDetails.minor_repair_clean"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="isDisabled"
        v-model="lineDetails.repair_parts_needed"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="isDisabled"
        v-model="lineDetails.damaged"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="isDisabled"
        v-model="lineDetails.comments"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="isDisabled"
        v-model="lineDetails.order_number"
      />
    </td>
    <td v-if="canEditCpo">
      <span class="badge bg-secondary" v-if="headerIsLocked">LOCKED</span>
      <div class="btn-group btn-group-sm" role="group" v-else>
        <button
          type="button"
          class="btn btn-primary"
          @click="saveLine"
          :disabled="lineUpdating || isDeleting"
        >
          <span v-if="!lineUpdating">Save</span>
          <span v-else class="spinner-border spinner-border-sm"> </span>
        </button>

        <button
          type="button"
          class="btn btn-danger"
          @click="deleteLine"
          :disabled="lineUpdating || isDeleting"
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
  props: ["lineDetails", "headerIsLocked"],

  data() {
    return {
      lineUpdating: false,
      isDeleted: false,
      isDeleting: false,
    };
  },

  computed: {
    ...mapGetters("auth", ["canEditCpo"]),
    isDisabled() {
      return this.headerIsLocked || !this.canEditCpo;
    },
    showTr() {
      return !this.lineUpdating;
    },
  },

  methods: {
    async saveLine() {
      //locally save
      this.lineUpdating = true;
      //  console.log(this.lineDetailsLocal);
      try {
        await axios.post("api/cpoline/update/", this.lineDetails);
      } catch (error) {
        console.log(error.message);
      } finally {
        this.lineUpdating = false;
      }

      // this.$emit("saveLine", this.lineDetailsLocal);
    },
    async deleteLine() {
      try {
        this.isDeleting = true;
        await axios.post("api/cpoline/destroy/", {
          id: this.lineDetails.id,
        });

        //    this.isDeleted = true;
        this.$emit("deleteLine", this.lineDetails.id);
        //console.log(res);
        //  this.getCpoHeaderRow();
      } catch (error) {
        console.log(error.message);
      } finally {
        this.isDeleting = false;
      }
    },
  },
};
</script>
