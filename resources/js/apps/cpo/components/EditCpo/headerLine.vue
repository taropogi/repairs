<template>
  <tr>
    <th scope="row">{{ lineDetails.line_number }}</th>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="headerIsLocked"
        v-model="lineDetails.description"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="lineDetails.price"
        :disabled="headerIsLocked"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="lineDetails.hcopy"
        :disabled="headerIsLocked"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="lineDetails.qty_returned"
        :disabled="headerIsLocked"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="lineDetails.unit"
        :disabled="headerIsLocked"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        v-model="lineDetails.qty_inspect"
        :disabled="headerIsLocked"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="headerIsLocked"
        v-model="lineDetails.date"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="headerIsLocked"
        v-model="lineDetails.good_condition"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="headerIsLocked"
        v-model="lineDetails.minor_repair_clean"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="headerIsLocked"
        v-model="lineDetails.repair_parts_needed"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="headerIsLocked"
        v-model="lineDetails.damaged"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="headerIsLocked"
        v-model="lineDetails.comments"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control form-control-sm"
        :disabled="headerIsLocked"
      />
    </td>
    <td>
      <span class="badge bg-secondary" v-if="headerIsLocked">LOCKED</span>
      <div class="btn-group btn-group-sm" role="group" v-else>
        <button
          type="button"
          class="btn btn-primary"
          @click="saveLine"
          v-if="!lineUpdating"
        >
          Save
        </button>
        <button class="btn btn-primary" type="button" disabled v-else>
          <span class="spinner-border spinner-border-sm"></span>
        </button>
        <button
          type="button"
          class="btn btn-danger"
          @click="deleteLine"
          v-if="!isDeleting"
        >
          Delete
        </button>
        <button class="btn btn-danger" type="button" disabled v-else>
          <span class="spinner-border spinner-border-sm"></span>
        </button>
      </div>
    </td>
  </tr>
</template>

<script>
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
    isLocked() {
      return {
        disabled: this.headerIsLocked,
      };
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
    deleteLine() {
      this.isDeleting = true;
      axios
        .post("api/cpoline/destroy/", {
          id: this.lineDetails.id,
        })
        .then((res) => {
          //    this.isDeleted = true;
          this.$emit("deleteLine", this.lineDetails.id);
          //console.log(res);
          //  this.getCpoHeaderRow();
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
