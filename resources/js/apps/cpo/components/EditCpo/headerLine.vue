<template>
  <tr :class="{ blink: isUpdated, 'blink-deleted': isDeleted }">
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
        :disabled="isDisabled"
        v-model="lineDetails.order_number"
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
      <div v-if="itemsUom.length > 0">
        <!-- <input
          type="text"
          class="form-control form-control-sm"
          v-model="lineDetails.unit"
          :disabled="isDisabled"
        /> -->
        <!-- loop items_uom prop here as dropdown -->
        <select
          class="form-select form-select-sm"
          v-model="lineDetails.unit"
          :disabled="isDisabled"
        >
          <option
            v-for="uom in itemsUom"
            :key="uom"
            :value="uom.primary_uom_code"
          >
            {{ uom.primary_uom_code }} - {{ uom.primary_unit_of_measure }}
          </option>
        </select>
      </div>
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

    <td v-if="canEditCpo">
      <span class="badge bg-secondary" v-if="headerIsLocked">LOCKED</span>
      <div class="btn-group btn-group-sm" role="group" v-else>
        <button
          type="button"
          class="btn btn-primary py-0"
          @click="saveLine"
          :disabled="lineUpdating || isDeleting"
        >
          <span v-if="!lineUpdating"> Save</span>
          <span v-else class="spinner-border spinner-border-sm"> </span>
        </button>

        <button
          type="button"
          class="btn btn-danger py-0"
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
  props: ["lineDetails", "headerIsLocked", "itemsUom"],

  data() {
    return {
      lineUpdating: false,
      isDeleted: false,
      isDeleting: false,
      isUpdated: false,
    };
  },

  computed: {
    ...mapGetters("auth", ["canEditCpo"]),
    isDisabled() {
      return (
        this.headerIsLocked ||
        !this.canEditCpo ||
        this.lineUpdating ||
        this.isDeleting
      );
    },
    showTr() {
      return !this.lineUpdating;
    },
  },

  methods: {
    blinkTr(isDelete = false) {
      if (isDelete) {
        this.isDeleted = true;
      } else {
        this.isUpdated = true;
      }

      setTimeout(
        () => {
          if (isDelete) {
            // this.isDeleted = false;
          } else {
            this.isUpdated = false;
          }

          if (isDelete) {
            this.$emit("deleteLine", this.lineDetails.id);
          }
        },
        isDelete ? 500 : 2000
      ); // 1 second
    },
    async saveLine() {
      //locally save
      this.lineUpdating = true;
      console.log(this.lineDetails);
      try {
        const res = await axios.post("api/cpoline/update/", this.lineDetails);
        this.blinkTr();
        // console.log(res);
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

        this.blinkTr(true);
      } catch (error) {
        console.log(error.message);
      } finally {
        this.isDeleting = false;
      }
    },
  },
};
</script>

<style scoped>
@keyframes blink-deleted {
  0% {
    background-color: transparent;
  }
  50% {
    background-color: red;
  }
  100% {
    background-color: transparent;
  }
}

.blink-deleted {
  animation: blink-deleted 0.5s ease-in-out;
}

@keyframes blink {
  0% {
    background-color: transparent;
  }
  50% {
    background-color: rgba(40, 167, 69, 1);
  }
  100% {
    background-color: transparent;
  }
}

.blink {
  animation: blink 2s ease-in-out;
}
</style>
