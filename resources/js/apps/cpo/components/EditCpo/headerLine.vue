<template>
  <tr :class="{ blink: isUpdated, 'blink-deleted': isDeleted }">
    <th scope="row">{{ lineDetails.line_number }}</th>
    <td>
      <item-input-description
        v-model="lineDetails.description"
        :is-disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('description') || isAdmin)
        "
        @select-item-for="$emit('select-item-for', lineDetails.line_number)"
        @item-searched="
          (item) => {
            lineDetails.unit = item?.primary_uom_code ?? lineDetails.unit;
          }
        "
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control"
        v-model="lineDetails.price"
        :disabled="
          isDisabled || !(editLineFieldsPermission.includes('price') || isAdmin)
        "
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('order_number') || isAdmin)
        "
        v-model="lineDetails.order_number"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('doc_date') || isAdmin)
        "
        v-model="lineDetails.doc_date"
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control"
        v-model="lineDetails.hcopy"
        :disabled="
          isDisabled || !(editLineFieldsPermission.includes('hcopy') || isAdmin)
        "
      />
    </td>
    <td>
      <input
        type="number"
        class="form-control"
        v-model="lineDetails.qty_returned"
        @input="validateQty('qty_returned')"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('qty_returned') || isAdmin)
        "
      />
    </td>
    <td>
      <div
        v-if="
          (itemsUom.length > 0 && editLineFieldsPermission.includes('unit')) ||
          isAdmin
        "
      >
        <select
          class="form-select"
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
      <span v-else>
        <input
          type="text"
          class="form-control"
          :disabled="true"
          v-model="lineDetails.unit"
        />
      </span>
    </td>
    <td>
      <input
        type="number"
        class="form-control"
        v-model="lineDetails.qty_inspect"
        @input="validateQty('qty_inspect')"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('qty_inspect') || isAdmin)
        "
      />
    </td>
    <td>
      <input
        type="text"
        class="form-control"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('date_inspected') || isAdmin)
        "
        v-model="lineDetails.date_inspected"
      />
    </td>
    <td>
      <input
        type="number"
        class="form-control"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('good_condition') || isAdmin)
        "
        v-model="lineDetails.good_condition"
        @input="validateQty('good_condition')"
      />
    </td>
    <td>
      <input
        type="number"
        class="form-control"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('minor_repair_clean') || isAdmin)
        "
        v-model="lineDetails.minor_repair_clean"
        @input="validateQty('minor_repair_clean')"
      />
    </td>
    <td>
      <input
        type="number"
        class="form-control"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('repair_parts_needed') || isAdmin)
        "
        v-model="lineDetails.repair_parts_needed"
        @input="validateQty('repair_parts_needed')"
      />
    </td>
    <td>
      <input
        type="number"
        class="form-control"
        :disabled="
          isDisabled ||
          !(editLineFieldsPermission.includes('damaged') || isAdmin)
        "
        v-model="lineDetails.damaged"
        @input="validateQty('damaged')"
      />
    </td>
    <td class="comment-cell">
      <input
        type="text"
        class="form-control comment-input"
        :disabled="isDisabled"
        v-model="lineDetails.user_comment"
        v-if="editLineFieldsPermission.includes('comments') || isAdmin"
      />
      <!-- @focus="expandCell"
      @blur="shrinkCell" -->
      <div v-if="lineDetails.other_comments.length > 0 && !isCommentExpanded">
        <div
          class="my-0"
          v-for="comment in lineDetails.other_comments"
          :key="comment.id"
        >
          <p class="m-0 p-0 text-sm" v-if="comment.comment.trim() !== ''">
            <strong class="text-danger text-sm"
              >{{ comment.commented_by }}:</strong
            >
            {{ comment.comment }}
          </p>
        </div>
      </div>
      <p
        class="text-muted"
        v-if="
          lineDetails.other_comments.length == 0 &&
          !(editLineFieldsPermission.includes('comments') || isAdmin)
        "
      >
        --
      </p>
    </td>

    <td v-if="canEditCpo">
      <span class="badge bg-secondary" v-if="headerIsLocked">LOCKED</span>
      <div class="nowrap" v-else>
        <button
          v-if="false"
          type="button"
          class="btn btn-primary py-1 mx-1"
          @click="saveLine"
          :disabled="lineUpdating || isDeleting"
        >
          <span v-if="!lineUpdating" class="nowrap">
            <i class="bi bi-save"></i>
            Save</span
          >
          <span v-else class="spinner-border spinner-border-sm"> </span>
        </button>

        <button
          type="button"
          class="btn btn-danger py-1"
          @click="deleteLine"
          :disabled="lineUpdating || isDeleting"
        >
          <span v-if="!isDeleting" class="nowrap">
            <i class="bi bi-trash"></i>
          </span>
          <span class="spinner-border spinner-border-sm" v-else></span>
        </button>
      </div>
    </td>
  </tr>
</template>

<script>
import debounce from "lodash/debounce";
import ItemInputDescription from "../UI/ItemInputDescription.vue";
import { mapGetters } from "vuex";
export default {
  props: ["lineDetails", "headerIsLocked", "itemsUom"],
  components: { ItemInputDescription },

  data() {
    return {
      lineUpdating: false,
      isDeleted: false,
      isDeleting: false,
      isUpdated: false,
      isSearchingSegment6: false,
      isCommentExpanded: false,
    };
  },
  inject: ["showNotification"],
  emits: ["delete-line", "saveLine", "select-item-for"],
  computed: {
    ...mapGetters("auth", [
      "canEditCpo",
      "editLineFieldsPermission",
      "isAdmin",
    ]),
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
    expandCell(event) {
      event.target.closest("td").classList.add("expanded");
      this.isCommentExpanded = true;
    },
    shrinkCell(event) {
      event.target.closest("td").classList.remove("expanded");
      this.isCommentExpanded = false;
    },
    validateQty(field) {
      if (this.lineDetails[field] < 0) {
        this.lineDetails[field] = 0;
      }
    },
    blinkTr(isDelete = false) {
      if (isDelete) {
        this.isDeleted = true;
      } else {
        this.isUpdated = true;
      }

      // setTimeout(
      //   () => {
      //     if (isDelete) {
      //       // this.isDeleted = false;
      //     } else {
      //       this.isUpdated = false;
      //     }

      //     if (isDelete) {
      //       this.$emit("delete-line", this.lineDetails.id);
      //     }
      //   },
      //   isDelete ? 500 : 2000
      // ); // 1 second
    },
    async saveLine() {
      //locally save
      this.lineUpdating = true;
      try {
        const res = await axios.post("api/cpoline/update/", this.lineDetails);
        this.blinkTr();
        this.showNotification({
          message: `Line# ${this.lineDetails.line_number} has been updated`,
          type: "success",
        });

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
        const res = await axios.post("api/cpoline/destroy/", {
          id: this.lineDetails.id,
        });

        console.log("emit delete line", res.data.cpo);
        this.$emit("delete-line", res.data.cpo);

        // this.blinkTr(true);
        this.showNotification({
          message: `Line# ${this.lineDetails.line_number} has been deleted`,
          type: "error",
        });
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

.comment-cell {
  position: relative;
  transition: all 0.3s ease;
}

.comment-cell.expanded {
  position: absolute;
  right: 150px;
  width: 300px; /* Adjust the width as needed */
  z-index: 10; /* Ensure it overlaps other cells */
  background-color: red; /* Optional: Add background color to distinguish */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: Add shadow for better visibility */
}

.comment-input {
  width: 100%;
}

.comment-cell.expanded .comment-input {
  width: 100%;
}
</style>
